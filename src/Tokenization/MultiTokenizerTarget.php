<?php

namespace JamesWildDev\DBMLParser\Tokenization;

/**
 * Forwards events to multiple TokenizerTargets.
 */
final class MultiTokenizerTarget implements TokenizerTarget
{
  /**
   * @var array $targets An array of TokenizerTargets to pass to.
   */
  private $targets;

  /**
   * @param array $targets An array of TokenizerTargets to pass to.
   */
  function __construct($targets)
  {
    $this->targets = $targets;
  }

  /**
   * Handle the end of the file.
   *
   * @param integer $line The line number on which the file ended.
   * @param integer $column The column number on which the file ended.
   */
  public function endOfFile($line, $column)
  {
    foreach ($this->targets as $target) {
      $target->endOfFile($line, $column);
    }
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
   */
  public function token($type, $startLine, $startColumn, $endLine, $endColumn, $content)
  {
    foreach ($this->targets as $target) {
      $target->token($type, $startLine, $startColumn, $endLine, $endColumn, $content);
    }
  }
}
