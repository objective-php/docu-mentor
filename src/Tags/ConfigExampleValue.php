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
    protected $value;

    /**
     * Para constructor.
     * @param string $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, TypeResolver $typeResolver = null, DescriptionFactory $descFactory = null, TypeContext $context = null)
    {
        return new static($body);
    }

    /**
     * Returns the example value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->value) ?: '';
    }
}
