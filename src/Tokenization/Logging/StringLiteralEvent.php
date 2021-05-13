<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a string literal event.
 */
final class StringLiteralEvent
{
  /**
   * @var integer $startLine The line number on which the string literal started.
   */
  public $startLine;

  /**
   * @var integer $startColumn The column number on which the string literal started.
   */
  public $startColumn;

  /**
   * @var integer $endLine The line number on which the string literal ended.
   */
  public $endLine;

  /**
   * @var integer $endColumn The column number on which the string literal ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the string literal.
   */
  public $content;

  /**
   * @param integer $startLine The line number on which the string literal started.
   * @param integer $startColumn The column number on which the string literal started.
   * @param integer $endLine The line number on which the string literal ended.
   * @param integer $endColumn The column number on which the string literal ended.
   * @param string $content The content of the string literal.
   */
  function __construct($startLine, $startColumn, $endLine, $endColumn, $content)
  {
    $this->startLine = $startLine;
    $this->startColumn = $startColumn;
    $this->endLine = $endLine;
    $this->$endColumn = $endColumn;
    $this->content = $content;
  }
}
