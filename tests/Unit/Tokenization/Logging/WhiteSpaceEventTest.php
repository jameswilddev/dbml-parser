<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\WhiteSpaceEvent;
use PHPUnit\Framework\TestCase;

final class WhiteSpaceEventTest extends TestCase
{
  public function test()
  {
    $whiteSpaceEvent = new WhiteSpaceEvent(20, 63, 99, 65, 'Test White Space Content');

    $this->assertEquals(20, $whiteSpaceEvent->startLine);
    $this->assertEquals(63, $whiteSpaceEvent->startColumn);
    $this->assertEquals(99, $whiteSpaceEvent->endLine);
    $this->assertEquals(65, $whiteSpaceEvent->endColumn);
    $this->assertEquals('Test White Space Content', $whiteSpaceEvent->content);
  }
}
