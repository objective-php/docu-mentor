<?php

namespace ObjectivePHP\DocuMentor;

use RuntimeException;

/**
 * Class ReflectionFile
 *
 * This Class extends ReflectionClass and add the ability to build the fqcn of a targeted class before doing reflection
 * Additionally catch the filedocblock
 *
 * @package ObjectivePHP\DocuMentor
 */
class ReflectionFile extends \ReflectionClass
{
    /**
     * @var string
     */
    protected $fileDocComment = '';

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * ReflectionFile constructor.
     *
     * @param $pathToFile
     *
     * @throws \RuntimeException
     * @throws Exception
     * @throws \ReflectionException
     */
    public function __construct($pathToFile)
    {
        $this->reflect($pathToFile);
        if ($this->namespace) {
            $this->namespace .= '\\' . basename($pathToFile, '.php');
            parent::__construct($this->namespace);
        } else {
            throw new RuntimeException('The namespace may don\'t match any class or other problem');
        }
    }

    /**
     * Pre-reflection method
     *
     * This method uses the tokens to find the namespace
     *
     * @param String $pathToFile
     */
    protected function reflect(String $pathToFile): void
    {
        $tokens = token_get_all(file_get_contents($pathToFile));
        foreach ($tokens as $key => $token) {
            if (!\is_array($token)) {
                break;
            }
            [$type, $value] = $token;
            switch ($type) {
                case T_DOC_COMMENT:
                    if (!$this->namespace) {
                        $this->fileDocComment = $value;
                    }
                    break;
                case T_NAMESPACE:
                    while (++$key < \count($tokens)) {
                        if ($tokens[$key] === ';') {
                            $this->namespace = trim($this->namespace);
                            break;
                        }
                        $this->namespace .= \is_array($tokens[$key]) ? $tokens[$key][1] : $tokens[$key];
                    }
                    break;
                case T_OPEN_TAG:
                case T_WHITESPACE:
                    break;
            }
        }
    }

    /**
     * Getter for the file docblock
     *
     * @return string
     */
    public function getFileDocComment(): string
    {
        return $this->fileDocComment;
    }

    /**
     * Getter for the namespace
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
