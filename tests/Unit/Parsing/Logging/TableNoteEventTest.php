<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\TableNoteEvent;
use PHPUnit\Framework\TestCase;

final class TableNoteEventTest extends TestCase
{
  public function test()
  {
    $tableNoteEvent = new TableNoteEvent(
      'Test Table Name',
      'Test Content',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Table Name', $tableNoteEvent->tableName);
    $this->assertEquals('Test Content', $tableNoteEvent->content);
    $this->assertEquals(12, $tableNoteEvent->contentStartLine);
    $this->assertEquals(31, $tableNoteEvent->contentStartColumn);
    $this->assertEquals(64, $tableNoteEvent->contentEndLine);
    $this->assertEquals(17, $tableNoteEvent->contentEndColumn);
  }
}
