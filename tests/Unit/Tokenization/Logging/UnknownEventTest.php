<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent;
use PHPUnit\Framework\TestCase;

final class UnknownEventTest extends TestCase
{
  public function test()
  {
    $unknownEvent = new UnknownEvent(20, 63, 99, 65, 'Test Unknown Content');

    $this->assertEquals(20, $unknownEvent->startLine);
    $this->assertEquals(63, $unknownEvent->startColumn);
    $this->assertEquals(99, $unknownEvent->endLine);
    $this->assertEquals(65, $unknownEvent->endColumn);
    $this->assertEquals('Test Unknown Content', $unknownEvent->content);
  }
}
