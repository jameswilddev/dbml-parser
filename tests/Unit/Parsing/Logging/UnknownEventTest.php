<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\UnknownEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use PHPUnit\Framework\TestCase;

final class UnknownEventTest extends TestCase
{
  public function test()
  {
    $tokenEventA = new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw');
    $tokenEventB = new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw');
    $tokenEventC = new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw');

    $unknownEvent = new UnknownEvent([$tokenEventA, $tokenEventB, $tokenEventC]);

    $this->assertEquals([$tokenEventA, $tokenEventB, $tokenEventC], $unknownEvent->tokenEvents);
  }
}
