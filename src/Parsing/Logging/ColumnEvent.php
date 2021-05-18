<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a column declaration event.
 */
final class ColumnEvent
{
  /**
   * @var string $tableName The name of the parent table.
   */
  public $tableName;

  /**
   * @var string $name The name of the column.
   */
  public $name;

  /**
   * @var integer $nameStartLine The line number on which the name of the column started.
   */
  public $nameStartLine;

  /**
   * @var integer $nameStartColumn The column number on which the name of the column started.
   */
  public $nameStartColumn;

  /**
   * @var integer $nameEndLine The line number on which the name of the column ended.
   */
  public $nameEndLine;

  /**
   * @var integer $nameEndColumn The column number on which the name of the column ended.
   */
  public $nameEndColumn;

  /**
   * @var string $type The column's type.
   */
  public $type;

  /**
   * @var ?string $size The column's size, if specified, otherwise, null.
   */
  public $size;

  /**
   * @param string $tableName The name of the parent table.
   * @param string $name The name of the column.
   * @param integer $nameStartLine The line number on which the name of the column started.
   * @param integer $nameStartColumn The column number on which the name of the column started.
   * @param integer $nameEndLine The line number on which the name of the column ended.
   * @param integer $nameEndColumn The column number on which the name of the column ended.
   * @param string $type The column's type.
   * @param ?string $size The column's size, if specified, otherwise, null.
   */
  function __construct($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $type, $size)
  {
    $this->tableName = $tableName;
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
    $this->type = $type;
    $this->size = $size;
  }
}
