<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\Tokenizer;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\BacktickStringLiteralEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\WhiteSpaceEvent;
use PHPUnit\Framework\TestCase;

final class TokenizerTest extends TestCase
{
  public function test_empty_file()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    $tokenizer->endOfFile();

    $this->assertEquals([
      new EndOfFileEvent(1, 1),
    ], $logTokenizerTarget->events);
  }

  private function validFile($newline)
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split(preg_replace("~\r?\n~", $newline, "
  tokens}can:be-split<by>various[symbols]as(seen)here{or,here''
you can also write'single-quoted // strings\\
with or without backslashes \\\\ for newlines
(containing them)'or 'single-quote\\d \'strings\' surrounded by white space' like that
  start a//line comment using two forward slashes
  also works // with spaces
  triple-quoted '''
    strings are kinda magical
      indentation works \\''' as expected
    as does pulling it back \\
    and lines can be continued using one of the\\
    se backslashes
  '''
  tokens can be \"quote\\d to // allow \\\"spaces\\\" \\
  and
  such\"this sometimes\"does not need spaces\" around it
  finally `backtick strings // are not escapable`though`they`can be hemmed in
this line contains a fa/ke comment
''''''
'''a//'''
'''a'//'''
'''a''/'''
'''a'//''-'''
'''a''//'-'''
'''a''//''-'''
'''   '''
'''




'''
'''
    the most indented line // is first here
  the rest is less so.
'''
'''
  the most indented line // is last here
    the rest is less so.
'''
'''


  this has leading and trailing blank lines to remove.


'''
'''
  this has multiple lines


    with blank lines


  between.
'''
'''
        \
    these
            align
'''
'''
        \
    left
             right
'''
'''
        \
     right
            left
'''")) as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new WhiteSpaceEvent(1, 1, 2, 2, $newline."  "),
      new TokenEvent(2, 3, 8, 'tokens'),
      new TokenEvent(2, 9, 9, '}'),
      new TokenEvent(2, 10, 12, 'can'),
      new TokenEvent(2, 13, 13, ':'),
      new TokenEvent(2, 14, 15, 'be'),
      new TokenEvent(2, 16, 16, '-'),
      new TokenEvent(2, 17, 21, 'split'),
      new TokenEvent(2, 22, 22, '<'),
      new TokenEvent(2, 23, 24, 'by'),
      new TokenEvent(2, 25, 25, '>'),
      new TokenEvent(2, 26, 32, 'various'),
      new TokenEvent(2, 33, 33, '['),
      new TokenEvent(2, 34, 40, 'symbols'),
      new TokenEvent(2, 41, 41, ']'),
      new TokenEvent(2, 42, 43, 'as'),
      new TokenEvent(2, 44, 44, '('),
      new TokenEvent(2, 45, 48, 'seen'),
      new TokenEvent(2, 49, 49, ')'),
      new TokenEvent(2, 50, 53, 'here'),
      new TokenEvent(2, 54, 54, '{'),
      new TokenEvent(2, 55, 56, 'or'),
      new TokenEvent(2, 57, 57, ','),
      new TokenEvent(2, 58, 61, 'here'),
      new StringLiteralEvent(2, 62, 2, 63, ''),
      new WhiteSpaceEvent(2, 64, 2, 64, $newline),
      new TokenEvent(3, 1, 3, 'you'),
      new WhiteSpaceEvent(3, 4, 3, 4, ' '),
      new TokenEvent(3, 5, 7, 'can'),
      new WhiteSpaceEvent(3, 8, 3, 8, ' '),
      new TokenEvent(3, 9, 12, 'also'),
      new WhiteSpaceEvent(3, 13, 3, 13, ' '),
      new TokenEvent(3, 14, 18, 'write'),
      new StringLiteralEvent(3, 19, 5, 18, "single-quoted // strings\\".$newline."with or without backslashes \\\\ for newlines".$newline."(containing them)"),
      new TokenEvent(5, 19, 20, 'or'),
      new WhiteSpaceEvent(5, 21, 5, 21, ' '),
      new StringLiteralEvent(5, 22, 5, 75, 'single-quote\\d \'strings\' surrounded by white space'),
      new WhiteSpaceEvent(5, 76, 5, 76, ' '),
      new TokenEvent(5, 77, 80, 'like'),
      new WhiteSpaceEvent(5, 81, 5, 81, ' '),
      new TokenEvent(5, 82, 85, 'that'),
      new WhiteSpaceEvent(5, 86, 6, 2, $newline."  "),
      new TokenEvent(6, 3, 7, 'start'),
      new WhiteSpaceEvent(6, 8, 6, 8, ' '),
      new TokenEvent(6, 9, 9, 'a'),
      new LineCommentEvent(6, 10, 49, 'line comment using two forward slashes'),
      new WhiteSpaceEvent(6, 50, 7, 2, $newline."  "),
      new TokenEvent(7, 3, 6, 'also'),
      new WhiteSpaceEvent(7, 7, 7, 7, ' '),
      new TokenEvent(7, 8, 12, 'works'),
      new WhiteSpaceEvent(7, 13, 7, 13, ' '),
      new LineCommentEvent(7, 14, 27, ' with spaces'),
      new WhiteSpaceEvent(7, 28, 8, 2, $newline."  "),
      new TokenEvent(8, 3, 8, 'triple'),
      new TokenEvent(8, 9, 9, '-'),
      new TokenEvent(8, 10, 15, 'quoted'),
      new WhiteSpaceEvent(8, 16, 8, 16, ' '),
      new StringLiteralEvent(8, 17, 14, 5, 'strings are kinda magical'.$newline.'  indentation works \'\'\' as expected'.$newline.'as does pulling it back     and lines can be continued using one of the    se backslashes'),
      new WhiteSpaceEvent(14, 6, 15, 2, $newline."  "),
      new TokenEvent(15, 3, 8, 'tokens'),
      new WhiteSpaceEvent(15, 9, 15, 9, ' '),
      new TokenEvent(15, 10, 12, 'can'),
      new WhiteSpaceEvent(15, 13, 15, 13, ' '),
      new TokenEvent(15, 14, 15, 'be'),
      new WhiteSpaceEvent(15, 16, 15, 16, ' '),
      new StringLiteralEvent(15, 17, 17, 7, "quote\\d to // allow \"spaces\" \\".$newline."  and".$newline."  such"),
      new TokenEvent(17, 8, 11, 'this'),
      new WhiteSpaceEvent(17, 12, 17, 12, ' '),
      new TokenEvent(17, 13, 21, 'sometimes'),
      new StringLiteralEvent(17, 22, 17, 43, 'does not need spaces'),
      new WhiteSpaceEvent(17, 44, 17, 44, ' '),
      new TokenEvent(17, 45, 50, 'around'),
      new WhiteSpaceEvent(17, 51, 17, 51, ' '),
      new TokenEvent(17, 52, 53, 'it'),
      new WhiteSpaceEvent(17, 54, 18, 2, $newline."  "),
      new TokenEvent(18, 3, 9, 'finally'),
      new WhiteSpaceEvent(18, 10, 18, 10, ' '),
      new BacktickStringLiteralEvent(18, 11, 18, 49, 'backtick strings // are not escapable'),
      new TokenEvent(18, 50, 55, 'though'),
      new BacktickStringLiteralEvent(18, 56, 18, 61, 'they'),
      new TokenEvent(18, 62, 64, 'can'),
      new WhiteSpaceEvent(18, 65, 18, 65, ' '),
      new TokenEvent(18, 66, 67, 'be'),
      new WhiteSpaceEvent(18, 68, 18, 68, ' '),
      new TokenEvent(18, 69, 74, 'hemmed'),
      new WhiteSpaceEvent(18, 75, 18, 75, ' '),
      new TokenEvent(18, 76, 77, 'in'),
      new WhiteSpaceEvent(18, 78, 18, 78, $newline),
      new TokenEvent(19, 1, 4, 'this'),
      new WhiteSpaceEvent(19, 5, 19, 5, ' '),
      new TokenEvent(19, 6, 9, 'line'),
      new WhiteSpaceEvent(19, 10, 19, 10, ' '),
      new TokenEvent(19, 11, 18, 'contains'),
      new WhiteSpaceEvent(19, 19, 19, 19, ' '),
      new TokenEvent(19, 20, 20, 'a'),
      new WhiteSpaceEvent(19, 21, 19, 21, ' '),
      new TokenEvent(19, 22, 23, 'fa'),
      new UnknownEvent(19, 24, 19, 24, '/'),
      new TokenEvent(19, 25, 26, 'ke'),
      new WhiteSpaceEvent(19, 27, 19, 27, ' '),
      new TokenEvent(19, 28, 34, 'comment'),
      new WhiteSpaceEvent(19, 35, 19, 35, $newline),
      new StringLiteralEvent(20, 1, 20, 6, ''),
      new WhiteSpaceEvent(20, 7, 20, 7, $newline),
      new StringLiteralEvent(21, 1, 21, 9, 'a//'),
      new WhiteSpaceEvent(21, 10, 21, 10, $newline),
      new StringLiteralEvent(22, 1, 22, 10, 'a\'//'),
      new WhiteSpaceEvent(22, 11, 22, 11, $newline),
      new StringLiteralEvent(23, 1, 23, 10, 'a\'\'/'),
      new WhiteSpaceEvent(23, 11, 23, 11, $newline),
      new StringLiteralEvent(24, 1, 24, 13, 'a\'//\'\'-'),
      new WhiteSpaceEvent(24, 14, 24, 14, $newline),
      new StringLiteralEvent(25, 1, 25, 13, 'a\'\'//\'-'),
      new WhiteSpaceEvent(25, 14, 25, 14, $newline),
      new StringLiteralEvent(26, 1, 26, 14, 'a\'\'//\'\'-'),
      new WhiteSpaceEvent(26, 15, 26, 15, $newline),
      new StringLiteralEvent(27, 1, 27, 9, ''),
      new WhiteSpaceEvent(27, 10, 27, 10, $newline),
      new StringLiteralEvent(28, 1, 33, 3, ''),
      new WhiteSpaceEvent(33, 4, 33, 4, $newline),
      new StringLiteralEvent(34, 1, 37, 3, '  the most indented line // is first here'.$newline.'the rest is less so.'),
      new WhiteSpaceEvent(37, 4, 37, 4, $newline),
      new StringLiteralEvent(38, 1, 41, 3, 'the most indented line // is last here'.$newline.'  the rest is less so.'),
      new WhiteSpaceEvent(41, 4, 41, 4, $newline),
      new StringLiteralEvent(42, 1, 48, 3, 'this has leading and trailing blank lines to remove.'),
      new WhiteSpaceEvent(48, 4, 48, 4, $newline),
      new StringLiteralEvent(49, 1, 57, 3, 'this has multiple lines'.$newline.$newline.$newline.'  with blank lines'.$newline.$newline.$newline.'between.'),
      new WhiteSpaceEvent(57, 4, 57, 4, $newline),
      new StringLiteralEvent(58, 1, 62, 3, 'these'.$newline.'align'),
      new WhiteSpaceEvent(62, 4, 62, 4, $newline),
      new StringLiteralEvent(63, 1, 67, 3, 'left'.$newline.' right'),
      new WhiteSpaceEvent(67, 4, 67, 4, $newline),
      new StringLiteralEvent(68, 1, 72, 3, ' right'.$newline.'left'),
      new EndOfFileEvent(72, 4),
    ], $logTokenizerTarget->events);
  }

  public function test_valid_file_lf()
  {
    $this->validFile("\n");
  }

  public function test_valid_file_cr_lf()
  {
    $this->validFile("\r\n");
  }

  public function test_valid_file_cr()
  {
    $this->validFile("\r");
  }

  public function test_file_ends_with_white_space()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("   \t    ") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new WhiteSpaceEvent(1, 1, 1, 8, "   \t    "),
      new EndOfFileEvent(1, 9),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_token()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("example") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new TokenEvent(1, 1, 7, "example"),
      new EndOfFileEvent(1, 8),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_single_quote()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 1, "'"),
      new EndOfFileEvent(1, 2),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_single_quote_pair()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("''") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new StringLiteralEvent(1, 1, 1, 2, ''),
      new EndOfFileEvent(1, 3),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_unterminated_single_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'example") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 8, "'example"),
      new EndOfFileEvent(1, 9),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_backslash_in_single_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'\\") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 2, "'\\"),
      new EndOfFileEvent(1, 3),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_unterminated_double_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split('"') as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 1, '"'),
      new EndOfFileEvent(1, 2),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_backslash_in_double_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split('"\\') as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 2, '"\\'),
      new EndOfFileEvent(1, 3),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_in_triple_quoted_string_white_space()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'''") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 3, "'''"),
      new EndOfFileEvent(1, 4),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_in_triple_quoted_string_body()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'''a") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 4, "'''a"),
      new EndOfFileEvent(1, 5),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_backslash_in_triple_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'''\\") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 4, "'''\\"),
      new EndOfFileEvent(1, 5),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_single_quote_in_triple_quoted_string()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("''''") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 4, "''''"),
      new EndOfFileEvent(1, 5),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_backtick()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("`") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 1, "`"),
      new EndOfFileEvent(1, 2),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_forward_slash()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("/") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 1, "/"),
      new EndOfFileEvent(1, 2),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_double_forward_slash()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("//abc") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new LineCommentEvent(1, 1, 5, 'abc'),
      new EndOfFileEvent(1, 6),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_triple_quoted_backslash_cr()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'''\\\r") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 5, "'''\\\r"),
      new EndOfFileEvent(2, 1),
    ], $logTokenizerTarget->events);
  }

  public function test_file_ends_with_five_single_quotes()
  {
    $logTokenizerTarget = new LogTokenizerTarget();
    $tokenizer = new Tokenizer($logTokenizerTarget);

    foreach (str_split("'''''") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new UnknownEvent(1, 1, 1, 5, "'''''"),
      new EndOfFileEvent(1, 6),
    ], $logTokenizerTarget->events);
  }
}
