<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a white space event.
 */
final class WhiteSpaceEvent
{
  /**
   * @var integer $startLine The line number on which the white space started.
   */
  public $startLine;

  /**
   * @var integer $startColumn The column number on which the white space started.
   */
  public $startColumn;

  /**
   * @var integer $endLine The line number on which the white space ended.
   */
  public $endLine;

  /**
   * @var integer $endColumn The column number on which the white space ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the white space.
   */
  public $content;

  /**
   * @param integer $startLine The line number on which the white space started.
   * @param integer $startColumn The column number on which the white space started.
   * @param integer $endLine The line number on which the white space ended.
   * @param integer $endColumn The column number on which the white space ended.
   * @param string $content The content of the white space.
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
