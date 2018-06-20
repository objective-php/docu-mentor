<?php

namespace ObjectivePHP\DocuMentor;

use ObjectivePHP\Config\Directive\DirectiveInterface;
use ObjectivePHP\Config\Directive\IgnoreDefaultInterface;
use ObjectivePHP\Config\Directive\MultiValueDirectiveInterface;
use ObjectivePHP\Config\Directive\ScalarDirectiveInterface;
use ObjectivePHP\DocuMentor\Exception\DirectiveStructureException;
use ObjectivePHP\DocuMentor\Exception\TagSyntaxException;
use ObjectivePHP\DocuMentor\Tags\ConfigAttribute;
use ObjectivePHP\DocuMentor\Tags\ConfigExampleValue;
use ObjectivePHP\DocuMentor\Tags\ConfigExampleReference;
use ObjectivePHP\Matcher\Exception;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Finder\Finder;

/**
 * Class DocuMentor
 *
 * @package ObjectivePHP\DocuMentor
 */
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
     * @var string
     */
    protected $docsDirectory;

    /**
     * @var String
     */
    private $configDirectory;

    /**
     * DocuMentor constructor.
     *
     * @param String $docsDirectory
     * @param String $configDirectory
     */
    public function __construct(
        String $docsDirectory = __DIR__ . '/../docs',
        String $configDirectory = __DIR__ . '/Config'
    ) {
        $this->docsDirectory = $docsDirectory;
        $this->configDirectory = $configDirectory;
        if (!is_dir($this->docsDirectory)
            && !mkdir($this->docsDirectory, 0755, true)
            && !is_dir($this->docsDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->docsDirectory));
        }
        $customTags = [
            'config-attribute'         => ConfigAttribute::class,
            'config-example-value'     => ConfigExampleValue::class,
            'config-example-reference' => ConfigExampleReference::class
        ];
        $this->docBlockFactory = DocBlockFactory::createInstance($customTags);
        $this->componentName = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true)['name'];
        $this->docsDirectory = $docsDirectory;
        $this->configDirectory = $configDirectory;
    }

    /**
     * @return bool
     */
    public function collectDirectiveConfigs(): bool
    {
        try {
            $finder = new Finder();
            $finder->files()->in($this->configDirectory)->name('*.php');

            $res = "# Config directives in $this->componentName \n\n";
            foreach ($finder as $file) {
                try {
                    $reflectionFile = new ReflectionFile($file->getRealPath());
                    $fqcn = $reflectionFile->getNamespace();
                    if (!($directiveKey = $reflectionFile->getMethod('getKey')->invoke(new $fqcn()))) {
                        throw new DirectiveStructureException('No KEY found in ' . $file->getFilename());
                    }
                    // S'il sagit bien d'une directive
                    if (\in_array(
                        DirectiveInterface::class,
                        $interfaces = $reflectionFile->getInterfaceNames(),
                        true
                    )) {
                        if (!($docBlock = $reflectionFile->getDocComment())) {
                            $docBlock = '/***/';
                        }
                        $classDocBlock = $this->docBlockFactory->create($docBlock);
                        $tab = $exempleIndex = $valuesExample = null;

                        $res .= '## ' . $fqcn . "\n\n";
                        $res .= $classDocBlock->getSummary() . "\n\n\n";
                        $res .= '**KEY:** ' . $directiveKey . ' **TYPE:** ' .
                            (($isMulti = \in_array(
                                MultiValueDirectiveInterface::class,
                                $interfaces,
                                true
                            )) ? 'Multi ' : '') .
                            (($isScalar = \in_array(
                                ScalarDirectiveInterface::class,
                                $interfaces,
                                true
                            )) ? 'Scalar ' : 'Complex ') .
                            (\in_array(
                                IgnoreDefaultInterface::class,
                                $interfaces,
                                true
                            ) ? ' **|** Ignore Default' : '') . " \n\n";
                        $res .= $classDocBlock->getDescription()->render() . "\n\n";

                        if ($isScalar) {
                            if ($classDocBlock->hasTag('config-example-value')) {
                                $tmp = '';
                                foreach ($classDocBlock->getTagsByName('config-example-value') as $val) {
                                    $tmp .= trim($val->getValue(), '\'"');
                                }
                                $valuesExample = $tmp;

                                if ($isMulti && $classDocBlock->hasTag('config-example-reference')) {
                                    $exempleIndex = trim(
                                        $classDocBlock->getTagsByName('config-example-reference')[0]->getValue(),
                                        '\'"'
                                    );
                                }
                            }
                        } else {
                            foreach ($reflectionFile->getProperties() as $property) {
                                try {
                                    $reflectionProperty = $reflectionFile->getProperty($propertyName = $property->name);
                                    if ($docComment = $reflectionProperty->getDocComment()) {
                                        $docBlock = $this->docBlockFactory->create($docComment);
                                        if ($docBlock->hasTag('config-example-reference')) {
                                            $exempleIndex = $this->getExample(
                                                $docBlock->getTagsByName('config-example-reference'),
                                                $reflectionProperty,
                                                $fqcn
                                            );
                                        } elseif ($docBlock->hasTag('config-attribute')) {
                                            $example = $this->getExample(
                                                $docBlock->getTagsByName('config-example-value'),
                                                $reflectionProperty,
                                                $fqcn
                                            );
                                            isset($tab) ?: $tab = 'Property | Type | Description | Example value' . "\n"
                                                . '--- | --- | --- | ---' . "\n";
                                            $tab .= $propertyName . '|' .
                                                $this->getPropertyType($docBlock) . '|' .
                                                $docBlock->getSummary() . '<br/>' .
                                                preg_replace("/\r|\n/", ' ', $docBlock->getDescription()->render()) .
                                                '|<pre><code class="json">' .
                                                json_encode($example, JSON_UNESCAPED_SLASHES) . "</code></pre>\n";
                                            $valuesExample[$propertyName] = $example;
                                        }
                                    } else {
                                        throw new TagSyntaxException('You didn\'t comment this property ! ' . $propertyName . ' in ' . $reflectionFile->getFileName());
                                    }
                                } catch (\Exception $exception) {
                                    $this->report[] = $exception;
                                }
                            }
                        }
                        $res .= $tab;
                        $res .= "\n```json  \n" .
                            json_encode(
                                [$directiveKey => $isMulti ? [$exempleIndex => $valuesExample] : $valuesExample],
                                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                            ) . "\n```\n";
                    }
                } catch (\Exception $exception) {
                    $this->report[] = $exception;
                }
            }
            if (file_put_contents($this->docsDirectory . '/03.config-directives.md', $res)) {
                return true;
            }
        } catch (\Exception $exception) {
            $this->report[] = $exception;
        }

        return false;
    }


    /**
     * @param DocBlock $docBlock
     *
     * @return string
     * @throws TagSyntaxException
     */
    public function getPropertyType(DocBlock $docBlock): string
    {
        $type = 'No type not ok !';
        if ($tags = $docBlock->getTagsByName('config-attribute')) {
            if (!$type = $tags[0]->getType()) {
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
     * @param mixed               $tags
     * @param \ReflectionProperty $reflectionProperty
     * @param String              $fqcn
     *
     * @return bool|mixed|string
     * @throws TagSyntaxException
     */
    public function getExample($tags, \ReflectionProperty $reflectionProperty, String $fqcn)
    {
        $body = '';
        foreach ($tags as $tag) {
            $body .= $tag->getValue();
        }

        if ($body) {
            if (preg_match('/^array\(.*\)$|^{.*}$/', $body)) {
                $body = preg_replace(['/^(array\()/', '/(\')/', '/(\))$/'], ['[', '"', ']'], $body);
                if (!($res = json_decode($body, true))) {
                    throw new TagSyntaxException("@" . $tag->getName() . " of\e[31m \$$reflectionProperty->name \e[0mas a bad syntax : $body\n in " . $fqcn);
                }

                return $res;
            }

            return trim($body, '\'"');
        }
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue(new $fqcn);
    }

    /**
     * @param bool $force
     *
     * @return bool
     */
    public function initDocumentation($force = false): bool
    {
        try {
            $finder = new Finder();
            $finder->files()->in(__DIR__ . '/docs')->name('*.md');

            if (is_dir($this->docsDirectory) && !$force) {
                throw new \Exception('You already have a docs folder');
            } else {
                if (!is_dir($this->docsDirectory) && !mkdir($this->docsDirectory, 0755,
                        true) && !is_dir($this->docsDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->docsDirectory));
                }
                foreach ($finder as $file) {
                    $content = str_replace('{{REPO-NAME}}', $this->componentName, $file->getContents());
                    file_put_contents($this->docsDirectory . '/' . $file->getFilename(), $content);
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
