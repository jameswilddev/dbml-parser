<?php

namespace JamesWildDev\DBMLParser\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\TokenizerState;

/**
 * Helpers for identifying the classes of characters.
 */
class CharacterIs
{
  /**
   * Determines whether a character is a carriage return.
   * @param $character The character to check.
   * @return bool True when the character is a carriage return, otherwise, false.
   */
  public static function carriageReturn($character)
  {
    return $character === "\r";
  }

  /**
   * Determines whether a character is a line feed.
   * @param $character The character to check.
   * @return bool True when the character is a line feed, otherwise, false.
   */
  public static function lineFeed($character)
  {
    return $character === "\n";
  }

  /**
   * Determines whether a character is any kind of new line.
   * @param $character The character to check.
   * @return bool True when the character is a newline, otherwise, false.
   */
  public static function newLine($character)
  {
    return preg_match('/^\v$/', $character);
  }

  /**
   * Determines whether a character constitutes white space.
   * @param $character The character to check.
   * @return bool True when the character constitutes white space, otherwise, false.
   */
  public static function whiteSpace($character)
  {
    return preg_match('/^\s$/', $character);
  }

  /**
   * Determines whether a character is any kind of symbol.
   * @param $character The character to check.
   * @return bool True when the character is a symbol, otherwise, false.
   */
  public static function symbol($character)
  {
    switch ($character) {
      case '[':
      case ']':
      case '(':
      case ')':
      case '{':
      case '}':
      case ':':
      case '<':
      case '>':
      case '-':
      case ',':
      case '.':
        return true;

      default:
        return false;
    }
  }

  /**
   * Determines whether a character is a single quote.
   * @param $character The character to check.
   * @return bool True when the character is a single quote, otherwise, false.
   */
  public static function singleQuote($character)
  {
    return $character === '\'';
  }

  /**
   * Determines whether a character is a double quote.
   * @param $character The character to check.
   * @return bool True when the character is a double quote, otherwise, false.
   */
  public static function doubleQuote($character)
  {
    return $character === '"';
  }

  /**
   * Determines whether a character is a forward slash.
   * @param $character The character to check.
   * @return bool True when the character is a forward slash, otherwise, false.
   */
  public static function forwardSlash($character)
  {
    return $character === '/';
  }

  /**
   * Determines whether a character is a backslash.
   * @param $character The character to check.
   * @return bool True when the character is a backslash, otherwise, false.
   */
  public static function backslash($character)
  {
    return $character === '\\';
  }

  /**
   * Determines whether a character is a backtick.
   * @param $character The character to check.
   * @return bool True when the character is a backtick, otherwise, false.
   */
  public static function backtick($character)
  {
    return $character === '`';
  }
}
