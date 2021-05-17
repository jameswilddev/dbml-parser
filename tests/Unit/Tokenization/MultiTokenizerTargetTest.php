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

    $multiTokenizerTarget->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw');
    $multiTokenizerTarget->token(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw');
    $multiTokenizerTarget->token(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw');
    $multiTokenizerTarget->token(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw');
    $multiTokenizerTarget->endOfFile(52, 61);
    $multiTokenizerTarget->token(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw');
    $multiTokenizerTarget->token(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw');

    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw'),
    ], $targetA->events);
    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw'),
    ], $targetB->events);
    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw'),
    ], $targetC->events);
  }
}
