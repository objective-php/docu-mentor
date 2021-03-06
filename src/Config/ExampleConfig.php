<?php

namespace ObjectivePHP\DocuMentor\Config;

use ObjectivePHP\Config\Directive\AbstractComplexDirective;
use ObjectivePHP\Config\Directive\IgnoreDefaultInterface;

/**
 * Class ExampleConfig
 *
 * This class is a config directive with purpose is to give examples for documentation
 * Hope this helps, is also used for development tests
 *
 * @package ObjectivePHP\DocuMentor\Config
 */
class ExampleConfig extends AbstractComplexDirective implements IgnoreDefaultInterface
{
    const KEY = 'example';

    /**
     * @var string
     */
    protected $key = self::KEY;

    /**
     * Array value
     *
     * An example with an array for value
     *
     * @config-attribute
     *
     * @config-example-value    array('first_value', 'second_value' )
     *
     * @var array
     */
    protected $someArray;

    /**
     * Array value
     *
     * An example with an array on many lines
     *
     * @config-attribute
     *
     * @config-example-value    array(
     * @config-example-value        'first_value',
     * @config-example-value        'second_value',
     * @config-example-value        {"f_key" : "f_val", "s_key" : "S_val"}
     * @config-example-value    )
     *
     * @var array
     */
    protected $altArray;

    /**
     * An Object User
     *
     * @config-attribute     hash
     *
     * @config-example-value    {
     * @config-example-value        "user_name": "My username",
     * @config-example-value        "skills": ["php", "js"],
     * @config-example-value        "nickname": "My nickname"
     * @config-example-value    }
     *
     * @var User
     */
    protected $myUser;

    /**
     * Two lines String
     *
     * Take attention where the quotes are placed
     *
     * @config-attribute
     * @config-example-value  'Multi line
     * @config-example-value  string'
     * @var string
     */
    protected $exampleForAString;

    /**
     * String without the example-value
     *
     * This one takes automatically the default value for the docs
     *
     * @config-attribute
     *
     * @var string
     */
    protected $anyStringPath = 'MyDefault\\String';


    /**
     * Boolean Support
     *
     * @config-attribute
     *
     * @config-example-value true
     *
     * @var boolean
     */
    protected $booleanValue;

    /**
     * @return array
     */
    public function getSomeArray(): array
    {
        return $this->someArray;
    }

    /**
     * @param array $someArray
     * @return ExampleConfig
     */
    public function setSomeArray(array $someArray): ExampleConfig
    {
        $this->someArray = $someArray;
        return $this;
    }

    /**
     * @return User
     */
    public function getMockUser(): User
    {
        return $this->mockUser;
    }

    /**
     * @param User $mockUser
     * @return ExampleConfig
     */
    public function setMockUser(User $mockUser): ExampleConfig
    {
        $this->mockUser = $mockUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getExampleForAString(): string
    {
        return $this->exampleForAString;
    }

    /**
     * @param string $exampleForAString
     * @return ExampleConfig
     */
    public function setExampleForAString(string $exampleForAString): ExampleConfig
    {
        $this->exampleForAString = $exampleForAString;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnyStringPath(): string
    {
        return $this->anyStringPath;
    }

    /**
     * @param string $anyStringPath
     * @return ExampleConfig
     */
    public function setAnyStringPath(string $anyStringPath): ExampleConfig
    {
        $this->anyStringPath = $anyStringPath;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBooleanValue(): bool
    {
        return $this->booleanValue;
    }

    /**
     * @param bool $booleanValue
     * @return ExampleConfig
     */
    public function setBooleanValue(bool $booleanValue): ExampleConfig
    {
        $this->booleanValue = $booleanValue;
        return $this;
    }


}
