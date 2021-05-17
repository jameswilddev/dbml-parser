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

    $logTokenizerTarget->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content');
    $logTokenizerTarget->token(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content');
    $logTokenizerTarget->token(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content');
    $logTokenizerTarget->token(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content');
    $logTokenizerTarget->endOfFile(52, 61);
    $logTokenizerTarget->token(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content');
    $logTokenizerTarget->token(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content');

    $this->assertEquals([
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 31, 25, 11, 84, 'Test Token Content'),
      new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content'),
      new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content'),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content'),
      new EndOfFileEvent(52, 61),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 108, 47, 21, 45, 'Test Backtick String Literal Content'),
      new TokenEvent(TokenType::LINE_COMMENT, 14, 52, 51, 46, 'Test Line Comment Content'),
    ], $logTokenizerTarget->events);
  }
}
