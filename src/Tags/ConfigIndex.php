<?php

namespace ObjectivePHP\DocuMentor\Tags;

use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;

/**
 * Reflection class for the {@}config-index tag in a Docblock.
 */
class ConfigIndex extends BaseTag implements StaticMethod
{
    /**
     * @var string
     */
    protected $name = 'config-index';

    /**
     * @var null|string
     */
    protected $exampleIndex;

    /**
     * Para constructor.
     * @param string $exampleIndex
     */
    public function __construct($exampleIndex = null)
    {
        $this->exampleIndex = $exampleIndex;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, TypeResolver $typeResolver = null, DescriptionFactory $descFactory = null, TypeContext $context = null)
    {
        $exampleIndex = trim(str_replace('"', '\'', $body), '\'');
        return new static($exampleIndex);
    }

    /**
     * @return null|string
     */
    public function getExampleIndex(): ?string
    {
        return $this->exampleIndex;
    }

    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->exampleIndex ?: '';
    }
}
