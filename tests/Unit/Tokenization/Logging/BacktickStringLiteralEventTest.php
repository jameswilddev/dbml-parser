<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\BacktickStringLiteralEvent;
use PHPUnit\Framework\TestCase;

final class BacktickStringLiteralEventTest extends TestCase
{
  public function test()
  {
    $backtickStringLiteralEvent = new BacktickStringLiteralEvent(20, 63, 99, 65, 'Test Backtick String Literal Content');

    $this->assertEquals(20, $backtickStringLiteralEvent->startLine);
    $this->assertEquals(63, $backtickStringLiteralEvent->startColumn);
    $this->assertEquals(99, $backtickStringLiteralEvent->endLine);
    $this->assertEquals(65, $backtickStringLiteralEvent->endColumn);
    $this->assertEquals('Test Backtick String Literal Content', $backtickStringLiteralEvent->content);
  }
}
