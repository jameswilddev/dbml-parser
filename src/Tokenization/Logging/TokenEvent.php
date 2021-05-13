<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a token event.
 */
final class TokenEvent
{
  /**
   * @var integer $line The line number on which the token was found.
   */
  public $line;

  /**
   * @var integer $startColumn The column number on which the token started.
   */
  public $startColumn;

  /**
   * @var integer $endColumn The column number on which the token ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the token.
   */
  public $content;

  /**
   * @param integer $line The line number on which the token was found.
   * @param integer $startColumn The column number on which the token started.
   * @param integer $endColumn The column number on which the token ended.
   * @param string $content The content of the token.
   */
  function __construct($line, $startColumn, $endColumn, $content)
  {
    $this->line = $line;
    $this->startColumn = $startColumn;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
