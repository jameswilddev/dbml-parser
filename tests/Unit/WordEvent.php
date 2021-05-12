<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

final class WordEvent
{
  public $line;

  public $startColumn;

  public $endColumn;

  public $content;

  function __construct($line, $startColumn, $endColumn, $content)
  {
    $this->line = $line;
    $this->startColumn = $startColumn;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
