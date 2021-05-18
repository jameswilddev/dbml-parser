<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnNoteEvent;
use PHPUnit\Framework\TestCase;

final class ColumnNoteEventTest extends TestCase
{
  public function test()
  {
    $columnNoteEvent = new ColumnNoteEvent(
      'Test Table Name',
      'Test Column Name',
      'Test Content',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Table Name', $columnNoteEvent->tableName);
    $this->assertEquals('Test Column Name', $columnNoteEvent->columnName);
    $this->assertEquals('Test Content', $columnNoteEvent->content);
    $this->assertEquals(12, $columnNoteEvent->contentStartLine);
    $this->assertEquals(31, $columnNoteEvent->contentStartColumn);
    $this->assertEquals(64, $columnNoteEvent->contentEndLine);
    $this->assertEquals(17, $columnNoteEvent->contentEndColumn);
  }
}
