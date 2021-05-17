<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\Tokenizer;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
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
      new TokenEvent(TokenType::WHITE_SPACE, 1, 1, 2, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 3, 2, 8, 'tokens', 'tokens'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 9, 2, 9, '}', '}'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 10, 2, 12, 'can', 'can'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 13, 2, 13, ':', ':'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 14, 2, 15, 'be', 'be'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 16, 2, 16, '-', '-'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 17, 2, 21, 'split', 'split'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 22, 2, 22, '<', '<'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 23, 2, 24, 'by', 'by'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 25, 2, 25, '>', '>'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 26, 2, 32, 'various', 'various'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 33, 2, 33, '[', '['),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 34, 2, 40, 'symbols', 'symbols'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 41, 2, 41, ']', ']'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 42, 2, 43, 'as', 'as'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 44, 2, 44, '(', '('),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 45, 2, 48, 'seen', 'seen'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 49, 2, 49, ')', ')'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 50, 2, 53, 'here', 'here'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 54, 2, 54, '{', '{'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 55, 2, 56, 'or', 'or'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 57, 2, 57, ',', ','),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 2, 58, 2, 61, 'here', 'here'),
      new TokenEvent(TokenType::STRING_LITERAL, 2, 62, 2, 63, '', '\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 2, 64, 2, 64, $newline, $newline),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 3, 1, 3, 3, 'you', 'you'),
      new TokenEvent(TokenType::WHITE_SPACE, 3, 4, 3, 4, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 3, 5, 3, 7, 'can', 'can'),
      new TokenEvent(TokenType::WHITE_SPACE, 3, 8, 3, 8, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 3, 9, 3, 12, 'also', 'also'),
      new TokenEvent(TokenType::WHITE_SPACE, 3, 13, 3, 13, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 3, 14, 3, 18, 'write', 'write'),
      new TokenEvent(TokenType::STRING_LITERAL, 3, 19, 5, 18, "single-quoted // strings\\".$newline."with or without backslashes \\\\ for newlines".$newline."(containing them)", "'single-quoted // strings\\".$newline."with or without backslashes \\\\ for newlines".$newline."(containing them)'"),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 5, 19, 5, 20, 'or', 'or'),
      new TokenEvent(TokenType::WHITE_SPACE, 5, 21, 5, 21, ' ', ' '),
      new TokenEvent(TokenType::STRING_LITERAL, 5, 22, 5, 75, 'single-quote\\d \'strings\' surrounded by white space', '\'single-quote\\d \\\'strings\\\' surrounded by white space\''),
      new TokenEvent(TokenType::WHITE_SPACE, 5, 76, 5, 76, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 5, 77, 5, 80, 'like', 'like'),
      new TokenEvent(TokenType::WHITE_SPACE, 5, 81, 5, 81, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 5, 82, 5, 85, 'that', 'that'),
      new TokenEvent(TokenType::WHITE_SPACE, 5, 86, 6, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 6, 3, 6, 7, 'start', 'start'),
      new TokenEvent(TokenType::WHITE_SPACE, 6, 8, 6, 8, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 6, 9, 6, 9, 'a', 'a'),
      new TokenEvent(TokenType::LINE_COMMENT, 6, 10, 6, 49, 'line comment using two forward slashes', '//line comment using two forward slashes'),
      new TokenEvent(TokenType::WHITE_SPACE, 6, 50, 7, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 7, 3, 7, 6, 'also', 'also'),
      new TokenEvent(TokenType::WHITE_SPACE, 7, 7, 7, 7, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 7, 8, 7, 12, 'works', 'works'),
      new TokenEvent(TokenType::WHITE_SPACE, 7, 13, 7, 13, ' ', ' '),
      new TokenEvent(TokenType::LINE_COMMENT, 7, 14, 7, 27, ' with spaces', '// with spaces'),
      new TokenEvent(TokenType::WHITE_SPACE, 7, 28, 8, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 8, 3, 8, 8, 'triple', 'triple'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 8, 9, 8, 9, '-', '-'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 8, 10, 8, 15, 'quoted', 'quoted'),
      new TokenEvent(TokenType::WHITE_SPACE, 8, 16, 8, 16, ' ', ' '),
      new TokenEvent(TokenType::STRING_LITERAL, 8, 17, 14, 5, 'strings are kinda magical'.$newline.'  indentation works \'\'\' as expected'.$newline.'as does pulling it back     and lines can be continued using one of the    se backslashes', '\'\'\''.$newline.'    strings are kinda magical'.$newline.'      indentation works \\\'\'\' as expected'.$newline.'    as does pulling it back \\'.$newline.'    and lines can be continued using one of the\\'.$newline.'    se backslashes'.$newline.'  \'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 14, 6, 15, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 15, 3, 15, 8, 'tokens', 'tokens'),
      new TokenEvent(TokenType::WHITE_SPACE, 15, 9, 15, 9, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 15, 10, 15, 12, 'can', 'can'),
      new TokenEvent(TokenType::WHITE_SPACE, 15, 13, 15, 13, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 15, 14, 15, 15, 'be', 'be'),
      new TokenEvent(TokenType::WHITE_SPACE, 15, 16, 15, 16, ' ', ' '),
      new TokenEvent(TokenType::STRING_LITERAL, 15, 17, 17, 7, "quote\\d to // allow \"spaces\" \\".$newline."  and".$newline."  such", '"quote\\d to // allow \\"spaces\\" \\'.$newline.'  and'.$newline.'  such"'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 17, 8, 17, 11, 'this', 'this'),
      new TokenEvent(TokenType::WHITE_SPACE, 17, 12, 17, 12, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 17, 13, 17, 21, 'sometimes', 'sometimes'),
      new TokenEvent(TokenType::STRING_LITERAL, 17, 22, 17, 43, 'does not need spaces', '"does not need spaces"'),
      new TokenEvent(TokenType::WHITE_SPACE, 17, 44, 17, 44, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 17, 45, 17, 50, 'around', 'around'),
      new TokenEvent(TokenType::WHITE_SPACE, 17, 51, 17, 51, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 17, 52, 17, 53, 'it', 'it'),
      new TokenEvent(TokenType::WHITE_SPACE, 17, 54, 18, 2, $newline."  ", $newline."  "),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 3, 18, 9, 'finally', 'finally'),
      new TokenEvent(TokenType::WHITE_SPACE, 18, 10, 18, 10, ' ', ' '),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 18, 11, 18, 49, 'backtick strings // are not escapable', '`backtick strings // are not escapable`'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 50, 18, 55, 'though', 'though'),
      new TokenEvent(TokenType::BACKTICK_STRING_LITERAL, 18, 56, 18, 61, 'they', '`they`'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 62, 18, 64, 'can', 'can'),
      new TokenEvent(TokenType::WHITE_SPACE, 18, 65, 18, 65, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 66, 18, 67, 'be', 'be'),
      new TokenEvent(TokenType::WHITE_SPACE, 18, 68, 18, 68, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 69, 18, 74, 'hemmed', 'hemmed'),
      new TokenEvent(TokenType::WHITE_SPACE, 18, 75, 18, 75, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 18, 76, 18, 77, 'in', 'in'),
      new TokenEvent(TokenType::WHITE_SPACE, 18, 78, 18, 78, $newline, $newline),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 1, 19, 4, 'this', 'this'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 5, 19, 5, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 6, 19, 9, 'line', 'line'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 10, 19, 10, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 11, 19, 18, 'contains', 'contains'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 19, 19, 19, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 20, 19, 20, 'a', 'a'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 21, 19, 21, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 22, 19, 23, 'fa', 'fa'),
      new TokenEvent(TokenType::UNKNOWN, 19, 24, 19, 24, '/', '/'),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 25, 19, 26, 'ke', 'ke'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 27, 19, 27, ' ', ' '),
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 19, 28, 19, 34, 'comment', 'comment'),
      new TokenEvent(TokenType::WHITE_SPACE, 19, 35, 19, 35, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 20, 1, 20, 6, '', '\'\'\'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 20, 7, 20, 7, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 21, 1, 21, 9, 'a//', '\'\'\'a//\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 21, 10, 21, 10, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 22, 1, 22, 10, 'a\'//', '\'\'\'a\'//\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 22, 11, 22, 11, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 23, 1, 23, 10, 'a\'\'/', '\'\'\'a\'\'/\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 23, 11, 23, 11, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 24, 1, 24, 13, 'a\'//\'\'-', '\'\'\'a\'//\'\'-\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 24, 14, 24, 14, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 25, 1, 25, 13, 'a\'\'//\'-', '\'\'\'a\'\'//\'-\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 25, 14, 25, 14, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 26, 1, 26, 14, 'a\'\'//\'\'-', '\'\'\'a\'\'//\'\'-\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 26, 15, 26, 15, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 27, 1, 27, 9, '', '\'\'\'   \'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 27, 10, 27, 10, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 28, 1, 33, 3, '', '\'\'\''.$newline.$newline.$newline.$newline.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 33, 4, 33, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 34, 1, 37, 3, '  the most indented line // is first here'.$newline.'the rest is less so.', '\'\'\''.$newline.'    the most indented line // is first here'.$newline.'  the rest is less so.'.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 37, 4, 37, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 38, 1, 41, 3, 'the most indented line // is last here'.$newline.'  the rest is less so.', '\'\'\''.$newline.'  the most indented line // is last here'.$newline.'    the rest is less so.'.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 41, 4, 41, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 42, 1, 48, 3, 'this has leading and trailing blank lines to remove.', '\'\'\''.$newline.$newline.$newline.'  this has leading and trailing blank lines to remove.'.$newline.$newline.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 48, 4, 48, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 49, 1, 57, 3, 'this has multiple lines'.$newline.$newline.$newline.'  with blank lines'.$newline.$newline.$newline.'between.', '\'\'\''.$newline.'  this has multiple lines'.$newline.$newline.$newline.'    with blank lines'.$newline.$newline.$newline.'  between.'.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 57, 4, 57, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 58, 1, 62, 3, 'these'.$newline.'align', '\'\'\''.$newline.'        \\'.$newline.'    these'.$newline.'            align'.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 62, 4, 62, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 63, 1, 67, 3, 'left'.$newline.' right', '\'\'\''.$newline.'        \\'.$newline.'    left'.$newline.'             right'.$newline.'\'\'\''),
      new TokenEvent(TokenType::WHITE_SPACE, 67, 4, 67, 4, $newline, $newline),
      new TokenEvent(TokenType::STRING_LITERAL, 68, 1, 72, 3, ' right'.$newline.'left', '\'\'\''.$newline.'        \\'.$newline.'     right'.$newline.'            left'.$newline.'\'\'\''),
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
      new TokenEvent(TokenType::WHITE_SPACE, 1, 1, 1, 8, "   \t    ", "   \t    "),
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
      new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 1, 1, 1, 7, "example", "example"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 1, "'", "'"),
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
      new TokenEvent(TokenType::STRING_LITERAL, 1, 1, 1, 2, '', '\'\''),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 8, "'example", "'example"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 2, "'\\", "'\\"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 1, '"', '"'),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 2, '"\\', '"\\'),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 3, "'''", "'''"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 4, "'''a", "'''a"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 4, "'''\\", "'''\\"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 4, "''''", "''''"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 1, "`", "`"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 1, "/", "/"),
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
      new TokenEvent(TokenType::LINE_COMMENT, 1, 1, 1, 5, 'abc', '//abc'),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 5, "'''\\\r", "'''\\\r"),
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
      new TokenEvent(TokenType::UNKNOWN, 1, 1, 1, 5, "'''''", "'''''"),
      new EndOfFileEvent(1, 6),
    ], $logTokenizerTarget->events);
  }
}
