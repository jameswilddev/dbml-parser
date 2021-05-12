<?php

namespace JamesWildDev\DBMLParser;

/**
 * Handles tokens found by the Tokenizer.
 */
interface TokenizerTarget
{
  /**
   * Handle the end of the file.
   *
   * @param integer $line The line number on which the file ended.
   * @param integer $column The column number on which the file ended.
   */
  public function endOfFile($line, $column);

  /**
   * Handle an opening brace.
   *
   * @param integer $line The line number on which the opening brace was found.
   * @param integer $column The column number on which the opening brace was found.
   */
  public function openingBrace($line, $column);

  /**
   * Handle a closing brace.
   *
   * @param integer $line The line number on which the closing brace was found.
   * @param integer $column The column number on which the closing brace was found.
   */
  public function closingBrace($line, $column);

  /**
   * Handle an opening (square) bracket.
   *
   * @param integer $line The line number on which the opening bracket was found.
   * @param integer $column The column number on which the opening bracket was found.
   */
  public function openingBracket($line, $column);

  /**
   * Handle a closing (square) bracket.
   *
   * @param integer $line The line number on which the closing bracket was found.
   * @param integer $column The column number on which the closing bracket was found.
   */
  public function closingBracket($line, $column);

  /**
   * Handle a semicolon.
   *
   * @param integer $line The line number on which the semicolon was found.
   * @param integer $column The column number on which the semicolon was found.
   */
  public function semicolon($line, $column);

  /**
   * Handle a greater-than symbol.
   *
   * @param integer $line The line number on which the greater-than symbol was found.
   * @param integer $column The column number on which the greater-than symbol was found.
   */
  public function greaterThan($line, $column);

  /**
   * Handle a less-than symbol.
   *
   * @param integer $line The line number on which the less-than symbol was found.
   * @param integer $column The column number on which the less-than symbol was found.
   */
  public function lessThan($line, $column);

  /**
   * Handle a hyphen.
   *
   * @param integer $line The line number on which the hyphen was found.
   * @param integer $column The column number on which the hyphen was found.
   */
  public function hyphen($line, $column);

  /**
   * Handle a line comment.
   *
   * @param integer $line The line number on which the line comment found.
   * @param integer $startColumn The column number on which the line comment started.
   * @param integer $endColumn The column number on which the word ended.
   * @param string $content The content of the line comment.
   */
  public function lineComment($line, $startColumn, $endColumn, $content);

  /**
   * Handle a word (an identifier or keyword).
   *
   * @param integer $line The line number on which the word was found.
   * @param integer $startColumn The column number on which the word started.
   * @param integer $endColumn The column number on which the word ended.
   * @param string $content The content of the word.
   */
  public function word($line, $startColumn, $endColumn, $content);

  /**
   * Handle a string literal.
   *
   * @param integer $startLine The line number on which the string literal started.
   * @param integer $startColumn The column number on which the string literal started.
   * @param integer $endLine The line number on which the string literal ended.
   * @param integer $endColumn The column number on which the string literal ended.
   * @param string $content The content of the string literal.
   */
  public function stringLiteral($line, $startColumn, $endLine, $endColumn, $content);

  /**
   * Handle an unexpected character.
   *
   * @param integer $line The line number on which the unexpected character was found.
   * @param integer $column The column number on which the unexpected character was found.
   * @param integer $codepoint The unexpected character found.
   */
  public function unexpectedCharacter($line, $column, $codepoint);

  /**
   * Handle an unexpected end-of-file.
   *
   * @param integer $line The line number on which the unexpected end-of-file was found.
   * @param integer $column The column number on which the unexpected end-of-file was found.
   */
  public function unexpectedEndOfFile($line, $column);
}
