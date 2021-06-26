<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\ParserTarget;

/**
 * Records events for later review.
 */
final class LogParserTarget implements ParserTarget
{
  /**
   * @var array $events An array of the events which were received.
   */
  public $events = [];

  /**
   * Handle the declaration of a table.
   *
   * @param string $name The name of the table.
   * @param integer $nameStartLine The line number on which the name of the table started.
   * @param integer $nameStartColumn The column number on which the name of the table started.
   * @param integer $nameEndLine The line number on which the name of the table ended.
   * @param integer $nameEndColumn The column number on which the name of the table ended.
   */
  public function table($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->events []= new TableEvent($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn);
  }

  /**
   * Handle the declaration of a table alias.
   *
   * @param string $tableName The name of the parent table.
   * @param string $name The name of the table alias.
   * @param integer $nameStartLine The line number on which the name of the table alias started.
   * @param integer $nameStartColumn The column number on which the name of the table alias started.
   * @param integer $nameEndLine The line number on which the name of the table alias ended.
   * @param integer $nameEndColumn The column number on which the name of the table alias ended.
   */
  public function tableAlias($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->events []= new TableAliasEvent($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn);
  }

  /**
   * Handle the declaration of a table note.
   *
   * @param string $tableName The name of the table to which a note is to be added.
   * @param string $content The content of the note to be added.
   * @param integer $contentStartLine The line number on which the note started.
   * @param integer $contentStartColumn The column number on which the note started.
   * @param integer $contentEndLine The line number on which the note ended.
   * @param integer $contentEndColumn The column number on which the note ended.
   */
  public function tableNote($tableName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->events []= new TableNoteEvent($tableName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn);
  }

  /**
   * Handle the declaration of a column.
   *
   * @param string $tableName The name of the parent table.
   * @param string $name The name of the column.
   * @param integer $nameStartLine The line number on which the name of the column started.
   * @param integer $nameStartColumn The column number on which the name of the column started.
   * @param integer $nameEndLine The line number on which the name of the column ended.
   * @param integer $nameEndColumn The column number on which the name of the column ended.
   * @param string $type The column's type.
   * @param ?string $size The column's size, if specified, otherwise, null.
   */
  public function column($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $type, $size)
  {
    $this->events []= new ColumnEvent($tableName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $type, $size);
  }

  /**
   * Handle the declaration of a column note.
   *
   * @param string $tableName The name of the table which contains the column to which a note is to be added.
   * @param string $columnName The name of the column to which a note is to be added.
   * @param string $content The content of the note to be added.
   * @param integer $contentStartLine The line number on which the note started.
   * @param integer $contentStartColumn The column number on which the note started.
   * @param integer $contentEndLine The line number on which the note ended.
   * @param integer $contentEndColumn The column number on which the note ended.
   */
  public function columnNote($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->events []= new ColumnNoteEvent($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn);
  }

  /**
   * Handle the declaration that a column is a primary key.
   *
   * @param string $tableName The name of the table which contains the column which is a primary key.
   * @param string $columnName The name of the column which is a primary key.
   */
  public function columnPrimaryKey($tableName, $columnName)
  {
    $this->events []= new ColumnPrimaryKeyEvent($tableName, $columnName);
  }

  /**
   * Handle the declaration that a column is auto-incrementing.
   *
   * @param string $tableName The name of the table which contains the column which is auto-incrementing.
   * @param string $columnName The name of the column which is auto-incrementing.
   */
  public function columnIncrement($tableName, $columnName)
  {
    $this->events []= new ColumnIncrementEvent($tableName, $columnName);
  }

  /**
   * Handle the declaration that a column is not nullable.
   *
   * @param string $tableName The name of the table which contains the column which is not nullable.
   * @param string $columnName The name of the column which is not nullable.
   */
  public function columnNotNull($tableName, $columnName)
  {
    $this->events []= new ColumnNotNullEvent($tableName, $columnName);
  }

  /**
   * Handle the declaration that a column is to have a constant default value.
   *
   * @param string $tableName The name of the table which contains the column which is to have a constant default value.
   * @param string $columnName The name of the column which is to have a constant default value.
   * @param string $content The default value.
   * @param integer $contentStartLine The line number on which the default value started.
   * @param integer $contentStartColumn The column number on which the default value started.
   * @param integer $contentEndLine The line number on which the default value ended.
   * @param integer $contentEndColumn The column number on which the default value ended.
   */
  public function columnConstantDefault($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->events []= new ColumnConstantDefaultEvent($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn);
  }

  /**
   * Handle the declaration that a column is to have a calculated default value.
   *
   * @param string $tableName The name of the table which contains the column which is to have a calculated default value.
   * @param string $columnName The name of the column which is to have a calculated default value.
   * @param string $content The query used to calculate the default value.
   * @param integer $contentStartLine The line number on which the query used to calculate the default value started.
   * @param integer $contentStartColumn The column number on which the query used to calculate the default value started.
   * @param integer $contentEndLine The line number on which the query used to calculate the default value ended.
   * @param integer $contentEndColumn The column number on which the query used to calculate the default value ended.
   */
  public function columnCalculatedDefault($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->events []= new ColumnCalculatedDefaultEvent($tableName, $columnName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn);
  }

  /**
   * Handle the declaration of a ref.
   *
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
   * @param integer $operator The operator of the ref (see RefOperator::*).
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
  public function ref(
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
    $operator,
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
    $this->events []= new RefEvent(
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
      $operator,
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
    );
  }

  /**
   * Handle the declaration that one or more columns within a table are to have an index.
   *
   * @param string $tableName The name of the table which contains the columns which are to have an index.
   * @param string $columns An array of associative arrays where:
   *                        - name => The name of the column (string).
   *                        - nameStartLine => The line number on which the name of the column started.
   *                        - nameStartColumn => The line number on which the name of the column started.
   *                        - nameEndLine => The line number on which the name of the column ended.
   *                        - nameEndColumn => The line number on which the name of the column ended.
   * @param ?string $name The name of the index, if any, otherwise, null.
   * @param ?integer $nameStartLine The line number on which the name of the index started, if any, otherwise, null.
   * @param ?integer $nameStartColumn The column number on which the name of the index started, if any, otherwise, null.
   * @param ?integer $nameEndLine The line number on which the name of the index ended, if any, otherwise, null.
   * @param ?integer $nameEndColumn The column number on which the name of the index ended, if any, otherwise, null.
   * @param boolean $unique When true, duplicate sets of the values are disallowed.  When false, they are allowed.
   */
  public function index($tableName, $columns, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $unique)
  {
    $this->events []= new IndexEvent($tableName, $columns, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $unique);
  }

  /**
   * Handle the declaration of an enum.
   *
   * @param string $name The name of the enum.
   * @param integer $nameStartLine The line number on which the name of the enum started.
   * @param integer $nameStartColumn The column number on which the name of the enum started.
   * @param integer $nameEndLine The line number on which the name of the enum ended.
   * @param integer $nameEndColumn The column number on which the name of the enum ended.
   */
  public function enum($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->events []= new EnumEvent($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn);
  }

  /**
   * Handle the declaration of a value of an enum.
   *
   * @param string $enumName The name of the parent enum.
   * @param string $name The name of the value.
   * @param integer $nameStartLine The line number on which the name of the value started.
   * @param integer $nameStartColumn The column number on which the name of the value started.
   * @param integer $nameEndLine The line number on which the name of the value ended.
   * @param integer $nameEndColumn The column number on which the name of the value ended.
   */
  public function enumValue($enumName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->events []= new EnumValueEvent($enumName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn);
  }

  /**
   * Handle the declaration of an enum value note.
   *
   * @param string $enumName The name of the enum which contains the value to which a note is to be added.
   * @param string $name The name of the value to which a note is to be added.
   * @param string $content The content of the note to be added.
   * @param integer $contentStartLine The line number on which the note started.
   * @param integer $contentStartColumn The column number on which the note started.
   * @param integer $contentEndLine The line number on which the note ended.
   * @param integer $contentEndColumn The column number on which the note ended.
   */
  public function enumValueNote($enumName, $name, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->events []= new EnumValueNoteEvent($enumName, $name, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn);
  }

  /**
   * Handle an unknown sequence of tokens.
   *
   * @param array $tokenEvents The tokens found.
   */
  public function unknown($tokenEvents)
  {
    $this->events []= new UnknownEvent($tokenEvents);
  }

  /**
   * Handle the end of the file.
   *
   * @param bool $expected True when the end-of-file was expected, otherwise, false.
   */
  public function endOfFile($expected)
  {
    $this->events []= new EndOfFileEvent($expected);
  }
}
