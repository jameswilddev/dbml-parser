<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

final class EndOfFileEvent
{
  public $line;

  public $column;

  function __construct($line, $column)
  {
    $this->line = $line;
    $this->column = $column;
  }
}
