<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnCalculatedDefaultEvent;
use PHPUnit\Framework\TestCase;

final class ColumnCalculatedDefaultEventTest extends TestCase
{
  public function test()
  {
    $columnCalculatedDefaultEvent = new ColumnCalculatedDefaultEvent(
      'Test Table Name',
      'Test Column Name',
      'Test Content',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Table Name', $columnCalculatedDefaultEvent->tableName);
    $this->assertEquals('Test Column Name', $columnCalculatedDefaultEvent->columnName);
    $this->assertEquals('Test Content', $columnCalculatedDefaultEvent->content);
    $this->assertEquals(12, $columnCalculatedDefaultEvent->contentStartLine);
    $this->assertEquals(31, $columnCalculatedDefaultEvent->contentStartColumn);
    $this->assertEquals(64, $columnCalculatedDefaultEvent->contentEndLine);
    $this->assertEquals(17, $columnCalculatedDefaultEvent->contentEndColumn);
  }
}
