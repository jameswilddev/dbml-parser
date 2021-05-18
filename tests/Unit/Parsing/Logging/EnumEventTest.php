<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\EnumEvent;
use PHPUnit\Framework\TestCase;

final class EnumEventTest extends TestCase
{
  public function test()
  {
    $enumEvent = new EnumEvent(
      'Test Name',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Name', $enumEvent->name);
    $this->assertEquals(12, $enumEvent->nameStartLine);
    $this->assertEquals(31, $enumEvent->nameStartColumn);
    $this->assertEquals(64, $enumEvent->nameEndLine);
    $this->assertEquals(17, $enumEvent->nameEndColumn);
  }
}
