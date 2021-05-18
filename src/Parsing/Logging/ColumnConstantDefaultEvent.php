<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a constant column default declaration event.
 */
final class ColumnConstantDefaultEvent
{
  /**
   * @var string $tableName The name of the table which contains the column which is to have a constant default value.
   */
  public $tableName;

  /**
   * @var string $columnName The name of the column which is to have a constant default value.
   */
  public $columnName;

  /**
   * @var string $content The default value.
   */
  public $content;

  /**
   * @var integer $contentStartLine The line number on which the default value started.
   */
  public $contentStartLine;

  /**
   * @var integer $contentStartColumn The column number on which the default value started.
   */
  public $contentStartColumn;

  /**
   * @var integer $contentEndLine The line number on which the default value ended.
   */
  public $contentEndLine;

  /**
   * @var integer $contentEndColumn The column number on which the default value ended.
   */
  public $contentEndColumn;

  /**
   * @param string $tableName The name of the table which contains the column which is to have a constant default value.
   * @param string $columnName The name of the column which is to have a constant default value.
   * @param string $content The default value.
   * @param integer $contentStartLine The line number on which the default value started.
   * @param integer $contentStartColumn The column number on which the default value started.
   * @param integer $contentEndLine The line number on which the default value ended.
   * @param integer $contentEndColumn The column number on which the default value ended.
   */
  function __construct($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->tableName = $tableName;
    $this->columnName = $columnName;
    $this->content = $content;
    $this->contentStartLine = $contentStartLine;
    $this->contentStartColumn = $contentStartColumn;
    $this->contentEndLine = $contentEndLine;
    $this->contentEndColumn = $contentEndColumn;
  }
}
