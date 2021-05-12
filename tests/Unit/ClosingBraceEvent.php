<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

final class ClosingBraceEvent
{
  public $line;

  public $column;

  function __construct($line, $column)
  {
    $this->line = $line;
    $this->column = $column;
  }
}
