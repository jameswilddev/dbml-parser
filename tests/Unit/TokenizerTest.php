<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

use JamesWildDev\DBMLParser\Tokenizer;
use JamesWildDev\DBMLParser\TokenizerTarget;
use PHPUnit\Framework\TestCase;

final class TokenizerTest extends TestCase
{
  public function testTokenizerEmpty()
  {
    $target = new TokenizerTargetRecorder();
    $tokenizer = new Tokenizer($target);

    $tokenizer->endOfFile();

    $this->assertEquals([
      new EndOfFileEvent(1, 1),
    ], $target->events);
  }

  public function testTokenizerValid()
  {
    $target = new TokenizerTargetRecorder();
    $tokenizer = new Tokenizer($target);

    $input = 'this_is_a_test';
    foreach (str_split($input) as $codepoint) {
      $tokenizer->character(ord($codepoint));
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new WordEvent(1, 1, 14, 'this_is_a_test'),
      new EndOfFileEvent(1, 15),
    ], $target->events);
  }
}
