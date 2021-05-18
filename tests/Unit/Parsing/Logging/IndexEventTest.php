<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\IndexEvent;
use PHPUnit\Framework\TestCase;

final class IndexEventTest extends TestCase
{
  public function test_without_name_non_unique()
  {
    $indexEvent = new IndexEvent(
      'Test Table Name',
      [
        [
          'name' => 'Test Column A Name',
          'nameStartLine' => 72,
          'nameStartColumn' => 14,
          'nameEndLine' => 64,
          'nameEndColumn' => 55,
        ],
        [
          'name' => 'Test Column B Name',
          'nameStartLine' => 26,
          'nameStartColumn' => 85,
          'nameEndLine' => 71,
          'nameEndColumn' => 22,
        ],
        [
          'name' => 'Test Column C Name',
          'nameStartLine' => 46,
          'nameStartColumn' => 58,
          'nameEndLine' => 99,
          'nameEndColumn' => 86,
        ],
      ],
      null,
      null,
      null,
      null,
      null,
      false
    );

    $this->assertEquals('Test Table Name', $indexEvent->tableName);
    $this->assertEquals([
      [
        'name' => 'Test Column A Name',
        'nameStartLine' => 72,
        'nameStartColumn' => 14,
        'nameEndLine' => 64,
        'nameEndColumn' => 55,
      ],
      [
        'name' => 'Test Column B Name',
        'nameStartLine' => 26,
        'nameStartColumn' => 85,
        'nameEndLine' => 71,
        'nameEndColumn' => 22,
      ],
      [
        'name' => 'Test Column C Name',
        'nameStartLine' => 46,
        'nameStartColumn' => 58,
        'nameEndLine' => 99,
        'nameEndColumn' => 86,
      ],
    ], $indexEvent->columns);
    $this->assertNull($indexEvent->name);
    $this->assertNull($indexEvent->nameStartLine);
    $this->assertNull($indexEvent->nameStartColumn);
    $this->assertNull($indexEvent->nameEndLine);
    $this->assertNull($indexEvent->nameEndColumn);
    $this->assertFalse($indexEvent->unique);
  }

  public function test_with_name_non_unique()
  {
    $indexEvent = new IndexEvent(
      'Test Table Name',
      [
        [
          'name' => 'Test Column A Name',
          'nameStartLine' => 72,
          'nameStartColumn' => 14,
          'nameEndLine' => 64,
          'nameEndColumn' => 55,
        ],
        [
          'name' => 'Test Column B Name',
          'nameStartLine' => 26,
          'nameStartColumn' => 85,
          'nameEndLine' => 71,
          'nameEndColumn' => 22,
        ],
        [
          'name' => 'Test Column C Name',
          'nameStartLine' => 46,
          'nameStartColumn' => 58,
          'nameEndLine' => 99,
          'nameEndColumn' => 86,
        ],
      ],
      'Test Name',
      12,
      31,
      64,
      17,
      false
    );

    $this->assertEquals('Test Table Name', $indexEvent->tableName);
    $this->assertEquals([
      [
        'name' => 'Test Column A Name',
        'nameStartLine' => 72,
        'nameStartColumn' => 14,
        'nameEndLine' => 64,
        'nameEndColumn' => 55,
      ],
      [
        'name' => 'Test Column B Name',
        'nameStartLine' => 26,
        'nameStartColumn' => 85,
        'nameEndLine' => 71,
        'nameEndColumn' => 22,
      ],
      [
        'name' => 'Test Column C Name',
        'nameStartLine' => 46,
        'nameStartColumn' => 58,
        'nameEndLine' => 99,
        'nameEndColumn' => 86,
      ],
    ], $indexEvent->columns);
    $this->assertEquals('Test Name', $indexEvent->name);
    $this->assertEquals(12, $indexEvent->nameStartLine);
    $this->assertEquals(31, $indexEvent->nameStartColumn);
    $this->assertEquals(64, $indexEvent->nameEndLine);
    $this->assertEquals(17, $indexEvent->nameEndColumn);
    $this->assertFalse($indexEvent->unique);
  }

  public function test_without_name_unique()
  {
    $indexEvent = new IndexEvent(
      'Test Table Name',
      [
        [
          'name' => 'Test Column A Name',
          'nameStartLine' => 72,
          'nameStartColumn' => 14,
          'nameEndLine' => 64,
          'nameEndColumn' => 55,
        ],
        [
          'name' => 'Test Column B Name',
          'nameStartLine' => 26,
          'nameStartColumn' => 85,
          'nameEndLine' => 71,
          'nameEndColumn' => 22,
        ],
        [
          'name' => 'Test Column C Name',
          'nameStartLine' => 46,
          'nameStartColumn' => 58,
          'nameEndLine' => 99,
          'nameEndColumn' => 86,
        ],
      ],
      null,
      null,
      null,
      null,
      null,
      true
    );

    $this->assertEquals('Test Table Name', $indexEvent->tableName);
    $this->assertEquals([
      [
        'name' => 'Test Column A Name',
        'nameStartLine' => 72,
        'nameStartColumn' => 14,
        'nameEndLine' => 64,
        'nameEndColumn' => 55,
      ],
      [
        'name' => 'Test Column B Name',
        'nameStartLine' => 26,
        'nameStartColumn' => 85,
        'nameEndLine' => 71,
        'nameEndColumn' => 22,
      ],
      [
        'name' => 'Test Column C Name',
        'nameStartLine' => 46,
        'nameStartColumn' => 58,
        'nameEndLine' => 99,
        'nameEndColumn' => 86,
      ],
    ], $indexEvent->columns);
    $this->assertNull($indexEvent->name);
    $this->assertNull($indexEvent->nameStartLine);
    $this->assertNull($indexEvent->nameStartColumn);
    $this->assertNull($indexEvent->nameEndLine);
    $this->assertNull($indexEvent->nameEndColumn);
    $this->assertTrue($indexEvent->unique);
  }

  public function test_with_name_unique()
  {
    $indexEvent = new IndexEvent(
      'Test Table Name',
      [
        [
          'name' => 'Test Column A Name',
          'nameStartLine' => 72,
          'nameStartColumn' => 14,
          'nameEndLine' => 64,
          'nameEndColumn' => 55,
        ],
        [
          'name' => 'Test Column B Name',
          'nameStartLine' => 26,
          'nameStartColumn' => 85,
          'nameEndLine' => 71,
          'nameEndColumn' => 22,
        ],
        [
          'name' => 'Test Column C Name',
          'nameStartLine' => 46,
          'nameStartColumn' => 58,
          'nameEndLine' => 99,
          'nameEndColumn' => 86,
        ],
      ],
      'Test Name',
      12,
      31,
      64,
      17,
      true
    );

    $this->assertEquals('Test Table Name', $indexEvent->tableName);
    $this->assertEquals([
      [
        'name' => 'Test Column A Name',
        'nameStartLine' => 72,
        'nameStartColumn' => 14,
        'nameEndLine' => 64,
        'nameEndColumn' => 55,
      ],
      [
        'name' => 'Test Column B Name',
        'nameStartLine' => 26,
        'nameStartColumn' => 85,
        'nameEndLine' => 71,
        'nameEndColumn' => 22,
      ],
      [
        'name' => 'Test Column C Name',
        'nameStartLine' => 46,
        'nameStartColumn' => 58,
        'nameEndLine' => 99,
        'nameEndColumn' => 86,
      ],
    ], $indexEvent->columns);
    $this->assertEquals('Test Name', $indexEvent->name);
    $this->assertEquals(12, $indexEvent->nameStartLine);
    $this->assertEquals(31, $indexEvent->nameStartColumn);
    $this->assertEquals(64, $indexEvent->nameEndLine);
    $this->assertEquals(17, $indexEvent->nameEndColumn);
    $this->assertTrue($indexEvent->unique);
  }
}
