<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnEvent;
use PHPUnit\Framework\TestCase;

final class ColumnEventTest extends TestCase
{
  public function test_without_size()
  {
    $columnEvent = new ColumnEvent(
      'Test Table Name',
      'Test Name',
      12,
      31,
      64,
      17,
      'Test Type',
      null
    );

    $this->assertEquals('Test Table Name', $columnEvent->tableName);
    $this->assertEquals('Test Name', $columnEvent->name);
    $this->assertEquals(12, $columnEvent->nameStartLine);
    $this->assertEquals(31, $columnEvent->nameStartColumn);
    $this->assertEquals(64, $columnEvent->nameEndLine);
    $this->assertEquals(17, $columnEvent->nameEndColumn);
    $this->assertEquals('Test Type', $columnEvent->type);
    $this->assertNull($columnEvent->size);
  }

  public function test_with_size()
  {
    $columnEvent = new ColumnEvent(
      'Test Table Name',
      'Test Name',
      12,
      31,
      64,
      17,
      'Test Type',
      'Test Size'
    );

    $this->assertEquals('Test Table Name', $columnEvent->tableName);
    $this->assertEquals('Test Name', $columnEvent->name);
    $this->assertEquals(12, $columnEvent->nameStartLine);
    $this->assertEquals(31, $columnEvent->nameStartColumn);
    $this->assertEquals(64, $columnEvent->nameEndLine);
    $this->assertEquals(17, $columnEvent->nameEndColumn);
    $this->assertEquals('Test Type', $columnEvent->type);
    $this->assertEquals('Test Size', $columnEvent->size);
  }
}
