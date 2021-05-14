<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\MultiTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\QuotedTokenEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent;
use PHPUnit\Framework\TestCase;

final class MultiTokenizerTargetTest extends TestCase
{
  public function test_initial_state()
  {
    $targetA = new LogTokenizerTarget();
    $targetB = new LogTokenizerTarget();
    $targetC = new LogTokenizerTarget();

    $multiTokenizerTarget = new MultiTokenizerTarget([
      $targetA,
      $targetB,
      $targetC,
    ]);

    $this->assertEmpty($targetA->events);
    $this->assertEmpty($targetB->events);
    $this->assertEmpty($targetC->events);
  }

  public function test_replicates_all_events()
  {
    $targetA = new LogTokenizerTarget();
    $targetB = new LogTokenizerTarget();
    $targetC = new LogTokenizerTarget();
    $multiTokenizerTarget = new MultiTokenizerTarget([
      $targetA,
      $targetB,
      $targetC,
    ]);

    $multiTokenizerTarget->token(31, 25, 84, 'Test Token Content');
    $multiTokenizerTarget->unknown(20, 63, 99, 65, 'Test Unknown Content');
    $multiTokenizerTarget->quotedToken(67, 13, 24, 'Test Quoted Token Content');
    $multiTokenizerTarget->stringLiteral(22, 40, 88, 35, 'Test String Literal Content');
    $multiTokenizerTarget->endOfFile(52, 61);
    $multiTokenizerTarget->lineComment(52, 51, 46, 'Test Line Comment Content');

    $this->assertEquals([
      new TokenEvent(31, 25, 84, 'Test Token Content'),
      new UnknownEvent(20, 63, 99, 65, 'Test Unknown Content'),
      new QuotedTokenEvent(67, 13, 24, 'Test Quoted Token Content'),
      new StringLiteralEvent(22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new LineCommentEvent(52, 51, 46, 'Test Line Comment Content'),
    ], $targetA->events);
    $this->assertEquals([
      new TokenEvent(31, 25, 84, 'Test Token Content'),
      new UnknownEvent(20, 63, 99, 65, 'Test Unknown Content'),
      new QuotedTokenEvent(67, 13, 24, 'Test Quoted Token Content'),
      new StringLiteralEvent(22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new LineCommentEvent(52, 51, 46, 'Test Line Comment Content'),
    ], $targetB->events);
    $this->assertEquals([
      new TokenEvent(31, 25, 84, 'Test Token Content'),
      new UnknownEvent(20, 63, 99, 65, 'Test Unknown Content'),
      new QuotedTokenEvent(67, 13, 24, 'Test Quoted Token Content'),
      new StringLiteralEvent(22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new LineCommentEvent(52, 51, 46, 'Test Line Comment Content'),
    ], $targetC->events);
  }
}
