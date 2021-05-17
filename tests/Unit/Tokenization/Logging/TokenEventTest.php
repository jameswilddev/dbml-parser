<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use PHPUnit\Framework\TestCase;

final class TokenEventTest extends TestCase
{
  public function test()
  {
    $tokenEvent = new TokenEvent(TokenType::WHITE_SPACE, 31, 25, 88, 84, 'Test Token Content');

    $this->assertEquals(TokenType::WHITE_SPACE, $tokenEvent->type);
    $this->assertEquals(31, $tokenEvent->startLine);
    $this->assertEquals(25, $tokenEvent->startColumn);
    $this->assertEquals(88, $tokenEvent->endLine);
    $this->assertEquals(84, $tokenEvent->endColumn);
    $this->assertEquals('Test Token Content', $tokenEvent->content);
  }
}
