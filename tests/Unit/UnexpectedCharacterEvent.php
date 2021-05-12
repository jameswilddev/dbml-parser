<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

final class UnexpectedCharacterEvent
{
  public $line;

  public $column;

  public $codepoint;

  function __construct($line, $column, $codepoint)
  {
    $this->line = $line;
    $this->column = $column;
    $this->codepoint = $codepoint;
  }
}
