<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a table alias declaration event.
 */
final class TableAliasEvent
{
  /**
   * @var string $tableName The name of the parent table.
   */
  public $tableName;

  /**
   * @var string $name The name of the table alias.
   */
  public $name;

  /**
   * @var integer $nameStartLine The line number on which the name of the table alias started.
   */
  public $nameStartLine;

  /**
   * @var integer $nameStartColumn The column number on which the name of the table alias started.
   */
  public $nameStartColumn;

  /**
   * @var integer $nameEndLine The line number on which the name of the table alias ended.
   */
  public $nameEndLine;

  /**
   * @var integer $nameEndColumn The column number on which the name of the table alias ended.
   */
  public $nameEndColumn;

  /**
   * @param string $tableName The name of the parent table.
   * @param string $name The name of the table alias.
   * @param integer $nameStartLine The line number on which the name of the table alias started.
   * @param integer $nameStartColumn The column number on which the name of the table alias started.
   * @param integer $nameEndLine The line number on which the name of the table alias ended.
   * @param integer $nameEndColumn The column number on which the name of the table alias ended.
   */
  function __construct($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->tableName = $tableName;
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
  }
}
