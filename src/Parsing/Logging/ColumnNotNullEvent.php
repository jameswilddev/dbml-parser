<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a column not nullable declaration event.
 */
final class ColumnNotNullEvent
{
  /**
   * @var string $tableName The name of the table which contains the column which is not nullable.
   */
  public $tableName;

  /**
   * @var string $columnName The name of the column which is not nullable.
   */
  public $columnName;

  /**
   * @param string $tableName The name of the table which contains the column which is not nullable.
   * @param string $columnName The name of the column which is not nullable.
   */
  function __construct($tableName, $columnName)
  {
    $this->tableName = $tableName;
    $this->columnName = $columnName;
  }
}
