<?php

namespace JamesWildDev\DBMLParser\Parsing;

use \Exception;
use JamesWildDev\DBMLParser\Parsing\ParserState;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;

/**
 * Identifies statements in a stream of tokens.
 */
class Parser
{
  /**
   * @var ParserTarget $target Notified of all statements.
   */
  private $target;

  /**
   * @var integer $state The current state (see ParserState::*).
   */
  private $state = ParserState::BETWEEN_STATEMENTS;

  /**
   * @var string $tableName The name of the table currently being parsed.
   */
  private $tableName;

  /**
   * @var integer $tableNameStartLine The line number on which the name of the table currently being parsed started.
   */
  private $tableNameStartLine;

  /**
   * @var integer $tableNameStartColumn The column number on which the name of the table currently being parsed started.
   */
  private $tableNameStartColumn;

  /**
   * @var integer $tableNameEndLine The line number on which the name of the table currently being parsed ended.
   */
  private $tableNameEndLine;

  /**
   * @var integer $tableNameEndColumn The column number on which the name of the table currently being parsed ended.
   */
  private $tableNameEndColumn;

  /**
   * @var string $columnName The name of the column currently being parsed.
   */
  private $columnName;

  /**
   * @var integer $columnNameStartLine The line number on which the name of the column currently being parsed started.
   */
  private $columnNameStartLine;

  /**
   * @var integer $columnNameStartColumn The column number on which the name of the column currently being parsed started.
   */
  private $columnNameStartColumn;

  /**
   * @var integer $columnNameEndLine The line number on which the name of the column currently being parsed ended.
   */
  private $columnNameEndLine;

  /**
   * @var integer $columnNameEndColumn The column number on which the name of the column currently being parsed ended.
   */
  private $columnNameEndColumn;

  /**
   * @var string $columnType The type of the column currently being parsed.
   */
  private $columnType;

  /**
   * @var string $columnSize The size of the column currently being parsed.
   */
  private $columnSize;

  /**
   * @var string $content The content currently being parsed.
   */
  private $content;

  /**
   * @var integer $contentStartLine The line number on which the content currently being parsed started.
   */
  private $contentStartLine;

  /**
   * @var integer $contentStartColumn The column number on which the content currently being parsed started.
   */
  private $contentStartColumn;

  /**
   * @var integer $contentEndLine The line number on which the content currently being parsed ended.
   */
  private $contentEndLine;

  /**
   * @var integer $contentEndColumn The column number on which the content currently being parsed ended.
   */
  private $contentEndColumn;

  /**
   * @var string $referencingTableNameOrAlias The name of the table from which the current ref is adding a reference.
   */
  private $referencingTableNameOrAlias;

  /**
   * @var integer $referencingTableNameOrAliasStartLine The line number on which the name or alias of the table from which the current ref is adding a reference.
   */
  private $referencingTableNameOrAliasStartLine;

  /**
   * @var integer $referencingTableNameOrAliasStartColumn The column number on which the name or alias of the table from which the current ref is adding a reference.
   */
  private $referencingTableNameOrAliasStartColumn;

  /**
   * @var integer $referencingTableNameOrAliasEndLine The line number on which the name or alias of the table from which the current ref is adding a reference.
   */
  private $referencingTableNameOrAliasEndLine;

  /**
   * @var integer $referencingTableNameOrAliasEndColumn The column number on which the name or alias of the table from which the current ref is adding a reference.
   */
  private $referencingTableNameOrAliasEndColumn;

  /**
   * @var string $referencingColumnName The name of the column from which the current ref is adding a reference.
   */
  private $referencingColumnName;

  /**
   * @var integer $referencingColumnNameStartLine The line number on which the name of the column from which the current ref is adding a reference.
   */
  private $referencingColumnNameStartLine;

  /**
   * @var integer $referencingColumnNameStartColumn The column number on which the name of the column from which the current ref is adding a reference.
   */
  private $referencingColumnNameStartColumn;

  /**
   * @var integer $referencingColumnNameEndLine The line number on which the name of the column from which the current ref is adding a reference.
   */
  private $referencingColumnNameEndLine;

  /**
   * @var integer $referencingColumnNameEndColumn The column number on which the name of the column from which the current ref is adding a reference.
   */
  private $referencingColumnNameEndColumn;

  /**
   * @var integer $refOperator The operator of the current ref (see RefOperator::*).
   */
  private $refOperator;

  /**
   * @var string $referencedTableNameOrAlias The name or alias of the table referenced by the current ref.
   */
  private $referencedTableNameOrAlias;

  /**
   * @var integer $referencedTableNameOrAliasStartLine The line number on which the name or alias of the table referenced by the current ref started.
   */
  private $referencedTableNameOrAliasStartLine;

  /**
   * @var integer $referencedTableNameOrAliasStartColumn The column number on which the name or alias of the table referenced by the current ref started.
   */
  private $referencedTableNameOrAliasStartColumn;

  /**
   * @var integer $referencedTableNameOrAliasEndLine The line number on which the name or alias of the table referenced by the current ref ended.
   */
  private $referencedTableNameOrAliasEndLine;

  /**
   * @var integer $referencedTableNameOrAliasEndColumn The column number on which the name or alias of the table referenced by the current ref ended.
   */
  private $referencedTableNameOrAliasEndColumn;

  /**
   * @var string $referencedColumnName The name of the column referenced by the current ref.
   */
  private $referencedColumnName;

  /**
   * @var integer $referencedColumnNameStartLine The line number on which the name of the column referenced by the current ref started.
   */
  private $referencedColumnNameStartLine;

  /**
   * @var integer $referencedColumnNameStartColumn The column number on which the name of the column referenced by the current ref started.
   */
  private $referencedColumnNameStartColumn;

  /**
   * @var integer $referencedColumnNameEndLine The line number on which the name of the column referenced by the current ref ended.
   */
  private $referencedColumnNameEndLine;

  /**
   * @var integer $referencedColumnNameEndColumn The column number on which the name of the column referenced by the current ref ended.
   */
  private $referencedColumnNameEndColumn;

  /**
   * @var array $indexColumns The columns of the index currently being parsed.
   */
  private $indexColumns;

  /**
   * @var ?string $indexName The name of the index currently being parsed, if any, else, null.
   */
  private $indexName;

  /**
   * @var ?integer $indexNameStartLine The line number on which the name of the index currently being parsed started, if any, else, null.
   */
  private $indexNameStartLine;

  /**
   * @var ?integer $indexNameStartColumn The column number on which the name of the index currently being parsed started, if any, else, null.
   */
  private $indexNameStartColumn;

  /**
   * @var ?integer $indexNameEndLine The line number on which the name of the index currently being parsed ended, if any, else, null.
   */
  private $indexNameEndLine;

  /**
   * @var ?integer $indexNameEndColumn The column number on which the name of the index currently being parsed ended, if any, else, null.
   */
  private $indexNameEndColumn;

  /**
   * @var boolean $indexUnique True when the index currently being parsed is unique, else, false.
   */
  private $indexUnique;

  /**
   * @var string $enumName The name of the enum currently being parsed.
   */
  private $enumName;

  /**
   * @var string $enumValueName The name of the enum value currently being parsed.
   */
  private $enumValueName;

  /**
   * @var array $tokenEvents The tokens currently being parsed.  This is used to raise an "unknown" event should their meaning be unclear.
   */
  private $tokenEvents = [];

  /**
   * @param ParserTarget $target Notified of all statements.
   */
  function __construct($target)
  {
    $this->target = $target;
  }

  /**
   * Handle the end of the file.
   *
   * @param integer $line The line number on which the file ended.
   * @param integer $column The column number on which the file ended.
   */
  public function endOfFile($line, $column)
  {
    if (! empty($this->tokenEvents)) {
      $indexOfPenultimateMeaningfulToken = count($this->tokenEvents) - 1;

      while (! TokenIs::meaningful($this->tokenEvents[$indexOfPenultimateMeaningfulToken]->type)) {
        $indexOfPenultimateMeaningfulToken--;
      }

      $this->target->unknown(array_slice($this->tokenEvents, 0, $indexOfPenultimateMeaningfulToken + 1));
    }

    $this->target->endOfFile($this->state === ParserState::BETWEEN_STATEMENTS);
  }

  /**
   * Transitions to the specified state.
   * Emits an unknown event if there are multiple meaningful tokens in the tokenEvents array and removes all but the last from it.
   * @param ParserState $state The state to transition to.
   */
  private function transitionTo($state)
  {
    if (count($this->tokenEvents) > 1) {
      $indexOfPenultimateMeaningfulToken = count($this->tokenEvents) - 2;

      while (! TokenIs::meaningful($this->tokenEvents[$indexOfPenultimateMeaningfulToken]->type)) {
        $indexOfPenultimateMeaningfulToken--;
      }

      $this->target->unknown(array_slice($this->tokenEvents, 0, $indexOfPenultimateMeaningfulToken + 1));
    }

    $this->tokenEvents = [];
    $this->state = $state;
  }

  /**
   * Handle a token.
   *
   * @param integer $type The type of the token (see TokenType::*).
   * @param integer $startLine The line number on which the token started.
   * @param integer $startColumn The column number on which the token started.
   * @param integer $endLine The line number on which the token ended.
   * @param integer $endColumn The column number on which the token ended.
   * @param string $content The content of the token.
   * @param string $raw The exact sequence of characters which were interpreted as this token.
   */
  public function token($type, $startLine, $startColumn, $endLine, $endColumn, $content, $raw)
  {
    $tokenIsMeaningful = TokenIs::meaningful($type);

    if ($tokenIsMeaningful || ! empty($this->tokenEvents)) {
      $this->tokenEvents []= new TokenEvent($type, $startLine, $startColumn, $endLine, $endColumn, $content, $raw);
    }

    if ($tokenIsMeaningful) {
      switch ($this->state) {
        case ParserState::BETWEEN_STATEMENTS:
          if (TokenIs::table($type, $content)) {
            $this->transitionTo(ParserState::TABLE);
          } else if (TokenIs::ref($type, $content)) {
            $this->transitionTo(ParserState::REF);
          } else if (TokenIs::enum($type, $content)) {
            $this->transitionTo(ParserState::ENUM);
          }
          break;

        case ParserState::TABLE:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->table($content, $startLine, $startColumn, $endLine, $endColumn);
            $this->tableName = $content;
            $this->tableNameStartLine = $startLine;
            $this->tableNameStartColumn = $startColumn;
            $this->tableNameEndLine = $endLine;
            $this->tableNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::TABLE_NAMED);
          }
          break;

        case ParserState::TABLE_NAMED:
          if (TokenIs::isAs($type, $content)) {
            $this->transitionTo(ParserState::TABLE_AS);
          } else if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::TABLE_BODY);
          }
          break;

        case ParserState::TABLE_AS:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->tableAlias($this->tableName, $content, $startLine, $startColumn, $endLine, $endColumn);
            $this->transitionTo(ParserState::TABLE_ALIASED);
          }
          break;

        case ParserState::TABLE_ALIASED:
          if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::TABLE_BODY);
          }
          break;

        case ParserState::TABLE_BODY:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          } else if (TokenIs::indexes($type, $content)) {
            $this->transitionTo(ParserState::INDEXES);
          } else if (TokenIs::note($type, $content)) {
            $this->transitionTo(ParserState::TABLE_NOTE);
          } else if (TokenIs::anIdentifier($type, $content)) {
            $this->columnName = $content;
            $this->columnNameStartLine = $startLine;
            $this->columnNameStartColumn = $startColumn;
            $this->columnNameEndLine = $endLine;
            $this->columnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_NAMED);
          }
          break;

        case ParserState::COLUMN_NAMED:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->columnType = $content;
            $this->transitionTo(ParserState::COLUMN_TYPED);
          }
          break;

        case ParserState::COLUMN_TYPED:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->target->column($this->tableName, $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn, $this->columnType, null);
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          } else if (TokenIs::anOpeningParenthesis($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_BEFORE_SIZE);
          } else if (TokenIs::anOpeningBracket($type, $content)) {
            $this->target->column($this->tableName, $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn, $this->columnType, null);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          } else if (TokenIs::anIdentifier($type, $content)) {
            $this->target->column($this->tableName, $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn, $this->columnType, null);
            $this->columnName = $content;
            $this->columnNameStartLine = $startLine;
            $this->columnNameStartColumn = $startColumn;
            $this->columnNameEndLine = $endLine;
            $this->columnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_NAMED);
          }
          break;

        case ParserState::COLUMN_BEFORE_SIZE:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->columnSize = $content;
            $this->transitionTo(ParserState::COLUMN_SIZED);
          }
          break;

        case ParserState::COLUMN_SIZED:
          if (TokenIs::aClosingParenthesis($type, $content)) {
            $this->target->column($this->tableName, $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn, $this->columnType, $this->columnSize);
            $this->transitionTo(ParserState::COLUMN_AFTER_SIZE);
          }
          break;

        case ParserState::COLUMN_AFTER_SIZE:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          } else if (TokenIs::anOpeningBracket($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          } else if (TokenIs::anIdentifier($type, $content)) {
            $this->columnName = $content;
            $this->columnNameStartLine = $startLine;
            $this->columnNameStartColumn = $startColumn;
            $this->columnNameEndLine = $endLine;
            $this->columnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_NAMED);
          }
          break;

        case ParserState::COLUMN_AFTER_COMMA:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::primaryKey($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_AFTER_PRIMARY_KEY);
          } else if (TokenIs::increment($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_AFTER_INCREMENT);
          } else if (TokenIs::defaultKeyword($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_DEFAULT);
          } else if (TokenIs::not($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_NOT);
          } else if (TokenIs::note($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_NOTE);
          } else if (TokenIs::ref($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_REF);
          } else if (TokenIs::unique($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_AFTER_UNIQUE);
          }
          break;

        case ParserState::COLUMN_AFTER_PRIMARY_KEY:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnPrimaryKey($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnPrimaryKey($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_AFTER_INCREMENT:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnIncrement($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnIncrement($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_DEFAULT:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_DEFAULT_SEMICOLON);
          }
          break;

        case ParserState::COLUMN_DEFAULT_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->content = $content;
            $this->contentStartLine = $startLine;
            $this->contentStartColumn = $startColumn;
            $this->contentEndLine = $endLine;
            $this->contentEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_AFTER_CONSTANT_DEFAULT);
          } else if (TokenIs::aBacktickStringLiteral($type)) {
            $this->content = $content;
            $this->contentStartLine = $startLine;
            $this->contentStartColumn = $startColumn;
            $this->contentEndLine = $endLine;
            $this->contentEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_AFTER_CALCULATED_DEFAULT);
          }
          break;

        case ParserState::COLUMN_AFTER_CONSTANT_DEFAULT:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnConstantDefault($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnConstantDefault($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_AFTER_CALCULATED_DEFAULT:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnCalculatedDefault($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnCalculatedDefault($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_NOT:
          if (TokenIs::null($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_AFTER_NOT_NULL);
          }
          break;

        case ParserState::COLUMN_AFTER_NOT_NULL:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnNotNull($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnNotNull($this->tableName, $this->columnName);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_NOTE:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_NOTE_SEMICOLON);
          }
          break;

        case ParserState::COLUMN_NOTE_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->content = $content;
            $this->contentStartLine = $startLine;
            $this->contentStartColumn = $startColumn;
            $this->contentEndLine = $endLine;
            $this->contentEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_AFTER_NOTE);
          }
          break;

        case ParserState::COLUMN_AFTER_NOTE:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->columnNote($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->columnNote($this->tableName, $this->columnName, $this->content, $this->contentStartLine, $this->contentStartColumn, $this->contentEndLine, $this->contentEndColumn);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_REF:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_REF_SEMICOLON);
          }
          break;

        case ParserState::COLUMN_REF_SEMICOLON:
          if (TokenIs::aLessThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_MANY;
            $this->transitionTo(ParserState::COLUMN_REF_OPERATOR);
          } else if (TokenIs::aHyphen($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_ONE;
            $this->transitionTo(ParserState::COLUMN_REF_OPERATOR);
          } else if (TokenIs::aGreaterThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::MANY_TO_ONE;
            $this->transitionTo(ParserState::COLUMN_REF_OPERATOR);
          }
          break;

        case ParserState::COLUMN_REF_OPERATOR:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencedTableNameOrAlias = $content;
            $this->referencedTableNameOrAliasStartLine = $startLine;
            $this->referencedTableNameOrAliasStartColumn = $startColumn;
            $this->referencedTableNameOrAliasEndLine = $endLine;
            $this->referencedTableNameOrAliasEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_REF_REFERENCED_TABLE_NAME_OR_ALIAS);
          }
          break;

        case ParserState::COLUMN_REF_REFERENCED_TABLE_NAME_OR_ALIAS:
          if (TokenIs::aPeriod($type, $content)) {
            $this->transitionTo(ParserState::COLUMN_REF_PERIOD);
          }
          break;

        case ParserState::COLUMN_REF_PERIOD:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencedColumnName = $content;
            $this->referencedColumnNameStartLine = $startLine;
            $this->referencedColumnNameStartColumn = $startColumn;
            $this->referencedColumnNameEndLine = $endLine;
            $this->referencedColumnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::COLUMN_AFTER_REF);
          }
          break;

        case ParserState::COLUMN_AFTER_REF:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->ref(
              $this->tableName, $this->tableNameStartLine, $this->tableNameStartColumn, $this->tableNameEndLine, $this->tableNameEndColumn,
              $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn,
              $this->refOperator,
              $this->referencedTableNameOrAlias, $this->referencedTableNameOrAliasStartLine, $this->referencedTableNameOrAliasStartColumn, $this->referencedTableNameOrAliasEndLine, $this->referencedTableNameOrAliasEndColumn,
              $this->referencedColumnName, $this->referencedColumnNameStartLine, $this->referencedColumnNameStartColumn, $this->referencedColumnNameEndLine, $this->referencedColumnNameEndColumn
            );
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->ref(
              $this->tableName, $this->tableNameStartLine, $this->tableNameStartColumn, $this->tableNameEndLine, $this->tableNameEndColumn,
              $this->columnName, $this->columnNameStartLine, $this->columnNameStartColumn, $this->columnNameEndLine, $this->columnNameEndColumn,
              $this->refOperator,
              $this->referencedTableNameOrAlias, $this->referencedTableNameOrAliasStartLine, $this->referencedTableNameOrAliasStartColumn, $this->referencedTableNameOrAliasEndLine, $this->referencedTableNameOrAliasEndColumn,
              $this->referencedColumnName, $this->referencedColumnNameStartLine, $this->referencedColumnNameStartColumn, $this->referencedColumnNameEndLine, $this->referencedColumnNameEndColumn
            );
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::COLUMN_AFTER_UNIQUE:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->index($this->tableName, [['name' => $this->columnName, 'nameStartLine' => $this->columnNameStartLine, 'nameStartColumn' => $this->columnNameStartColumn, 'nameEndLine' => $this->columnNameEndLine, 'nameEndColumn' => $this->columnNameEndColumn]], null, null, null, null, null, true);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::aComma($type, $content)) {
            $this->target->index($this->tableName, [['name' => $this->columnName, 'nameStartLine' => $this->columnNameStartLine, 'nameStartColumn' => $this->columnNameStartColumn, 'nameEndLine' => $this->columnNameEndLine, 'nameEndColumn' => $this->columnNameEndColumn]], null, null, null, null, null, true);
            $this->transitionTo(ParserState::COLUMN_AFTER_COMMA);
          }
          break;

        case ParserState::INDEXES:
          if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::INDEXES_BODY);
          }
          break;

        case ParserState::INDEXES_BODY:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::anOpeningParenthesis($type, $content)) {
            $this->indexColumns = [];

            $this->indexName = null;
            $this->indexNameStartLine = null;
            $this->indexNameStartColumn = null;
            $this->indexNameEndLine = null;
            $this->indexNameEndColumn = null;

            $this->indexUnique = false;

            $this->transitionTo(ParserState::INDEX_OPENING_PARENTHESIS);
          } else if (TokenIs::anIdentifier($type, $content)) {
            $this->indexColumns = [
              [
                'name' => $content,
                'nameStartLine' => $startLine,
                'nameStartColumn' => $startColumn,
                'nameEndLine' => $endLine,
                'nameEndColumn' => $endColumn,
              ],
            ];

            $this->indexName = null;
            $this->indexNameStartLine = null;
            $this->indexNameStartColumn = null;
            $this->indexNameEndLine = null;
            $this->indexNameEndColumn = null;

            $this->indexUnique = false;

            $this->transitionTo(ParserState::INDEX_COLUMNS);
          }
          break;

        case ParserState::INDEX_OPENING_PARENTHESIS:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->indexColumns []= [
              'name' => $content,
              'nameStartLine' => $startLine,
              'nameStartColumn' => $startColumn,
              'nameEndLine' => $endLine,
              'nameEndColumn' => $endColumn,
            ];
            $this->transitionTo(ParserState::INDEX_MULTIPLE_NAME);
          }
          break;

        case ParserState::INDEX_MULTIPLE_NAME:
          if (TokenIs::aComma($type, $content)) {
            $this->transitionTo(ParserState::INDEX_OPENING_PARENTHESIS);
          } else if (TokenIs::aClosingParenthesis($type, $content)) {
            $this->transitionTo(ParserState::INDEX_COLUMNS);
          }
          break;

        case ParserState::INDEX_COLUMNS:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->index($this->tableName, $this->indexColumns, $this->indexName, $this->indexNameStartLine, $this->indexNameStartColumn, $this->indexNameEndLine, $this->indexNameEndColumn, $this->indexUnique);

            $this->indexColumns = [
              [
                'name' => $content,
                'nameStartLine' => $startLine,
                'nameStartColumn' => $startColumn,
                'nameEndLine' => $endLine,
                'nameEndColumn' => $endColumn,
              ],
            ];

            $this->indexName = null;
            $this->indexNameStartLine = null;
            $this->indexNameStartColumn = null;
            $this->indexNameEndLine = null;
            $this->indexNameEndColumn = null;

            $this->indexUnique = false;

            $this->transitionTo(ParserState::INDEX_COLUMNS);
          } else if (TokenIs::anOpeningBracket($type, $content)) {
            $this->transitionTo(ParserState::INDEX_AFTER_COMMA);
          } else if (TokenIs::aClosingBrace($type, $content)) {
            $this->target->index($this->tableName, $this->indexColumns, $this->indexName, $this->indexNameStartLine, $this->indexNameStartColumn, $this->indexNameEndLine, $this->indexNameEndColumn, $this->indexUnique);
            $this->transitionTo(ParserState::TABLE_BODY);
          } else if (TokenIs::anOpeningParenthesis($type, $content)) {
            $this->target->index($this->tableName, $this->indexColumns, $this->indexName, $this->indexNameStartLine, $this->indexNameStartColumn, $this->indexNameEndLine, $this->indexNameEndColumn, $this->indexUnique);

            $this->indexColumns = [];

            $this->indexName = null;
            $this->indexNameStartLine = null;
            $this->indexNameStartColumn = null;
            $this->indexNameEndLine = null;
            $this->indexNameEndColumn = null;

            $this->indexUnique = false;

            $this->transitionTo(ParserState::INDEX_OPENING_PARENTHESIS);
          }
          break;

        case ParserState::INDEX_AFTER_COMMA:
          if (TokenIs::name($type, $content)) {
            $this->transitionTo(ParserState::INDEX_NAME);
          } else if (TokenIs::unique($type, $content)) {
            $this->transitionTo(ParserState::INDEX_AFTER_UNIQUE);
          }
          break;

        case ParserState::INDEX_NAME:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::INDEX_NAME_SEMICOLON);
          }
          break;

        case ParserState::INDEX_NAME_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->indexName = $content;
            $this->indexNameStartLine = $startLine;
            $this->indexNameStartColumn = $startColumn;
            $this->indexNameEndLine = $endLine;
            $this->indexNameEndColumn = $endColumn;

            $this->transitionTo(ParserState::INDEX_AFTER_NAME);
          }
          break;

        case ParserState::INDEX_AFTER_NAME:
          if (TokenIs::aComma($type, $content)) {
            $this->transitionTo(ParserState::INDEX_AFTER_COMMA);
          } else if (TokenIs::aClosingBracket($type, $content)) {
            $this->target->index($this->tableName, $this->indexColumns, $this->indexName, $this->indexNameStartLine, $this->indexNameStartColumn, $this->indexNameEndLine, $this->indexNameEndColumn, $this->indexUnique);
            $this->transitionTo(ParserState::INDEXES_BODY);
          }
          break;

        case ParserState::INDEX_AFTER_UNIQUE:
          if (TokenIs::aComma($type, $content)) {
            $this->indexUnique = true;
            $this->transitionTo(ParserState::INDEX_AFTER_COMMA);
          } else if (TokenIs::aClosingBracket($type, $content)) {
            $this->indexUnique = true;
            $this->target->index($this->tableName, $this->indexColumns, $this->indexName, $this->indexNameStartLine, $this->indexNameStartColumn, $this->indexNameEndLine, $this->indexNameEndColumn, $this->indexUnique);
            $this->transitionTo(ParserState::INDEXES_BODY);
          }
          break;

        case ParserState::TABLE_NOTE:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::TABLE_NOTE_SEMICOLON);
          } else if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::TABLE_NOTE_OPENING_BRACE);
          }
          break;

        case ParserState::TABLE_NOTE_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->tableNote($this->tableName, $content, $startLine, $startColumn, $endLine, $endColumn);
            $this->transitionTo(ParserState::TABLE_BODY);
          }
          break;

        case ParserState::REF:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::REF_SEMICOLON);
          } else if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::BRACED_REF);
          }
          break;

        case ParserState::REF_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencingTableNameOrAlias = $content;
            $this->referencingTableNameOrAliasStartLine = $startLine;
            $this->referencingTableNameOrAliasStartColumn = $startColumn;
            $this->referencingTableNameOrAliasEndLine = $endLine;
            $this->referencingTableNameOrAliasEndColumn = $endColumn;
            $this->transitionTo(ParserState::REF_REFERENCING_TABLE_NAME_OR_ALIAS);
          }
          break;

        case ParserState::REF_REFERENCING_TABLE_NAME_OR_ALIAS:
          if (TokenIs::aPeriod($type, $content)) {
            $this->transitionTo(ParserState::REF_REFERENCING_PERIOD);
          }
          break;

        case ParserState::REF_REFERENCING_PERIOD:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencingColumnName = $content;
            $this->referencingColumnNameStartLine = $startLine;
            $this->referencingColumnNameStartColumn = $startColumn;
            $this->referencingColumnNameEndLine = $endLine;
            $this->referencingColumnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::REF_REFERENCING_COLUMN_NAME);
          }
          break;

        case ParserState::REF_REFERENCING_COLUMN_NAME:
          if (TokenIs::aLessThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_MANY;
            $this->transitionTo(ParserState::REF_OPERATOR);
          } else if (TokenIs::aHyphen($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_ONE;
            $this->transitionTo(ParserState::REF_OPERATOR);
          } else if (TokenIs::aGreaterThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::MANY_TO_ONE;
            $this->transitionTo(ParserState::REF_OPERATOR);
          }
          break;

        case ParserState::REF_OPERATOR:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencedTableNameOrAlias = $content;
            $this->referencedTableNameOrAliasStartLine = $startLine;
            $this->referencedTableNameOrAliasStartColumn = $startColumn;
            $this->referencedTableNameOrAliasEndLine = $endLine;
            $this->referencedTableNameOrAliasEndColumn = $endColumn;
            $this->transitionTo(ParserState::REF_REFERENCED_TABLE_NAME_OR_ALIAS);
          }
          break;

        case ParserState::REF_REFERENCED_TABLE_NAME_OR_ALIAS:
          if (TokenIs::aPeriod($type, $content)) {
            $this->transitionTo(ParserState::REF_REFERENCED_PERIOD);
          }
          break;

        case ParserState::REF_REFERENCED_PERIOD:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->ref(
              $this->referencingTableNameOrAlias, $this->referencingTableNameOrAliasStartLine, $this->referencingTableNameOrAliasStartColumn, $this->referencingTableNameOrAliasEndLine, $this->referencingTableNameOrAliasEndColumn,
              $this->referencingColumnName, $this->referencingColumnNameStartLine, $this->referencingColumnNameStartColumn, $this->referencingColumnNameEndLine, $this->referencingColumnNameEndColumn,
              $this->refOperator,
              $this->referencedTableNameOrAlias, $this->referencedTableNameOrAliasStartLine, $this->referencedTableNameOrAliasStartColumn, $this->referencedTableNameOrAliasEndLine, $this->referencedTableNameOrAliasEndColumn,
              $content, $startLine, $startColumn, $endLine, $endColumn
            );

            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          }
          break;

        case ParserState::ENUM:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->enumName = $content;

            $this->target->enum($content, $startLine, $startColumn, $endLine, $endColumn);

            $this->transitionTo(ParserState::ENUM_NAME);
          }
          break;

        case ParserState::ENUM_NAME:
          if (TokenIs::anOpeningBrace($type, $content)) {
            $this->transitionTo(ParserState::ENUM_BODY);
          }
          break;

        case ParserState::ENUM_BODY:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->enumValueName = $content;

            $this->target->enumValue($this->enumName, $content, $startLine, $startColumn, $endLine, $endColumn);

            $this->transitionTo(ParserState::ENUM_VALUE_NAME);
          } else if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          }
          break;

        case ParserState::ENUM_VALUE_NAME:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->enumValueName = $content;

            $this->target->enumValue($this->enumName, $content, $startLine, $startColumn, $endLine, $endColumn);

            $this->transitionTo(ParserState::ENUM_VALUE_NAME);
          } else if (TokenIs::anOpeningBracket($type, $content)) {
            $this->transitionTo(ParserState::ENUM_VALUE_OPENING_BRACKET);
          } else if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          }
          break;

        case ParserState::ENUM_VALUE_OPENING_BRACKET:
          if (TokenIs::note($type, $content)) {
            $this->transitionTo(ParserState::ENUM_VALUE_NOTE);
          }
          break;

        case ParserState::ENUM_VALUE_NOTE:
          if (TokenIs::aSemicolon($type, $content)) {
            $this->transitionTo(ParserState::ENUM_VALUE_NOTE_SEMICOLON);
          }
          break;

        case ParserState::ENUM_VALUE_NOTE_SEMICOLON:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->enumValueNote($this->enumName, $this->enumValueName, $content, $startLine, $startColumn, $endLine, $endColumn);
            $this->transitionTo(ParserState::ENUM_VALUE_NOTE_CONTENT);
          }
          break;

        case ParserState::ENUM_VALUE_NOTE_CONTENT:
          if (TokenIs::aClosingBracket($type, $content)) {
            $this->transitionTo(ParserState::ENUM_BODY);
          }
          break;

        case ParserState::TABLE_NOTE_OPENING_BRACE:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->tableNote($this->tableName, $content, $startLine, $startColumn, $endLine, $endColumn);

            $this->transitionTo(ParserState::TABLE_NOTE_BRACED_CONTENT);
          }
          break;

        case ParserState::TABLE_NOTE_BRACED_CONTENT:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::TABLE_BODY);
          }
          break;

        case ParserState::BRACED_REF:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencingTableNameOrAlias = $content;
            $this->referencingTableNameOrAliasStartLine = $startLine;
            $this->referencingTableNameOrAliasStartColumn = $startColumn;
            $this->referencingTableNameOrAliasEndLine = $endLine;
            $this->referencingTableNameOrAliasEndColumn = $endColumn;
            $this->transitionTo(ParserState::BRACED_REF_REFERENCING_TABLE_NAME_OR_ALIAS);
          }
          break;

        case ParserState::BRACED_REF_REFERENCING_TABLE_NAME_OR_ALIAS:
          if (TokenIs::aPeriod($type, $content)) {
            $this->transitionTo(ParserState::BRACED_REF_REFERENCING_PERIOD);
          }
          break;

        case ParserState::BRACED_REF_REFERENCING_PERIOD:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencingColumnName = $content;
            $this->referencingColumnNameStartLine = $startLine;
            $this->referencingColumnNameStartColumn = $startColumn;
            $this->referencingColumnNameEndLine = $endLine;
            $this->referencingColumnNameEndColumn = $endColumn;
            $this->transitionTo(ParserState::BRACED_REF_REFERENCING_COLUMN_NAME);
          }
          break;

        case ParserState::BRACED_REF_REFERENCING_COLUMN_NAME:
          if (TokenIs::aLessThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_MANY;
            $this->transitionTo(ParserState::BRACED_REF_OPERATOR);
          } else if (TokenIs::aHyphen($type, $content)) {
            $this->refOperator = RefOperator::ONE_TO_ONE;
            $this->transitionTo(ParserState::BRACED_REF_OPERATOR);
          } else if (TokenIs::aGreaterThanSymbol($type, $content)) {
            $this->refOperator = RefOperator::MANY_TO_ONE;
            $this->transitionTo(ParserState::BRACED_REF_OPERATOR);
          }
          break;

        case ParserState::BRACED_REF_OPERATOR:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->referencedTableNameOrAlias = $content;
            $this->referencedTableNameOrAliasStartLine = $startLine;
            $this->referencedTableNameOrAliasStartColumn = $startColumn;
            $this->referencedTableNameOrAliasEndLine = $endLine;
            $this->referencedTableNameOrAliasEndColumn = $endColumn;
            $this->transitionTo(ParserState::BRACED_REF_REFERENCED_TABLE_NAME_OR_ALIAS);
          }
          break;

        case ParserState::BRACED_REF_REFERENCED_TABLE_NAME_OR_ALIAS:
          if (TokenIs::aPeriod($type, $content)) {
            $this->transitionTo(ParserState::BRACED_REF_REFERENCED_PERIOD);
          }
          break;

        case ParserState::BRACED_REF_REFERENCED_PERIOD:
          if (TokenIs::anIdentifier($type, $content)) {
            $this->target->ref(
              $this->referencingTableNameOrAlias, $this->referencingTableNameOrAliasStartLine, $this->referencingTableNameOrAliasStartColumn, $this->referencingTableNameOrAliasEndLine, $this->referencingTableNameOrAliasEndColumn,
              $this->referencingColumnName, $this->referencingColumnNameStartLine, $this->referencingColumnNameStartColumn, $this->referencingColumnNameEndLine, $this->referencingColumnNameEndColumn,
              $this->refOperator,
              $this->referencedTableNameOrAlias, $this->referencedTableNameOrAliasStartLine, $this->referencedTableNameOrAliasStartColumn, $this->referencedTableNameOrAliasEndLine, $this->referencedTableNameOrAliasEndColumn,
              $content, $startLine, $startColumn, $endLine, $endColumn
            );

            $this->transitionTo(ParserState::BRACED_REF_REFERENCED_COLUMN_NAME);
          }
          break;

        case ParserState::BRACED_REF_REFERENCED_COLUMN_NAME:
          if (TokenIs::aClosingBrace($type, $content)) {
            $this->transitionTo(ParserState::BETWEEN_STATEMENTS);
          }
          break;
      }
    }
  }
}
