<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a table declaration event.
 */
final class TableEvent
{
  /**
   * @var string $name The name of the table.
   */
  public $name;

  /**
   * @var integer $nameStartLine The line number on which the name of the table started.
   */
  public $nameStartLine;

  /**
   * @var integer $nameStartColumn The column number on which the name of the table started.
   */
  public $nameStartColumn;

  /**
   * @var integer $nameEndLine The line number on which the name of the table ended.
   */
  public $nameEndLine;

  /**
   * @var integer $nameEndColumn The column number on which the name of the table ended.
   */
  public $nameEndColumn;

  /**
   * @param string $name The name of the table.
   * @param integer $nameStartLine The line number on which the name of the table started.
   * @param integer $nameStartColumn The column number on which the name of the table started.
   * @param integer $nameEndLine The line number on which the name of the table ended.
   * @param integer $nameEndColumn The column number on which the name of the table ended.
   */
  function __construct($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
  }
}
