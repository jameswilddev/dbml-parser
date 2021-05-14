<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\QuotedTokenEvent;
use PHPUnit\Framework\TestCase;

final class QuotedTokenEventTest extends TestCase
{
  public function test()
  {
    $quotedTokenEvent = new QuotedTokenEvent(31, 25, 84, 'Test Quoted Token Content');

    $this->assertEquals(31, $quotedTokenEvent->line);
    $this->assertEquals(25, $quotedTokenEvent->startColumn);
    $this->assertEquals(84, $quotedTokenEvent->endColumn);
    $this->assertEquals('Test Quoted Token Content', $quotedTokenEvent->content);
  }
}
