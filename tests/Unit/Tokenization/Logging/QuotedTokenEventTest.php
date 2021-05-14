<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\QuotedTokenEvent;
use PHPUnit\Framework\TestCase;

final class QuotedTokenEventTest extends TestCase
{
  public function test()
  {
    $tokenEvent = new QuotedTokenEvent(31, 25, 84, 'Test Quoted Token Content');

    $this->assertEquals(31, $tokenEvent->line);
    $this->assertEquals(25, $tokenEvent->startColumn);
    $this->assertEquals(84, $tokenEvent->endColumn);
    $this->assertEquals('Test Quoted Token Content', $tokenEvent->content);
  }
}
