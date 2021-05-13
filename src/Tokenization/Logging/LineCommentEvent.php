<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a line comment event.
 */
final class LineCommentEvent
{
  /**
   * @var integer $line The line number on which the line comment was found.
   */
  public $line;

  /**
   * @var integer $startColumn The column number on which the line comment started.
   */
  public $startColumn;

  /**
   * @var integer $endColumn The column number on which the line comment ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the line comment.
   */
  public $content;

  /**
   * @param integer $line The line number on which the line comment was found.
   * @param integer $startColumn The column number on which the line comment started.
   * @param integer $endColumn The column number on which the line comment ended.
   * @param string $content The content of the line comment.
   */
  function __construct($line, $startColumn, $endColumn, $content)
  {
    $this->line = $line;
    $this->startColumn = $startColumn;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
