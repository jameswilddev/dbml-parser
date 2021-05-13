<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of an unknown character sequence event.
 */
final class UnknownEvent
{
  /**
   * @var integer $startLine The line number on which the unknown sequence of characters started.
   */
  public $startLine;

  /**
   * @var integer $startColumn The column number on which the unknown sequence of characters started.
   */
  public $startColumn;

  /**
   * @var integer $endLine The line number on which the unknown sequence of characters ended.
   */
  public $endLine;

  /**
   * @var integer $endColumn The column number on which the unknown sequence of characters ended.
   */
  public $endColumn;

  /**
   * @var string $content The unknown sequence of characters.
   */
  public $content;

  /**
   * @param integer $startLine The line number on which the unknown sequence of characters started.
   * @param integer $startColumn The column number on which the unknown sequence of characters started.
   * @param integer $endLine The line number on which the unknown sequence of characters ended.
   * @param integer $endColumn The column number on which the unknown sequence of characters ended.
   * @param integer $content The unknown sequence of characters.
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
