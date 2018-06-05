<?php

namespace ObjectivePHP\DocuMentor\Tags;

use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;

/**
 * Reflection class for the {@}config-example-value tag in a Docblock.
 */
class ConfigExampleValue extends BaseTag implements StaticMethod
{
    /**
     * @var string
     */
    protected $name = 'config-example-value';

    /**
     * @var mixed
     */
    protected $exampleValue;

    /**
     * Para constructor.
     * @param string $exampleValue
     */
    public function __construct($exampleValue = null)
    {
        $this->exampleValue = $exampleValue;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, TypeResolver $typeResolver = null, DescriptionFactory $descFactory = null, TypeContext $context = null)
    {
        error_log('--------------------');
        error_log($body);




        /*Assert::stringNotEmpty($body);
        Assert::allNotNull([$typeReso‡lver, $descFactory]);

        $parts = preg_split('~(?:\'[^\']*\'|"[^"]*")(*SKIP)(*F)|\h+~', $body, 3, PREG_SPLIT_DELIM_CAPTURE);

        $type = $typeResolver->resolve(trim($parts[0], '"\''));
        $variableName = trim($parts[0], '"\'');
        $defValue = trim($parts[1], '"\'');
        $desc = trim($parts[2], '"\'');
*/
        //        error_log($body);

        //        $json = json_decode($body);
        //        if (json_last_error() == JSON_ERROR_NONE) {
        //            error_log($json);
        //        }
        //            error_log($json);
        //        $body = trim(str_replace('"', '\'', $body), '\'');

        return new static($body);
    }

    /**
     * Returns the example value.
     *
     * @return mixed
     */
    public function getExampleValue()
    {
        return $this->exampleValue;
    }

    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->exampleValue) ?: '';
    }
}
