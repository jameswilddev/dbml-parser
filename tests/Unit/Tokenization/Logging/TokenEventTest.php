<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use PHPUnit\Framework\TestCase;

final class TokenEventTest extends TestCase
{
  public function test()
  {
    $tokenEvent = new TokenEvent(31, 25, 84, 'Test Token Content');

    $this->assertEquals(31, $tokenEvent->line);
    $this->assertEquals(25, $tokenEvent->startColumn);
    $this->assertEquals(84, $tokenEvent->endColumn);
    $this->assertEquals('Test Token Content', $tokenEvent->content);
  }
}
