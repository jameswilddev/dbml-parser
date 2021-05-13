<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use PHPUnit\Framework\TestCase;

final class EndOfFileEventTest extends TestCase
{
  public function test()
  {
    $endOfFileEvent = new EndOfFileEvent(52, 61);

    $this->assertEquals(52, $endOfFileEvent->line);
    $this->assertEquals(61, $endOfFileEvent->column);
  }
}
