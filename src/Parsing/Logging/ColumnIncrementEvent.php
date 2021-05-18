<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a column auto-increment declaration event.
 */
final class ColumnIncrementEvent
{
  /**
   * @var string $tableName The name of the table which contains the column which is auto-incrementing.
   */
  public $tableName;

  /**
   * @var string $columnName The name of the column which is auto-incrementing.
   */
  public $columnName;

  /**
   * @param string $tableName The name of the table which contains the column which is auto-incrementing.
   * @param string $columnName The name of the column which is auto-incrementing.
   */
  function __construct($tableName, $columnName)
  {
    $this->tableName = $tableName;
    $this->columnName = $columnName;
  }
}
