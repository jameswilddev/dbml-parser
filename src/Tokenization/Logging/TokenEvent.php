<?php

namespace JamesWildDev\DBMLParser\Tokenization\Logging;

/**
 * A record of a token event.
 */
final class TokenEvent
{
  /**
   * @var integer $type The type of the token (see TYPE_*).
   */
  public $type;

  /**
   * @var integer $startLine The line number on which the token started.
   */
  public $startLine;

  /**
   * @var integer $startColumn The column number on which the token started.
   */
  public $startColumn;

  /**
   * @var integer $endLine The line number on which the token ended.
   */
  public $endLine;

  /**
   * @var integer $endColumn The column number on which the token ended.
   */
  public $endColumn;

  /**
   * @var string $content The content of the token.
   */
  public $content;

  /**
   * @param integer $type The type of the token (see TokenType::*).
   * @param integer $startLine The line number on which the token started.
   * @param integer $startColumn The column number on which the token started.
   * @param integer $endLine The line number on which the token ended.
   * @param integer $endColumn The column number on which the token ended.
   * @param string $content The content of the token.
   */
  function __construct($type, $startLine, $startColumn, $endLine, $endColumn, $content)
  {
    $this->type = $type;
    $this->startLine = $startLine;
    $this->startColumn = $startColumn;
    $this->endLine = $endLine;
    $this->endColumn = $endColumn;
    $this->content = $content;
  }
}
