<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent;
use PHPUnit\Framework\TestCase;

final class LineCommentEventTest extends TestCase
{
  public function test()
  {
    $lineCommentEvent = new LineCommentEvent(52, 51, 46, 'Test Line Comment Content');

    $this->assertEquals(52, $lineCommentEvent->line);
    $this->assertEquals(51, $lineCommentEvent->startColumn);
    $this->assertEquals(46, $lineCommentEvent->endColumn);
    $this->assertEquals('Test Line Comment Content', $lineCommentEvent->content);
  }
}
