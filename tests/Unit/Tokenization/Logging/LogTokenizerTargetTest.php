<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
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

    $logTokenizerTarget->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw');
    $logTokenizerTarget->token(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw');
    $logTokenizerTarget->token(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw');
    $logTokenizerTarget->token(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw');
    $logTokenizerTarget->endOfFile(52, 61);
    $logTokenizerTarget->token(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw');
    $logTokenizerTarget->token(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw');

    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content', 'Test Token Raw'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content', 'Test Backtick String Literal Raw'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content', 'Test Line Comment Raw'),
    ], $logTokenizerTarget->events);
  }
}
