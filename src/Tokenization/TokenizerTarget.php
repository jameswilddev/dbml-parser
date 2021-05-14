<?php

namespace JamesWildDev\DBMLParser\Tokenization;

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
   * Handle a line comment.
   *
   * @param integer $line The line number on which the line comment was found.
   * @param integer $startColumn The column number on which the line comment started.
   * @param integer $endColumn The column number on which the line comment ended.
   * @param string $content The content of the line comment.
   */
  public function lineComment($line, $startColumn, $endColumn, $content);

  /**
   * Handle a token (an identifier, symbol or keyword).
   *
   * @param integer $line The line number on which the token was found.
   * @param integer $startColumn The column number on which the token started.
   * @param integer $endColumn The column number on which the token ended.
   * @param string $content The content of the token.
   */
  public function token($line, $startColumn, $endColumn, $content);

  /**
   * Handle a double-quoted token which is likely an identifier.
   *
   * @param integer $line The line number on which the double-quoted token was found.
   * @param integer $startColumn The column number on which the double-quoted token started.
   * @param integer $endColumn The column number on which the double-quoted token ended.
   * @param string $content The content of the double-quoted token.
   */
  public function quotedToken($line, $startColumn, $endColumn, $content);

  /**
   * Handle a string literal.
   *
   * @param integer $startLine The line number on which the string literal started.
   * @param integer $startColumn The column number on which the string literal started.
   * @param integer $endLine The line number on which the string literal ended.
   * @param integer $endColumn The column number on which the string literal ended.
   * @param string $content The content of the string literal.
   */
  public function stringLiteral($startLine, $startColumn, $endLine, $endColumn, $content);

  /**
   * Handle a backtick-delimited string literal.
   *
   * @param integer $startLine The line number on which the backtick-delimited string literal started.
   * @param integer $startColumn The column number on which the backtick-delimited string literal started.
   * @param integer $endLine The line number on which the backtick-delimited string literal ended.
   * @param integer $endColumn The column number on which the backtick-delimited string literal ended.
   * @param string $content The content of the backtick-delimited string literal.
   */
  public function backtickStringLiteral($startLine, $startColumn, $endLine, $endColumn, $content);

  /**
   * Handle white space.
   *
   * @param integer $startLine The line number on which the white space started.
   * @param integer $startColumn The column number on which the white space started.
   * @param integer $endLine The line number on which the white space ended.
   * @param integer $endColumn The column number on which the white space ended.
   * @param string $content The content of the white space.
   */
  public function whiteSpace($startLine, $startColumn, $endLine, $endColumn, $content);

  /**
   * Handle an unknown sequence of characters.
   *
   * @param integer $startLine The line number on which the unknown sequence of characters started.
   * @param integer $startColumn The column number on which the unknown sequence of characters started.
   * @param integer $endLine The line number on which the unknown sequence of characters ended.
   * @param integer $endColumn The column number on which the unknown sequence of characters ended.
   * @param integer $content The unknown sequence of characters.
   */
  public function unknown($startLine, $startColumn, $endLine, $endColumn, $content);
}
