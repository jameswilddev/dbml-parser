<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a double-quoted token event.
 */
final class QuotedTokenEvent
{
  /**
   * @var integer $line The line number on which the double-quoted token was found.
   */
  public $line;

  /**
   * @var integer $startColumn The column number on which the double-quoted token started.
   */
  public $startColumn;

  /**
   * @var integer $endColumn The column number on which the double-quoted token ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the double-quoted token.
   */
  public $content;

  /**
   * @param integer $line The line number on which the double-quoted token was found.
   * @param integer $startColumn The column number on which the double-quoted token started.
   * @param integer $endColumn The column number on which the double-quoted token ended.
   * @param string $content The content of the double-quoted token.
   */
  function __construct($line, $startColumn, $endColumn, $content)
  {
    $this->line = $line;
    $this->startColumn = $startColumn;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
