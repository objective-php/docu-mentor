<?php

namespace ObjectivePHP\DocuMentor;

use ObjectivePHP\Config\Directive\ComplexDirectiveInterface;
use ObjectivePHP\Config\Directive\DirectiveInterface;
use ObjectivePHP\Config\Directive\MultiValueDirectiveInterface;
use ObjectivePHP\DocuMentor\Exception\DirectiveStructureException;
use ObjectivePHP\DocuMentor\Exception\TagSyntaxException;
use ObjectivePHP\DocuMentor\Tags\ConfigAttribute;
use ObjectivePHP\DocuMentor\Tags\ConfigExampleValue;
use ObjectivePHP\DocuMentor\Tags\ConfigIndex;
use ObjectivePHP\Matcher\Exception;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Finder\Finder;

class DocuMentor
{

    /**
     * @var Exception[]
     */
    protected $report = [];

    /**
     * @var string
     */
    protected $componentName = '';

    /**
     * @var DocBlockFactory
     */
    protected $docBlockFactory;

    /**
     * DocuMentor constructor.
     */
    public function __construct()
    {
        $customTags = ['config-attribute'     => ConfigAttribute::class,
                       'config-index'         => ConfigIndex::class,
                       'config-example-value' => ConfigExampleValue::class];
        $this->docBlockFactory = DocBlockFactory::createInstance($customTags);
        $this->componentName = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true)['name'];
    }

    /**
     * @param String $configDirectory
     * @param String $docsDirectory
     * @return bool
     */
    public function collectDirectiveConfigs(String $configDirectory = __DIR__ . '/Config', String $docsDirectory = __DIR__ . '/../docs'): bool
    {
        try {
            $finder = new Finder();
            $finder->files()->in($configDirectory)->name('*.php');

            $res = "# Config directives in $this->componentName \n\n";
            foreach ($finder as $file) {
                try {
                    $reflectionFile = new ReflectionFile($file->getRealPath());
                    $fqcn = $reflectionFile->getNamespace();
                    if (!($directiveKey = $reflectionFile->getMethod('getKey')->invoke(new $fqcn()))) {
                        throw new DirectiveStructureException('No KEY found in ' . $file->getFilename());
                    }
                    // S'il sagit bien d'une directive
                    if (\in_array(DirectiveInterface::class, $interfaces = $reflectionFile->getInterfaceNames(), true)) {
                        if (!($docBlock = $reflectionFile->getDocComment())) {
                            $docBlock = '/***/';
                        }
                        $classDocBlock = $this->docBlockFactory->create($docBlock);
                        $tab = $exempleIndex = $valuesExample = null;

                        $res .= '## ' . $fqcn . "\n\n";
                        $res .= $classDocBlock->getSummary() . "\n\n\n";
                        $res .= '**KEY:** ' . $directiveKey . ' **TYPE:** ' .
                            ($isMulti = \in_array(MultiValueDirectiveInterface::class, $interfaces, true) ? 'Multi ' : '') .
                            (\in_array(ComplexDirectiveInterface::class, $interfaces, true) ? 'Complex ' : 'Scalar ') .
                            " \n\n";
                        $res .= $classDocBlock->getDescription()->render() . "\n\n";

                        foreach ($reflectionFile->getProperties() as $property) {
                            try {
                                $reflectionProperty = $reflectionFile->getProperty($propertyName = $property->name);
                                if ($docComment = $reflectionProperty->getDocComment()) {
                                    $docBlock = $this->docBlockFactory->create($docComment);
                                    if ($docBlock->hasTag('config-index')) {
                                        $exempleIndex = $docBlock->getTagsByName('config-index')[0]->getExampleIndex();
                                        if ($docBlock->getTagsByName('config-example-value')) {
                                            $valuesExample = $this->getExample($docBlock, $reflectionProperty, $fqcn);
                                        }
                                    } elseif ($docBlock->hasTag('config-attribute')) {
                                        isset($tab) ?: $tab = 'Property | Type | Example value | Summary | Description' . "\n" . '--- | --- | --- | --- | ---' . "\n";
                                        $tab .= $propertyName . '|' . $this->getPropertyType($docBlock) . '|' . json_encode($this->getExample($docBlock, $reflectionProperty, $fqcn), JSON_UNESCAPED_SLASHES) . '|' . $docBlock->getSummary() . '|' . preg_replace("/\r|\n/", ' ', $docBlock->getDescription()->render()) . "\n";
                                        $valuesExample[$propertyName] = $this->getExample($docBlock, $reflectionProperty, $fqcn);
                                    }
                                } else {
                                    throw new TagSyntaxException('You didn\'t comment this property ! ' . $propertyName . ' in ' . $reflectionFile->getFileName());
                                }
                            } catch (\Exception $exception) {
                                $this->report[] = $exception;
                            }
                        }
                        $res .= $tab;
                        if ($isMulti) {
                            if ($exempleIndex) {
                                $valuesExample = [$exempleIndex => $valuesExample];
                            } else {
                                throw new DirectiveStructureException('You didn\'t overload the $reference or didn\'t comment it correctly in ' . $reflectionFile->getFileName());
                            }
                        }
                        $res .= "\n```json  \n" . json_encode([$directiveKey => $valuesExample], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n```\n";
                    }
                } catch (\Exception $exception) {
                    $this->report[] = $exception;
                }
            }
            if (file_put_contents($docsDirectory . '/03.config-directives.md', $res)) {
                return true;
            }
        } catch (\Exception $exception) {
            $this->report[] = $exception;
            return false;
        }
        return false;
    }


    /**
     * @param DocBlock $docBlock
     * @return string
     * @throws TagSyntaxException
     */
    public function getPropertyType(DocBlock $docBlock): string
    {
        $type = 'No type not ok !';
        if ($tags = $docBlock->getTagsByName('config-attribute')) {
            if ($type = $tags[0]->getType()) {
            } else {
                //Pas de type renseigné, on prend celui de @var
                if ($tags = $docBlock->getTagsByName('var')) {
                    if (!($type = $tags[0]->getType())) {
                        throw new TagSyntaxException('neither @var or @config-attribute or no type');
                    }
                }
            }
        }
        return trim($type, '\\');
    }

    /**
     * @throws TagSyntaxException
     */
    public function getExample(DocBlock $docBlock, \ReflectionProperty $reflectionProperty, String $fqcn)
    {
        if ($tags = $docBlock->getTagsByName('config-example-value')) {
            if ($tags[0]->getExampleValue()) {
                $body = '';
                foreach ($tags as $tag) {
                    $body .= $tag->getExampleValue();
                }

                if ($body === 'true' || $body === 'false') {        //Gerer les boolean
                    $example = $body === 'true';
                } elseif (0 === strpos($body, 'array(')) {  //Gerer les tableaux
                    $example = eval('return ' . $body . ';');
                } elseif (0 === strpos($body, '{')) {       //Gerer objet JSON
                    $example = json_decode($body, true);
                } else {                                            //Gerer string
                    $example = trim($body, '\'"');
                }
            } else {
                throw new TagSyntaxException('@config-example-value needs an example like this :  @config-example-value  string');
            }
        } else {
            $reflectionProperty->setAccessible(true);
            $example = $reflectionProperty->getValue(new $fqcn);
        }

        return $example;
    }

    /**
     * @param String $docsDirectory
     * @param bool   $force
     * @return bool
     */
    public function initDocumentation(String $docsDirectory = __DIR__ . '/../docs', $force = false): bool
    {
        try {
            $finder = new Finder();
            $finder->files()->in(__DIR__ . '/docs')->name('*.md');

            if (is_dir($docsDirectory) && !$force) {
                throw new \Exception('You already have a docs folder');
            } else {
                if (!is_dir($docsDirectory) && !mkdir($docsDirectory, 0755, true) && !is_dir($docsDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $docsDirectory));
                }
                foreach ($finder as $file) {
                    $content = str_replace('{{REPO-NAME}}', $this->componentName, $file->getContents());
                    file_put_contents($docsDirectory . '/' . $file->getFilename(), $content);
                }
            }
        } catch (\Exception $exception) {
            $this->report[] = $exception;
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getComponentName(): string
    {
        return $this->componentName;
    }

    /**
     * @return array
     */
    public function getReport(): array
    {
        return $this->report;
    }
}
