<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\EnumValueNoteEvent;
use PHPUnit\Framework\TestCase;

final class EnumValueNoteEventTest extends TestCase
{
  public function test()
  {
    $enumValueNoteEvent = new EnumValueNoteEvent(
      'Test Enum Name',
      'Test Name',
      'Test Content',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Enum Name', $enumValueNoteEvent->enumName);
    $this->assertEquals('Test Name', $enumValueNoteEvent->name);
    $this->assertEquals('Test Content', $enumValueNoteEvent->content);
    $this->assertEquals(12, $enumValueNoteEvent->contentStartLine);
    $this->assertEquals(31, $enumValueNoteEvent->contentStartColumn);
    $this->assertEquals(64, $enumValueNoteEvent->contentEndLine);
    $this->assertEquals(17, $enumValueNoteEvent->contentEndColumn);
  }
}
