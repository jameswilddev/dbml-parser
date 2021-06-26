<?php

namespace JamesWildDev\DBMLParser\Parsing;

use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\TokenizerState;

/**
 * Helpers for identifying the classes of tokens.
 */
class TokenIs
{
  /**
   * Determines whether a token is meaningful (not a comment or white space).
   * @param TokenType $type The type of the token.
   * @return bool True when the token is meaningful (not a comment or white space), otherwise, false.
   */
  public static function meaningful($type)
  {
    return $type !== TokenType::WHITE_SPACE && $type !== TokenType::LINE_COMMENT && $type != TokenType::UNKNOWN;
  }

  /**
   * Determines whether a token could be interpreted as an identifier (a bare word or a string literal).
   * @param TokenType $type The type of the token.
   * @return bool True when the token could be interpreted as an identifier (a bare word or a string literal), otherwise, false.
   */
  public static function anIdentifier($type, $content)
  {
    return (
      $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER
      && ! self::anOpeningBrace($type, $content)
      && ! self::aClosingBrace($type, $content)
      && ! self::anOpeningParenthesis($type, $content)
      && ! self::aClosingParenthesis($type, $content)
      && ! self::anOpeningBracket($type, $content)
      && ! self::aClosingBracket($type, $content)
      && ! self::aSemicolon($type, $content)
      && ! self::aLessThanSymbol($type, $content)
      && ! self::aGreaterThanSymbol($type, $content)
      && ! self::aHyphen($type, $content)
      && ! self::aComma($type, $content)
      && ! self::aPeriod($type, $content)
    ) || $type === TokenType::STRING_LITERAL;
  }

  /**
   * Determines whether a token means "as".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "as", otherwise, false.
   */
  public static function isAs($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'as';
  }

  /**
   * Determines whether a token means "table".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "table", otherwise, false.
   */
  public static function table($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'table';
  }

  /**
   * Determines whether a token means "enum".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "enum", otherwise, false.
   */
  public static function enum($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'enum';
  }

  /**
   * Determines whether a token means "ref".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "ref", otherwise, false.
   */
  public static function ref($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'ref';
  }

  /**
   * Determines whether a token means "unique".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "unique", otherwise, false.
   */
  public static function unique($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'unique';
  }

  /**
   * Determines whether a token means "name".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "name", otherwise, false.
   */
  public static function name($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'name';
  }

  /**
   * Determines whether a token is an opening brace ("{").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is an opening brace ("{"), otherwise, false.
   */
  public static function anOpeningBrace($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '{';
  }

  /**
   * Determines whether a token is a closing brace ("}").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a closing brace ("}"), otherwise, false.
   */
  public static function aClosingBrace($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '}';
  }

  /**
   * Determines whether a token is an opening bracket ("[").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is an opening brace ("["), otherwise, false.
   */
  public static function anOpeningBracket($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '[';
  }

  /**
   * Determines whether a token is a closing bracket ("]").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a closing bracket ("]"), otherwise, false.
   */
  public static function aClosingBracket($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === ']';
  }

  /**
   * Determines whether a token is an opening parenthesis ("(").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is an opening parenthesis ("("), otherwise, false.
   */
  public static function anOpeningParenthesis($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '(';
  }

  /**
   * Determines whether a token is a closing parenthesis (")").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a closing parenthesis (")"), otherwise, false.
   */
  public static function aClosingParenthesis($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === ')';
  }

  /**
   * Determines whether a token is a semicolon (":").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a semicolon (":"), otherwise, false.
   */
  public static function aSemicolon($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === ':';
  }

  /**
   * Determines whether a token is a less than symbol ("<").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a less than symbol ("<"), otherwise, false.
   */
  public static function aLessThanSymbol($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '<';
  }

  /**
   * Determines whether a token is a greater than symbol (">").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a grater than symbol (">"), otherwise, false.
   */
  public static function aGreaterThanSymbol($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '>';
  }

  /**
   * Determines whether a token is a hyphen ("-").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a hyphen ("-"), otherwise, false.
   */
  public static function aHyphen($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '-';
  }

  /**
   * Determines whether a token is a comma (",").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a comma (","), otherwise, false.
   */
  public static function aComma($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === ',';
  }

  /**
   * Determines whether a token is a period (".").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token is a period ("."), otherwise, false.
   */
  public static function aPeriod($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && $content === '.';
  }

  /**
   * Determines whether a token means "primary key" ("pk").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "primary key" ("pk"), otherwise, false.
   */
  public static function primaryKey($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'pk';
  }

  /**
   * Determines whether a token means "auto increment" ("increment").
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "auto increment" ("increment"), otherwise, false.
   */
  public static function increment($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'increment';
  }

  /**
   * Determines whether a token means "default".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "default", otherwise, false.
   */
  public static function defaultKeyword($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'default';
  }

  /**
   * Determines whether a token means "not".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "not", otherwise, false.
   */
  public static function not($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'not';
  }

  /**
   * Determines whether a token means "null".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "null", otherwise, false.
   */
  public static function null($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'null';
  }

  /**
   * Determines whether a token means "note".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "note", otherwise, false.
   */
  public static function note($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'note';
  }

  /**
   * Determines whether a token means "indexes".
   * @param TokenType $type The type of the token.
   * @param string $content The content of the token.
   * @return bool True when the token means "indexes", otherwise, false.
   */
  public static function indexes($type, $content)
  {
    return $type === TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER && strtolower($content) === 'indexes';
  }

  /**
   * Determines whether a token could be taken as a backtick string literal.
   * @param TokenType $type The type of the token.
   * @return bool True when the token could be taken as a backtick string literal, otherwise, false.
   */
  public static function aBacktickStringLiteral($type)
  {
    return $type === TokenType::BACKTICK_STRING_LITERAL;
  }
}
