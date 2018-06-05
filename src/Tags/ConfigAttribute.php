<?php

namespace ObjectivePHP\DocuMentor\Tags;

use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context as TypeContext;
use Webmozart\Assert\Assert;

/**
 * Reflection class for the {@}config-attribute tag in a Docblock.
 */
class ConfigAttribute extends BaseTag implements StaticMethod
{
    /**
     * @var string
     */
    protected $name = 'config-attribute';

    /**
     * @var Type
     */
    protected $type;

    /**
     * Para constructor.
     * @param Type|null $type
     */
    public function __construct(Type $type = null)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($body, TypeResolver $typeResolver = null, DescriptionFactory $descFactory = null, TypeContext $context = null)
    {

        /*Assert::stringNotEmpty($body);
        Assert::allNotNull([$typeResolver, $descFactory]);

        $parts = preg_split('~(?:\'[^\']*\'|"[^"]*")(*SKIP)(*F)|\h+~', $body, 3, PREG_SPLIT_DELIM_CAPTURE);

        $type = $typeResolver->resolve(trim($parts[0], '"\''));
        $variableName = trim($parts[0], '"\'');
        $defValue = trim($parts[1], '"\'');
        $desc = trim($parts[2], '"\'');
*/
        $type = null;
        if ($body) {
            $type = $typeResolver->resolve($body);
        }
        return new static($type);
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * Returns a string representation for this tag.
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->type ? $this->type . ' ' : '') ;
    }


}
