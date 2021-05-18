<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a ref event.
 */
final class RefEvent
{
  /**
   * @var string $firstTableNameOrAlias The name or an alias of the table which contains the first column.
   */
  public $firstTableNameOrAlias;

  /**
   * @var integer $firstTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the first column started.
   */
  public $firstTableNameOrAliasStartLine;

  /**
   * @var integer $firstTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the first column started.
   */
  public $firstTableNameOrAliasStartColumn;

  /**
   * @var integer $firstTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the first column ended.
   */
  public $firstTableNameOrAliasEndLine;

  /**
   * @var integer $firstTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the first column ended.
   */
  public $firstTableNameOrAliasEndColumn;

  /**
   * @var string $firstColumnName The name of the column which contains references.
   */
  public $firstColumnName;

  /**
   * @var integer $firstColumnNameStartLine The line number on which the column which contains references started.
   */
  public $firstColumnNameStartLine;

  /**
   * @var integer $firstColumnNameStartColumn The column number on which the column which contains references started.
   */
  public $firstColumnNameStartColumn;

  /**
   * @var integer $firstColumnNameEndLine The line number on which the column which contains references ended.
   */
  public $firstColumnNameEndLine;

  /**
   * @var integer $firstColumnNameEndColumn The column number on which the column which contains references ended.
   */
  public $firstColumnNameEndColumn;

  /**
   * @var string $secondTableNameOrAlias The name or an alias of the table which contains the column to be referred to.
   */
  public $secondTableNameOrAlias;

  /**
   * @var integer $secondTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the column to be referred to started.
   */
  public $secondTableNameOrAliasStartLine;

  /**
   * @var integer $secondTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the column to be referred to started.
   */
  public $secondTableNameOrAliasStartColumn;

  /**
   * @var integer $secondTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the column to be referred to ended.
   */
  public $secondTableNameOrAliasEndLine;

  /**
   * @var integer $secondTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the column to be referred to ended.
   */
  public $secondTableNameOrAliasEndColumn;

  /**
   * @var string $secondColumnName The name of the column which contains values to be referred to.
   */
  public $secondColumnName;

  /**
   * @var integer $secondColumnNameStartLine The line number on which the name of the column which contains values to be referred to started.
   */
  public $secondColumnNameStartLine;

  /**
   * @var integer $secondColumnNameStartColumn The column number on which the name of the column which contains values to be referred to started.
   */
  public $secondColumnNameStartColumn;

  /**
   * @var integer $secondColumnNameEndLine The line number on which the name of the column which contains values to be referred to ended.
   */
  public $secondColumnNameEndLine;

  /**
   * @var integer $secondColumnNameEndColumn The column number on which the name of the column which contains values to be referred to ended.
   */
  public $secondColumnNameEndColumn;

  /**
   * @param string $firstTableNameOrAlias The name or an alias of the table which contains the first column.
   * @param integer $firstTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the first column started.
   * @param integer $firstTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the first column started.
   * @param integer $firstTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the first column ended.
   * @param integer $firstTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the first column ended.
   * @param string $firstColumnName The name of the column which contains references.
   * @param integer $firstColumnNameStartLine The line number on which the column which contains references started.
   * @param integer $firstColumnNameStartColumn The column number on which the column which contains references started.
   * @param integer $firstColumnNameEndLine The line number on which the column which contains references ended.
   * @param integer $firstColumnNameEndColumn The column number on which the column which contains references ended.
   * @param string $secondTableNameOrAlias The name or an alias of the table which contains the column to be referred to.
   * @param integer $secondTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the column to be referred to started.
   * @param integer $secondTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the column to be referred to started.
   * @param integer $secondTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the column to be referred to ended.
   * @param integer $secondTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the column to be referred to ended.
   * @param string $secondColumnName The name of the column which contains values to be referred to.
   * @param integer $secondColumnNameStartLine The line number on which the name of the column which contains values to be referred to started.
   * @param integer $secondColumnNameStartColumn The column number on which the name of the column which contains values to be referred to started.
   * @param integer $secondColumnNameEndLine The line number on which the name of the column which contains values to be referred to ended.
   * @param integer $secondColumnNameEndColumn The column number on which the name of the column which contains values to be referred to ended.
   */
  function __construct(
    $firstTableNameOrAlias,
    $firstTableNameOrAliasStartLine,
    $firstTableNameOrAliasStartColumn,
    $firstTableNameOrAliasEndLine,
    $firstTableNameOrAliasEndColumn,
    $firstColumnName,
    $firstColumnNameStartLine,
    $firstColumnNameStartColumn,
    $firstColumnNameEndLine,
    $firstColumnNameEndColumn,
    $secondTableNameOrAlias,
    $secondTableNameOrAliasStartLine,
    $secondTableNameOrAliasStartColumn,
    $secondTableNameOrAliasEndLine,
    $secondTableNameOrAliasEndColumn,
    $secondColumnName,
    $secondColumnNameStartLine,
    $secondColumnNameStartColumn,
    $secondColumnNameEndLine,
    $secondColumnNameEndColumn
  ) {
    $this->firstTableNameOrAlias = $firstTableNameOrAlias;
    $this->firstTableNameOrAliasStartLine = $firstTableNameOrAliasStartLine;
    $this->firstTableNameOrAliasStartColumn = $firstTableNameOrAliasStartColumn;
    $this->firstTableNameOrAliasEndLine = $firstTableNameOrAliasEndLine;
    $this->firstTableNameOrAliasEndColumn = $firstTableNameOrAliasEndColumn;
    $this->firstColumnName = $firstColumnName;
    $this->firstColumnNameStartLine = $firstColumnNameStartLine;
    $this->firstColumnNameStartColumn = $firstColumnNameStartColumn;
    $this->firstColumnNameEndLine = $firstColumnNameEndLine;
    $this->firstColumnNameEndColumn = $firstColumnNameEndColumn;
    $this->secondTableNameOrAlias = $secondTableNameOrAlias;
    $this->secondTableNameOrAliasStartLine = $secondTableNameOrAliasStartLine;
    $this->secondTableNameOrAliasStartColumn = $secondTableNameOrAliasStartColumn;
    $this->secondTableNameOrAliasEndLine = $secondTableNameOrAliasEndLine;
    $this->secondTableNameOrAliasEndColumn = $secondTableNameOrAliasEndColumn;
    $this->secondColumnName = $secondColumnName;
    $this->secondColumnNameStartLine = $secondColumnNameStartLine;
    $this->secondColumnNameStartColumn = $secondColumnNameStartColumn;
    $this->secondColumnNameEndLine = $secondColumnNameEndLine;
    $this->secondColumnNameEndColumn = $secondColumnNameEndColumn;
  }
}
