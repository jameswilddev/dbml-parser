<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\EnumValueEvent;
use PHPUnit\Framework\TestCase;

final class EnumValueEventTest extends TestCase
{
  public function test()
  {
    $enumValueEvent = new EnumValueEvent(
      'Test Enum Name',
      'Test Name',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Enum Name', $enumValueEvent->enumName);
    $this->assertEquals('Test Name', $enumValueEvent->name);
    $this->assertEquals(12, $enumValueEvent->nameStartLine);
    $this->assertEquals(31, $enumValueEvent->nameStartColumn);
    $this->assertEquals(64, $enumValueEvent->nameEndLine);
    $this->assertEquals(17, $enumValueEvent->nameEndColumn);
  }
}
