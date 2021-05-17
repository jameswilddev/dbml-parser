<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

use JamesWildDev\DBMLParser\Tokenization\TokenizerTarget;

/**
 * Records events for later review.
 */
final class LogTokenizerTarget implements TokenizerTarget
{
  /**
   * @var array $events An array of the events which were received.
   */
  public $events = [];

  /**
   * Handle the end of the file.
   *
   * @param integer $line The line number on which the file ended.
   * @param integer $column The column number on which the file ended.
   */
  public function endOfFile($line, $column)
  {
    $this->events []= new EndOfFileEvent($line, $column);
  }

  /**
   * Handle a token.
   *
   * @param integer $type The type of the token (see TYPE_*).
   * @param integer $startLine The line number on which the token started.
   * @param integer $startColumn The column number on which the token started.
   * @param integer $endLine The line number on which the token ended.
   * @param integer $endColumn The column number on which the token ended.
   * @param string $content The content of the token.
   * @param string $raw The exact sequence of characters which were interpreted as this token.
   */
  public function token($type, $startLine, $startColumn, $endLine, $endColumn, $content, $raw)
  {
    $this->events []= new TokenEvent($type, $startLine, $startColumn, $endLine, $endColumn, $content, $raw);
  }
}
