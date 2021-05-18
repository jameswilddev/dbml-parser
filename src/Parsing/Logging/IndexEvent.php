<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of an index declaration event.
 */
final class IndexEvent
{
  /**
   * @var string $tableName The name of the table which contains the columns which are to have an index.
   */
  public $tableName;

  /**
   * @var string $columns An array of associative arrays where:
   *                      - name => The name of the column (string).
   *                      - nameStartLine => The line number on which the name of the column started.
   *                      - nameStartColumn => The line number on which the name of the column started.
   *                      - nameEndLine => The line number on which the name of the column ended.
   *                      - nameEndColumn => The line number on which the name of the column ended.
   */
  public $columns;

  /**
   * @var ?string $name The name of the index, if any, otherwise, null.
   */
  public $name;

  /**
   * @var ?integer $nameStartLine The line number on which the name of the index started, if any, otherwise, null.
   */
  public $nameStartLine;

  /**
   * @var ?integer $nameStartColumn The column number on which the name of the index started, if any, otherwise, null.
   */
  public $nameStartColumn;

  /**
   * @var ?integer $nameEndLine The line number on which the name of the index ended, if any, otherwise, null.
   */
  public $nameEndLine;

  /**
   * @var ?integer $nameEndColumn The column number on which the name of the index ended, if any, otherwise, null.
   */
  public $nameEndColumn;

  /**
   * @var boolean $unique When true, duplicate sets of the values are disallowed.  When false, they are allowed.
   */
  public $unique;

  /**
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
  function __construct($tableName, $columns, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn, $unique)
  {
    $this->tableName = $tableName;
    $this->columns = $columns;
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
    $this->unique = $unique;
  }
}
