<?php

namespace JamesWildDev\DBMLParser\Tests\Unit;

use JamesWildDev\DBMLParser\TokenizerTarget;

final class TokenizerTargetRecorder implements TokenizerTarget
{
  public $events;

  public function endOfFile($line, $column)
  {
    $this->events []= new EndOfFileEvent($line, $column);
  }

  public function openingBrace($line, $column)
  {
    $this->events []= new OpeningBraceEvent($line, $column);
  }

  public function closingBrace($line, $column)
  {
    $this->events []= new ClosingBraceEvent($line, $column);
  }

  public function openingBracket($line, $column)
  {
    $this->events []= new OpeningBracketEvent($line, $column);
  }

  public function closingBracket($line, $column)
  {
    $this->events []= new ClosingBracketEvent($line, $column);
  }

  public function semicolon($line, $column)
  {
    $this->events []= new SemicolonEvent($line, $column);
  }

  public function greaterThan($line, $column)
  {
    $this->events []= new GreaterThanEvent($line, $column);
  }

  public function lessThan($line, $column)
  {
    $this->events []= new LessThanEvent($line, $column);
  }

  public function hyphen($line, $column)
  {
    $this->events []= new HyphenEvent($line, $column);
  }

  public function lineComment($line, $startColumn, $endColumn, $content)
  {
    $this->events []= new LineCommentEvent($line, $startColumn, $endColumn, $content);
  }

  public function word($line, $startColumn, $endColumn, $content)
  {
    $this->events []= new WordEvent($line, $startColumn, $endColumn, $content);
  }

  public function stringLiteral($line, $startColumn, $endLine, $endColumn, $content)
  {
    $this->events []= new StringLiteralEvent($line, $startColumn, $endLine, $endColumn, $conte);
  }

  public function unexpectedCharacter($line, $column, $codepoint)
  {
    $this->events []= new UnexpectedCharacterEvent($line, $column, $codepoint);
  }

  public function unexpectedEndOfFile($line, $column)
  {
    $this->events []= new UnexpectedEndOfFileEvent($line, $column);
  }
}
