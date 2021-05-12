<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

final class SemicolonEvent
{
  public $line;

  public $column;

  function __construct($line, $column)
  {
    $this->line = $line;
    $this->column = $column;
  }
}
