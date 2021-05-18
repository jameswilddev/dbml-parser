<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of an enum value declaration event.
 */
final class EnumValueEvent
{
  /**
   * @var string $enumName The name of the parent enum.
   */
  public $enumName;

  /**
   * @var string $name The name of the enum.
   */
  public $name;

  /**
   * @var integer $nameStartLine The line number on which the name of the value started.
   */
  public $nameStartLine;

  /**
   * @var integer $nameStartColumn The column number on which the name of the value started.
   */
  public $nameStartColumn;

  /**
   * @var integer $nameEndLine The line number on which the name of the value ended.
   */
  public $nameEndLine;

  /**
   * @var integer $nameEndColumn The column number on which the name of the value ended.
   */
  public $nameEndColumn;

  /**
   * @param string $enumName The name of the parent enum.
   * @param string $name The name of the value.
   * @param integer $nameStartLine The line number on which the name of the value started.
   * @param integer $nameStartColumn The column number on which the name of the value started.
   * @param integer $nameEndLine The line number on which the name of the value ended.
   * @param integer $nameEndColumn The column number on which the name of the value ended.
   */
  function __construct($enumName, $name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->enumName = $enumName;
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
  }
}
