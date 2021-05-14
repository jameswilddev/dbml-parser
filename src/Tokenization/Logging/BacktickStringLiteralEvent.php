<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a backtick-delimited string literal event.
 */
final class BacktickStringLiteralEvent
{
  /**
   * @var integer $startLine The line number on which the backtick-delimited string literal started.
   */
  public $startLine;

  /**
   * @var integer $startColumn The column number on which the backtick-delimited string literal started.
   */
  public $startColumn;

  /**
   * @var integer $endLine The line number on which the backtick-delimited string literal ended.
   */
  public $endLine;

  /**
   * @var integer $endColumn The column number on which the backtick-delimited string literal ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the backtick-delimited string literal.
   */
  public $content;

  /**
   * @param integer $startLine The line number on which the backtick-delimited string literal started.
   * @param integer $startColumn The column number on which the backtick-delimited string literal started.
   * @param integer $endLine The line number on which the backtick-delimited string literal ended.
   * @param integer $endColumn The column number on which the backtick-delimited string literal ended.
   * @param string $content The content of the backtick-delimited string literal.
   */
  function __construct($startLine, $startColumn, $endLine, $endColumn, $content)
  {
    $this->startLine = $startLine;
    $this->startColumn = $startColumn;
    $this->endLine = $endLine;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
