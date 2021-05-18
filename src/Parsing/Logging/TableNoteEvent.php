<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of a table note event.
 */
final class TableNoteEvent
{
  /**
   * @var string $tableName The name of the table to which a note is to be added.
   */
  public $tableName;

  /**
   * @var string $content The content of the note to be added.
   */
  public $content;

  /**
   * @var integer $contentStartLine The line number on which the note started.
   */
  public $contentStartLine;

  /**
   * @var integer $contentStartColumn The column number on which the note started.
   */
  public $contentStartColumn;

  /**
   * @var integer $contentEndLine The line number on which the note ended.
   */
  public $contentEndLine;

  /**
   * @var integer $contentEndColumn The column number on which the note ended.
   */
  public $contentEndColumn;

  /**
   * @param string $tableName The name of the table to which a note is to be added.
   * @param string $content The content of the note to be added.
   * @param integer $contentStartLine The line number on which the note started.
   * @param integer $contentStartColumn The column number on which the note started.
   * @param integer $contentEndLine The line number on which the note ended.
   * @param integer $contentEndColumn The column number on which the note ended.
   */
  function __construct($tableName, $content, $contentStartLine, $contentStartColumn, $contentEndLine, $contentEndColumn)
  {
    $this->tableName = $tableName;
    $this->content = $content;
    $this->contentStartLine = $contentStartLine;
    $this->contentStartColumn = $contentStartColumn;
    $this->contentEndLine = $contentEndLine;
    $this->contentEndColumn = $contentEndColumn;
  }
}
