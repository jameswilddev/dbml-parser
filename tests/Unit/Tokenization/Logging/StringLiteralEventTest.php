<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent;
use PHPUnit\Framework\TestCase;

final class StringLiteralEventTest extends TestCase
{
  public function test()
  {
    $stringLiteralEvent = new StringLiteralEvent(20, 63, 99, 65, 'Test String Literal Content');

    $this->assertEquals(20, $stringLiteralEvent->startLine);
    $this->assertEquals(63, $stringLiteralEvent->startColumn);
    $this->assertEquals(99, $stringLiteralEvent->endLine);
    $this->assertEquals(65, $stringLiteralEvent->endColumn);
    $this->assertEquals('Test String Literal Content', $stringLiteralEvent->content);
  }
}
