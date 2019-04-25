<?php

namespace AdachSoft\Text;

class TextParser implements \Iterator
{
    /**
     * Text.
     *
     * @var string
     */
    protected $text;

    /**
     * Position.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Construct
     */
    public function __construct(string $text='')
    {
        $this->text = $text;
    }

    /**
     * Convert object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * Implementation of the Iterator interface.
     *
     * {@inheritDoc}
     */
    public function rewind() 
    {
        $this->position = 0;
    }

    /**
     * Implementation of the Iterator interface.
     *
     * {@inheritDoc}
     */
    public function current() 
    {
        return substr($this->text, $this->position, 1);
    }

    /**
     * Implementation of the Iterator interface.
     *
     * {@inheritDoc}
     */
    public function key() 
    {
        return $this->position;
    }

    /**
     * Implementation of the Iterator interface.
     *
     * {@inheritDoc}
     */
    public function next() 
    {
        ++$this->position;
    }

    /**
     * Implementation of the Iterator interface.
     * 
     * {@inheritDoc}
     */
    public function valid() 
    {
        return strlen($this->text) > $this->position;
    }

    /**
     * Set text.
     *
     * @param string $text
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function lowercase(): self
    {
        $this->text = strtolower($this->text);
        return $this;
    }

    public function uppercase(): self
    {
        $this->text = strtoupper($this->text);
        return $this;
    }

    public function uppercaseFirstLetter(): self
    {
        $this->text = ucfirst($this->text);
        return $this;
    }

    public function lowercaseFirstLetter(): self
    {
        $this->text = lcfirst($this->text);
        return $this;
    }

    public function uppercaseFirstCharacterOfEachWord(): self
    {
        $this->text = ucwords($this->text);
        return $this;
    }
    
    public function shuffle(): self
    {
        $this->text = str_shuffle($this->text);
        return $this;
    }

    public function reverse(): self
    {
        $this->text = strrev($this->text);
        return $this;
    }

    public function htmlSpecialChars(): self
    {
        $this->text = htmlspecialchars($this->text);
        return $this;
    }

    public function htmlEntities(): self
    {
        $this->text = htmlentities($this->text);
        return $this;
    }

    public function trim(): self
    {
        $this->text = trim($this->text);
        return $this;
    }

    public function removeMultipleSpace(): self
    {
        $this->text = preg_replace('/\s\s+/', ' ', $this->text);
        return $this;
    }
    
    public function insertSpaceBeforeCapitalLetters(): self
    {
        $this->text = preg_replace('/(?<!\ )[A-Z]/', ' $0', $this->text);
        return $this;
    }

    public function spaceToDash(): self
    {
        $this->text = \str_replace(' ', '-', $this->text);
        return $this;
    }

    public function dashToSpace(): self
    {
        $this->text = \str_replace('-', ' ', $this->text);
        return $this;
    }
    
    public function spaceToUnderscore(): self
    {
        $this->text = \str_replace(' ', '_', $this->text);
        return $this;
    }

    public function underscoreToSpace(): self
    {
        $this->text = \str_replace('_', ' ', $this->text);
        return $this;
    }

    public function backslashToForwardSlash(): self
    {
        $this->text = \str_replace('\\', '/', $this->text);
        return $this;
    }

    public function forwardSlashToBackslash(): self
    {
        $this->text = \str_replace('/', '\\', $this->text);
        return $this;
    }

    public function removeAllSpace(): self
    {
        $this->text = \str_replace(' ', '', $this->text);
        return $this;
    }

    public function removeNonAlphanumeric(): self
    {
        $this->text = \preg_replace("/[^A-Za-z0-9 ]/", '', $this->text);
        return $this;
    }

    public function pascalCase(): self
    {
        $this->removeNonAlphanumeric();
        $this->lowercase(); 
        $this->uppercaseFirstCharacterOfEachWord();
        $this->removeAllSpace();
        return $this;
    }

    public function camelCase(): self
    {
        $this->pascalCase();
        $this->lowercaseFirstLetter();
        return $this;
    }
    
    public function snakeCase(): self
    {
        $this->removeNonAlphanumeric($this->text);
        $this->removeMultipleSpace($this->text);
        $this->trim($this->text);
        $this->spaceToUnderscore($this->text);
        $this->lowercase($this->text);
        return $this;
    }

    public function screamingSnakeCase(): self
    {
        $this->removeNonAlphanumeric($this->text);
        $this->removeMultipleSpace($this->text);
        $this->trim($this->text);
        $this->spaceToUnderscore($this->text);
        $this->uppercase($this->text);
        return $this;
    }
    
    public function kebabCase(): self
    {
        $this->removeNonAlphanumeric($this->text);
        $this->removeMultipleSpace($this->text);
        $this->trim($this->text);
        $this->spaceToDash($this->text);
        $this->lowercase($this->text);
        return $this;
    }

    public function pascalCaseToSnakeCase(): self
    {
        $this->insertSpaceBeforeCapitalLetters($this->text);
        $this->snakeCase($this->text);
        return $this;
    }

    public function beginsWith(string $textToCompare): bool
    {
        return strpos($this->text, $textToCompare) === 0;
    }

    public function endsWith(string $textToCompare): bool
    {
        return substr_compare($this->text, $textToCompare, -strlen($textToCompare)) === 0;
    }

    public function contains(string $textToCompare): bool
    {
        return strpos($this->text, $textToCompare) !== false;
    }
    
}