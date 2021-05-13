<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent;
use PHPUnit\Framework\TestCase;

final class LogTokenizerTargetTest extends TestCase
{
  public function test_initially_empty()
  {
    $logTokenizerTarget = new LogTokenizerTarget();

    $this->assertEmpty($logTokenizerTarget->events);
  }

  public function test_logs_all_events()
  {
    $logTokenizerTarget = new LogTokenizerTarget();

    $logTokenizerTarget->token(31, 25, 84, 'Test Token Content');
    $logTokenizerTarget->unknown(20, 63, 99, 65, 'Test Unknown Content');
    $logTokenizerTarget->stringLiteral(22, 40, 88, 35, 'Test String Literal Content');
    $logTokenizerTarget->endOfFile(52, 61);
    $logTokenizerTarget->lineComment(52, 51, 46, 'Test Line Comment Content');

    $this->assertEquals([
      new TokenEvent(31, 25, 84, 'Test Token Content'),
      new UnknownEvent(20, 63, 99, 65, 'Test Unknown Content'),
      new StringLiteralEvent(22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new LineCommentEvent(52, 51, 46, 'Test Line Comment Content'),
    ], $logTokenizerTarget->events);
  }
}
