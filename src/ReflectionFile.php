<?php

namespace ObjectivePHP\DocuMentor;

use ObjectivePHP\Matcher\Exception;

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
     * @param $pathToFile
     * @throws Exception
     * @throws \ReflectionException
     */
    public function __construct($pathToFile)
    {
        $this->reflect($pathToFile);
        if ($this->namespace) {
            $this->namespace .=  '\\' . basename($pathToFile, '.php');
            parent::__construct($this->namespace);
        } else {
            throw new Exception();
        }
    }

    /**
     * @param String $pathToFile
     */
    protected function reflect(String $pathToFile): void
    {
        $tokens = token_get_all($contents = file_get_contents($pathToFile));
        foreach ($tokens as $key => $token) {
            if (!\is_array($token)) {
                break;
            }
            [$type, $value, $line] = $token;
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
                    break; //TODO à changer si on parcours la classe + en profondeur, dois etre breaké avant la fin du fichier
                case T_OPEN_TAG:
                case T_WHITESPACE:
                    break;
                default:
                    /* $this->fileDocComment = '';*/
                    break;
            }
        }
        /*if (preg_match('#^namespace\s+(.+?);$#sm', $contents, $m)) { //Plus complexe avec les tokens
            return $m[1] . '\\' . basename($pathToFile, '.php');*/
    }

    /**
     * Retrieve the file docblock
     *
     * @return string
     */
    public function getFileDocComment(): string
    {
        return $this->fileDocComment;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
