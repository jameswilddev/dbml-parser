<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a column primary key declaration event.
 */
final class ColumnPrimaryKeyEvent
{
  /**
   * @var string $tableName The name of the table which contains the column which is a primary key.
   */
  public $tableName;

  /**
   * @var string $columnName The name of the column which is a primary key.
   */
  public $columnName;

  /**
   * @param string $tableName The name of the table which contains the column which is a primary key.
   * @param string $columnName The name of the column which is a primary key.
   */
  function __construct($tableName, $columnName)
  {
    $this->tableName = $tableName;
    $this->columnName = $columnName;
  }
}
