<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of an enum declaration event.
 */
final class EnumEvent
{
  /**
   * @var string $name The name of the enum.
   */
  public $name;

  /**
   * @var integer $nameStartLine The line number on which the name of the enum started.
   */
  public $nameStartLine;

  /**
   * @var integer $nameStartColumn The column number on which the name of the enum started.
   */
  public $nameStartColumn;

  /**
   * @var integer $nameEndLine The line number on which the name of the enum ended.
   */
  public $nameEndLine;

  /**
   * @var integer $nameEndColumn The column number on which the name of the enum ended.
   */
  public $nameEndColumn;

  /**
   * @param string $name The name of the enum.
   * @param integer $nameStartLine The line number on which the name of the enum started.
   * @param integer $nameStartColumn The column number on which the name of the enum started.
   * @param integer $nameEndLine The line number on which the name of the enum ended.
   * @param integer $nameEndColumn The column number on which the name of the enum ended.
   */
  function __construct($name, $nameStartLine, $nameStartColumn, $nameEndLine, $nameEndColumn)
  {
    $this->name = $name;
    $this->nameStartLine = $nameStartLine;
    $this->nameStartColumn = $nameStartColumn;
    $this->nameEndLine = $nameEndLine;
    $this->nameEndColumn = $nameEndColumn;
  }
}
