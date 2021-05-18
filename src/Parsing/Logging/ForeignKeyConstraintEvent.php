<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a foreign key constraint event.
 */
final class ForeignKeyConstraintEvent
{
  /**
   * @var string $referencingTableNameOrAlias The name or an alias of the table which contains the referencing column.
   */
  public $referencingTableNameOrAlias;

  /**
   * @var integer $referencingTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the referencing column started.
   */
  public $referencingTableNameOrAliasStartLine;

  /**
   * @var integer $referencingTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the referencing column started.
   */
  public $referencingTableNameOrAliasStartColumn;

  /**
   * @var integer $referencingTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the referencing column ended.
   */
  public $referencingTableNameOrAliasEndLine;

  /**
   * @var integer $referencingTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the referencing column ended.
   */
  public $referencingTableNameOrAliasEndColumn;

  /**
   * @var string $referencingColumnName The name of the column which contains references.
   */
  public $referencingColumnName;

  /**
   * @var integer $referencingColumnNameStartLine The line number on which the column which contains references started.
   */
  public $referencingColumnNameStartLine;

  /**
   * @var integer $referencingColumnNameStartColumn The column number on which the column which contains references started.
   */
  public $referencingColumnNameStartColumn;

  /**
   * @var integer $referencingColumnNameEndLine The line number on which the column which contains references ended.
   */
  public $referencingColumnNameEndLine;

  /**
   * @var integer $referencingColumnNameEndColumn The column number on which the column which contains references ended.
   */
  public $referencingColumnNameEndColumn;

  /**
   * @var string $referencedTableNameOrAlias The name or an alias of the table which contains the column to be referred to.
   */
  public $referencedTableNameOrAlias;

  /**
   * @var integer $referencedTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the column to be referred to started.
   */
  public $referencedTableNameOrAliasStartLine;

  /**
   * @var integer $referencedTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the column to be referred to started.
   */
  public $referencedTableNameOrAliasStartColumn;

  /**
   * @var integer $referencedTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the column to be referred to ended.
   */
  public $referencedTableNameOrAliasEndLine;

  /**
   * @var integer $referencedTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the column to be referred to ended.
   */
  public $referencedTableNameOrAliasEndColumn;

  /**
   * @var string $referencedColumnName The name of the column which contains values to be referred to.
   */
  public $referencedColumnName;

  /**
   * @var integer $referencedColumnNameStartLine The line number on which the name of the column which contains values to be referred to started.
   */
  public $referencedColumnNameStartLine;

  /**
   * @var integer $referencedColumnNameStartColumn The column number on which the name of the column which contains values to be referred to started.
   */
  public $referencedColumnNameStartColumn;

  /**
   * @var integer $referencedColumnNameEndLine The line number on which the name of the column which contains values to be referred to ended.
   */
  public $referencedColumnNameEndLine;

  /**
   * @var integer $referencedColumnNameEndColumn The column number on which the name of the column which contains values to be referred to ended.
   */
  public $referencedColumnNameEndColumn;

  /**
   * @param string $referencingTableNameOrAlias The name or an alias of the table which contains the referencing column.
   * @param integer $referencingTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the referencing column started.
   * @param integer $referencingTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the referencing column started.
   * @param integer $referencingTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the referencing column ended.
   * @param integer $referencingTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the referencing column ended.
   * @param string $referencingColumnName The name of the column which contains references.
   * @param integer $referencingColumnNameStartLine The line number on which the column which contains references started.
   * @param integer $referencingColumnNameStartColumn The column number on which the column which contains references started.
   * @param integer $referencingColumnNameEndLine The line number on which the column which contains references ended.
   * @param integer $referencingColumnNameEndColumn The column number on which the column which contains references ended.
   * @param string $referencedTableNameOrAlias The name or an alias of the table which contains the column to be referred to.
   * @param integer $referencedTableNameOrAliasStartLine The line number on which the name or an alias of the table which contains the column to be referred to started.
   * @param integer $referencedTableNameOrAliasStartColumn The column number on which the name or an alias of the table which contains the column to be referred to started.
   * @param integer $referencedTableNameOrAliasEndLine The line number on which the name or an alias of the table which contains the column to be referred to ended.
   * @param integer $referencedTableNameOrAliasEndColumn The column number on which the name or an alias of the table which contains the column to be referred to ended.
   * @param string $referencedColumnName The name of the column which contains values to be referred to.
   * @param integer $referencedColumnNameStartLine The line number on which the name of the column which contains values to be referred to started.
   * @param integer $referencedColumnNameStartColumn The column number on which the name of the column which contains values to be referred to started.
   * @param integer $referencedColumnNameEndLine The line number on which the name of the column which contains values to be referred to ended.
   * @param integer $referencedColumnNameEndColumn The column number on which the name of the column which contains values to be referred to ended.
   */
  function __construct(
    $referencingTableNameOrAlias,
    $referencingTableNameOrAliasStartLine,
    $referencingTableNameOrAliasStartColumn,
    $referencingTableNameOrAliasEndLine,
    $referencingTableNameOrAliasEndColumn,
    $referencingColumnName,
    $referencingColumnNameStartLine,
    $referencingColumnNameStartColumn,
    $referencingColumnNameEndLine,
    $referencingColumnNameEndColumn,
    $referencedTableNameOrAlias,
    $referencedTableNameOrAliasStartLine,
    $referencedTableNameOrAliasStartColumn,
    $referencedTableNameOrAliasEndLine,
    $referencedTableNameOrAliasEndColumn,
    $referencedColumnName,
    $referencedColumnNameStartLine,
    $referencedColumnNameStartColumn,
    $referencedColumnNameEndLine,
    $referencedColumnNameEndColumn
  ) {
    $this->referencingTableNameOrAlias = $referencingTableNameOrAlias;
    $this->referencingTableNameOrAliasStartLine = $referencingTableNameOrAliasStartLine;
    $this->referencingTableNameOrAliasStartColumn = $referencingTableNameOrAliasStartColumn;
    $this->referencingTableNameOrAliasEndLine = $referencingTableNameOrAliasEndLine;
    $this->referencingTableNameOrAliasEndColumn = $referencingTableNameOrAliasEndColumn;
    $this->referencingColumnName = $referencingColumnName;
    $this->referencingColumnNameStartLine = $referencingColumnNameStartLine;
    $this->referencingColumnNameStartColumn = $referencingColumnNameStartColumn;
    $this->referencingColumnNameEndLine = $referencingColumnNameEndLine;
    $this->referencingColumnNameEndColumn = $referencingColumnNameEndColumn;
    $this->referencedTableNameOrAlias = $referencedTableNameOrAlias;
    $this->referencedTableNameOrAliasStartLine = $referencedTableNameOrAliasStartLine;
    $this->referencedTableNameOrAliasStartColumn = $referencedTableNameOrAliasStartColumn;
    $this->referencedTableNameOrAliasEndLine = $referencedTableNameOrAliasEndLine;
    $this->referencedTableNameOrAliasEndColumn = $referencedTableNameOrAliasEndColumn;
    $this->referencedColumnName = $referencedColumnName;
    $this->referencedColumnNameStartLine = $referencedColumnNameStartLine;
    $this->referencedColumnNameStartColumn = $referencedColumnNameStartColumn;
    $this->referencedColumnNameEndLine = $referencedColumnNameEndLine;
    $this->referencedColumnNameEndColumn = $referencedColumnNameEndColumn;
  }
}
