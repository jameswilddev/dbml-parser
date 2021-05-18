<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnConstantDefaultEvent;
use PHPUnit\Framework\TestCase;

final class ColumnConstantDefaultEventTest extends TestCase
{
  public function test()
  {
    $columnConstantDefaultEvent = new ColumnConstantDefaultEvent(
      'Test Table Name',
      'Test Column Name',
      'Test Content',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Table Name', $columnConstantDefaultEvent->tableName);
    $this->assertEquals('Test Column Name', $columnConstantDefaultEvent->columnName);
    $this->assertEquals('Test Content', $columnConstantDefaultEvent->content);
    $this->assertEquals(12, $columnConstantDefaultEvent->contentStartLine);
    $this->assertEquals(31, $columnConstantDefaultEvent->contentStartColumn);
    $this->assertEquals(64, $columnConstantDefaultEvent->contentEndLine);
    $this->assertEquals(17, $columnConstantDefaultEvent->contentEndColumn);
  }
}
