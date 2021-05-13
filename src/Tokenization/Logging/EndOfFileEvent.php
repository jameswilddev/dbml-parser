<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of an end-of-file event.
 */
final class EndOfFileEvent
{
  /**
   * @var integer $column The line number on which the file ended.
   */
  public $line;

  /**
   * @var integer $column The column number on which the file ended.
   */
  public $column;

  /**
   * @param integer $line The line number on which the file ended.
   * @param integer $column The column number on which the file ended.
   */
  function __construct($line, $column)
  {
    $this->line = $line;
    $this->column = $column;
  }
}
