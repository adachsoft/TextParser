<?php

namespace Tests;

use AdachSoft\Text\TextParser;

class TextParserTest extends \PHPUnit\Framework\TestCase
{
	public function testSetGet()
	{
        $textParser = new TextParser('test');
        $this->assertSame('test', $textParser->getText());
        $textParser->setText('new_value');
        $this->assertSame('new_value', $textParser->getText());
    }

    public function testToString()
	{
        $textParser = new TextParser('test value');
        $this->assertSame('test value', (string)$textParser);
    }

    public function testClone()
    {
        $textParser = new TextParser('test value for clone');
        $textParserCloned = clone $textParser;
        $this->assertSame('test value for clone', (string)$textParser);
        $this->assertSame('test value for clone', (string)$textParserCloned);
    }

    public function testForeach()
	{
        $text = 'test value';
        $textParser = new TextParser($text);
        $i = 0;
        $len = strlen($text);
        foreach($textParser as $key => $val){
            $this->assertSame($i, $key);
            $this->assertSame(substr($text, $i, 1), $val);
            $i++;
        }
        $this->assertSame($len, $i);
    }

    /**
     * @dataProvider comparisonMethodsProvider
     */
    public function testComparisonMethods(string $method, bool $expectedValue, string $inputValue, string $toCompare)
    {
        $textParser = new TextParser($inputValue);
        $this->assertSame($expectedValue, $textParser->$method($toCompare));
        $this->assertSame($inputValue, (string)$textParser);
    }

    public function comparisonMethodsProvider()
    {
        return [
            ['beginsWith', true, 'Lorem ipsum dolor sit amet', 'Lorem'],
            ['beginsWith', false, 'Lore', 'Lorem'],
            ['beginsWith', false, 'Lorem ipsum dolor sit amet', 'LoRem'],
            ['endsWith', true, 'Lorem ipsum dolor sit amet', 'sit amet'],
            ['contains', true, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", 'occaecat'],
            ['contains', true, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", 'Lore'],
            ['contains', true, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", 'roident'],
            ['contains', true, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", "\r\n"],
            ['contains', false, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", 'sitamet'],
            ['contains', false, "Lorem ipsum dolor sit amet.\r\nExcepteur sint occaecat cupidatat non proident", 'lore'],
        ];
    }

    /**
     * @dataProvider additionProvider
     */
    public function testMethods($method, $expectedValue, $inputValue)
    {
        $textParser = new TextParser($inputValue);
        $textParser->$method();
        $this->assertSame($expectedValue, $textParser->getText());
    }

    public function additionProvider()
    {
        return [
            ['removeNonAlphanumeric', 'fds72fds fd  112  F abc', 'fds72fds fd ,% 112  F$#@$# abc'],
            ['removeNonAlphanumeric', '', ''],
            ['removeNonAlphanumeric', 'A', 'A'],
            ['removeNonAlphanumeric', 'AB', "A\r\nB*"],
            ['removeNonAlphanumeric', '', '#'],
            ['insertSpaceBeforeCapitalLetters', ' Abc Hxz45', 'AbcHxz45'],
            ['trim', 'aBc', ' aBc '],
            ['trim', 'aBC $  ..', ' aBC $  .. '],
            ['removeMultipleSpace', ' aBC $ .. ', '  aBC $  .. '],
            ['screamingSnakeCase', 'SCREAMING_SNAKE_CASE', 'scrEaming  , SNaKE case%$#%'],
            ['screamingSnakeCase', 'SCREAMING_SNAKE_CASE', '  scrEaming  , SNaKE case%$#%  '],
            ['snakeCase', 'snake_case', '$SNaKE case%$#%'],
            ['snakeCase', 'snake_case', ' $SNaKE case%$#%   '],
            ['snakeCase', 'snake_case', ' $SNaKE __case%$#%   '],
            ['kebabCase', 'kebab-case', ' $kEBab __case%$#%   '],
            ['pascalCase', 'PascalCase', ' $pascal   caSe   '],
            ['camelCase', 'camelCase', ' $%caMel   cASe-   '],
            ['pascalCaseToSnakeCase', 'pascal_case', 'PascalCase'],
        ];
    }
}