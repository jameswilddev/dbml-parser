<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\TableEvent;
use PHPUnit\Framework\TestCase;

final class TableEventTest extends TestCase
{
  public function test()
  {
    $tableEvent = new TableEvent(
      'Test Name',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Name', $tableEvent->name);
    $this->assertEquals(12, $tableEvent->nameStartLine);
    $this->assertEquals(31, $tableEvent->nameStartColumn);
    $this->assertEquals(64, $tableEvent->nameEndLine);
    $this->assertEquals(17, $tableEvent->nameEndColumn);
  }
}
