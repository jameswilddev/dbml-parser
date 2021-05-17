<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\MultiTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
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

    $multiTokenizerTarget->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content');
    $multiTokenizerTarget->token(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content');
    $multiTokenizerTarget->token(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content');
    $multiTokenizerTarget->token(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content');
    $multiTokenizerTarget->endOfFile(52, 61);
    $multiTokenizerTarget->token(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content');
    $multiTokenizerTarget->token(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content');

    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content'),
    ], $targetA->events);
    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content'),
    ], $targetB->events);
    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content'),
    ], $targetC->events);
  }
}
