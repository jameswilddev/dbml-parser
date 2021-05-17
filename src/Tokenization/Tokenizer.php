<?php

namespace JamesWildDev\DBMLParser\Tokenization;

use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\TokenizerState;

/**
 * Identifies tokens in a stream of characters.
 */
class Tokenizer
{
  /**
   * @var TokenizerTarget $target Notified of all tokenization events.
   */
  private $target;

  /**
   * @var integer $line The current line number.
   */
  private $line = 1;

  /**
   * @var integer $column The current column number.
   */
  private $column = 1;

  /**
   * @var integer $line The previous line number.
   */
  private $previousLine = 1;

  /**
   * @var integer $column The previous column number.
   */
  private $previousColumn = 1;

  /**
   * @var integer $startLine The line number on which the current sequence of characters started.
   */
  private $startLine;

  /**
   * @var integer $startColumn The column number on which the current sequence of characters started.
   */
  private $startColumn;

  /**
   * @var string $contentString The characters currently aggregated (as a string).
   */
  private $contentString;

  /**
   * @var array $contentArray The characters currently aggregated (as an array).
   */
  private $contentArray;

  /**
   * @var boolean $encounteredNonWhiteSpace True when non-white-space characters have been encountered on the current line, else, false.
   */
  private $encounteredNonWhiteSpace = false;

  /**
   * @var string $raw The raw characters currently being aggregated (includes white space, delimiters, etc.).
   */
  private $raw = '';

  /**
   * @var integer $state The current state (see STATE_*).
   */
  private $state = TokenizerState::BETWEEN_TOKENS;

  /**
   * @var boolean $followingCarriageReturn Tracks whether the previous character was a carriage return to prevent double line counting on CR LF.
   */
  private $followingCarriageReturn = false;

  /**
   * @param TokenizerTarget $target Notified of all tokenization events.
   */
  function __construct($target)
  {
    $this->target = $target;
  }

  /**
   * Determines whether a character is a carriage return.
   * @param $character The character to check.
   * @return bool True when the character is a carriage return, otherwise, false.
   */
  private function characterIsCarriageReturn($character)
  {
    return $character === "\r";
  }

  /**
   * Determines whether a character is a line feed.
   * @param $character The character to check.
   * @return bool True when the character is a line feed, otherwise, false.
   */
  private function characterIsLineFeed($character)
  {
    return $character === "\n";
  }

  /**
   * Determines whether a character is any kind of new line.
   * @param $character The character to check.
   * @return bool True when the character is a newline, otherwise, false.
   */
  private function characterIsNewLine($character)
  {
    return preg_match('/^\v$/', $character);
  }

  /**
   * Determines whether a character constitutes white space.
   * @param $character The character to check.
   * @return bool True when the character constitutes white space, otherwise, false.
   */
  private function characterIsWhiteSpace($character)
  {
    return preg_match('/^\s$/', $character);
  }

  /**
   * Determines whether a character is any kind of symbol.
   * @param $character The character to check.
   * @return bool True when the character is a symbol, otherwise, false.
   */
  private function characterIsSymbol($character)
  {
    switch ($character) {
      case '[':
      case ']':
      case '(':
      case ')':
      case '{':
      case '}':
      case ':':
      case '<':
      case '>':
      case '-':
      case ',':
        return true;

      default:
        return false;
    }
  }

  /**
   * Determines whether a character is a single quote.
   * @param $character The character to check.
   * @return bool True when the character is a single quote, otherwise, false.
   */
  private function characterIsSingleQuote($character)
  {
    return $character === '\'';
  }

  /**
   * Determines whether a character is a double quote.
   * @param $character The character to check.
   * @return bool True when the character is a double quote, otherwise, false.
   */
  private function characterIsDoubleQuote($character)
  {
    return $character === '"';
  }

  /**
   * Determines whether a character is a forward slash.
   * @param $character The character to check.
   * @return bool True when the character is a forward slash, otherwise, false.
   */
  private function characterIsForwardSlash($character)
  {
    return $character === '/';
  }

  /**
   * Determines whether a character is a backslash.
   * @param $character The character to check.
   * @return bool True when the character is a backslash, otherwise, false.
   */
  private function characterIsBackslash($character)
  {
    return $character === '\\';
  }

  /**
   * Determines whether a character is a backtick.
   * @param $character The character to check.
   * @return bool True when the character is a backtick, otherwise, false.
   */
  private function characterIsBacktick($character)
  {
    return $character === '`';
  }

  /**
   * Removes all blank lines from the start of an array of characters.
   * @param array $characters The array of characters to remove the leading blank lines from.
   * @return array The input array of characters, with all leading blank lines removed.
   */
  private function removeLeadingBlankLines($characters)
  {
    for ($i = 0; $i < count($characters); $i++) {
      $character = $characters[$i];
      if ($this->characterIsNewLine($character)) {
        return $this->removeLeadingBlankLines(array_slice($characters, $i + 1));
      } else if (! $this->characterIsWhiteSpace($character)) {
        return $characters;
      }
    }

    return [];
  }

  /**
   * Removes all blank lines from the end of an array of characters.
   * @param array $characters The array of characters to remove the trailing blank lines from.
   * @return array The input array of characters, with all trailing blank lines removed.
   */
  private function removeTrailingBlankLines($characters)
  {
    for ($i = count($characters) - 1; $i >= 0; $i--) {
      $character = $characters[$i];
      if ($this->characterIsNewLine($character)) {
        return $this->removeTrailingBlankLines(array_slice($characters, 0, $i));
      } else if (! $this->characterIsWhiteSpace($character)) {
        return $characters;
      }
    }

    return [];
  }

  /**
   * Calculates the least indentation in an array of characters.
   * @param array $characters The array of characters to calculate the least indentation of.
   * @return integer The least indentation of the input array of characters.
   */
  private function calculateLeastIndentation($characters)
  {
    $output = null;
    $indentation = 0;
    $foundNonWhiteSpace = false;

    foreach ($characters as $character) {
      if ($this->characterIsNewLine($character)) {
        if ($foundNonWhiteSpace) {
          if ($output === null) {
            $output = $indentation;
          } else {
            $output = min($indentation, $output);
          }
        }

        $indentation = 0;
        $foundNonWhiteSpace = false;
      } else if (! $foundNonWhiteSpace) {
        if ($this->characterIsWhiteSpace($character)) {
          $indentation++;
        } else {
          $foundNonWhiteSpace = true;
        }
      }
    }

    if ($output === null) {
      return $indentation;
    } else {
      return min($indentation, $output);
    }
  }

  /**
   * Removes a specified number of characters from each line of an array of characters.
   * @param array $characters The array of characters to remove characters from.
   * @param integer $numberOfCharactersToRemove The number of characters to remove from the start of each line.
   * @return array The input array of characters, with the specified number of characters removed from the start of each line.
   */
  private function removeIndentation($characters, $numberOfCharactersToRemove)
  {
    $numberOfCharactersStillToRemoveOnThisLine = $numberOfCharactersToRemove;
    $output = [];

    foreach ($characters as $character) {
      if ($this->characterIsNewLine($character)) {
        $numberOfCharactersStillToRemoveOnThisLine = $numberOfCharactersToRemove;
        $output []= $character;
      } else if ($numberOfCharactersStillToRemoveOnThisLine > 0) {
        $numberOfCharactersStillToRemoveOnThisLine--;
      } else {
        $output []= $character;
      }
    }

    return $output;
  }

  /**
   * Determines whether an array of characters is entirely white space.
   * @param array $characters The array of characters to remove the trailing blank lines from.
   * @return boolean True when the input array of characters is all white space, otherwise false.
   */
  private function entirelyWhiteSpace($characters)
  {
    foreach ($characters as $character) {
      if (! $this->characterIsWhiteSpace($character)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Update internal state and raise events as appropriate.
   * @param $character The next character.
   */
  private function advanceParserState($character)
  {
    switch ($this->state) {
      case TokenizerState::BETWEEN_TOKENS:
        if ($this->characterIsWhiteSpace($character)) {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->contentString = $character;
          $this->state = TokenizerState::WHITE_SPACE;
        } else if ($this->characterIsSymbol($character)) {
          $this->target->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, $this->line, $this->column, $this->line, $this->column, $character, $character);
        } else if ($this->characterIsSingleQuote($character)) {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->state = TokenizerState::FIRST_SINGLE_QUOTE;
        } else if ($this->characterIsForwardSlash($character)) {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->state = TokenizerState::FIRST_FORWARD_SLASH;
        } else if ($this->characterIsDoubleQuote($character)) {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->contentString = '';
          $this->state = TokenizerState::DOUBLE_QUOTED_STRING;
        } else if ($this->characterIsBacktick($character)) {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->contentString = '';
          $this->state = TokenizerState::BACKTICK_STRING;
        } else {
          $this->startLine = $this->line;
          $this->startColumn = $this->column;
          $this->contentString = $character;
          $this->state = TokenizerState::TOKEN;
        }

        $this->raw = $character;
        break;

      case TokenizerState::WHITE_SPACE:
        if ($this->characterIsWhiteSpace($character)) {
          $this->contentString .= $character;
        } else {
          $this->target->token(TokenType::WHITE_SPACE, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, substr($this->raw, 0, -1));
          $this->state = TokenizerState::BETWEEN_TOKENS;
          $this->advanceParserState($character);
        }
        break;

      case TokenizerState::TOKEN:
        if ($this->characterIsWhiteSpace($character) || $this->characterIsSymbol($character) || $this->characterIsSingleQuote($character) || $this->characterIsForwardSlash($character) || $this->characterIsDoubleQuote($character) || $this->characterIsBacktick($character)) {
          $this->target->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, substr($this->raw, 0, -1));
          $this->state = TokenizerState::BETWEEN_TOKENS;
          $this->advanceParserState($character);
        } else {
          $this->contentString .= $character;
        }
        break;

      case TokenizerState::FIRST_SINGLE_QUOTE:
        if ($this->characterIsSingleQuote($character)) {
          $this->state = TokenizerState::SECOND_SINGLE_QUOTE;
        } else {
          $this->state = TokenizerState::SINGLE_QUOTED_STRING;
          $this->contentString = '';
          $this->advanceParserState($character);
        }
        break;

      case TokenizerState::SECOND_SINGLE_QUOTE:
        if ($this->characterIsSingleQuote($character)) {
          $this->contentArray = [];
          $this->indentation = 0;
          $this->leastIndentation = null;
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        } else {
          $this->target->token(TokenType::STRING_LITERAL, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, '', substr($this->raw, 0, -1));
          $this->state = TokenizerState::BETWEEN_TOKENS;
          $this->advanceParserState($character);
        }
        break;

      case TokenizerState::SINGLE_QUOTED_STRING:
        if ($this->characterIsSingleQuote($character)) {
          $this->target->token(TokenType::STRING_LITERAL, $this->startLine, $this->startColumn, $this->line, $this->column, $this->contentString, $this->raw);
          $this->state = TokenizerState::BETWEEN_TOKENS;
        } else if ($this->characterIsBackslash($character)) {
          $this->state = TokenizerState::SINGLE_QUOTED_STRING_BACKSLASH;
        } else {
          $this->contentString .= $character;
        }
        break;

      case TokenizerState::SINGLE_QUOTED_STRING_BACKSLASH:
        if (!$this->characterIsSingleQuote($character)) {
          $this->contentString .= '\\';
        }

        $this->contentString .= $character;

        $this->state = TokenizerState::SINGLE_QUOTED_STRING;
        break;

      case TokenizerState::DOUBLE_QUOTED_STRING:
        if ($this->characterIsBackslash($character)) {
          $this->state = TokenizerState::DOUBLE_QUOTED_STRING_BACKSLASH;
        } else if ($this->characterIsDoubleQuote($character)) {
          $this->target->token(TokenType::STRING_LITERAL, $this->startLine, $this->startColumn, $this->line, $this->column, $this->contentString, $this->raw);
          $this->state = TokenizerState::BETWEEN_TOKENS;
        } else {
          $this->contentString .= $character;
        }
        break;

      case TokenizerState::DOUBLE_QUOTED_STRING_BACKSLASH:
        if (! $this->characterIsDoubleQuote($character)) {
          $this->contentString .= '\\';
        }

        $this->contentString .= $character;
        $this->state = TokenizerState::DOUBLE_QUOTED_STRING;
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING:
        if ($this->characterIsSingleQuote($character)) {
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING_FIRST_SINGLE_QUOTE;
        } else if ($this->characterIsBackslash($character)) {
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH;
        } else {
          $this->contentArray []= $character;
        }
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH:
        if ($this->characterIsCarriageReturn($character)) {
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH_CARRIAGE_RETURN;
        } else if ($this->characterIsNewLine($character)) {
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        } else {
          $this->contentArray []= $character;
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        }
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH_CARRIAGE_RETURN:
        if (! $this->characterIsLineFeed($character)) {
          $this->contentArray []= $character;
        }

        $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_FIRST_SINGLE_QUOTE:
        if ($this->characterIsSingleQuote($character)) {
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING_SECOND_SINGLE_QUOTE;
        } else {
          $this->contentArray []= '\'';
          $this->contentArray []= $character;
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        }
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_SECOND_SINGLE_QUOTE:
        if ($this->characterIsSingleQuote($character)) {
          $contentArray = $this->contentArray;
          $contentArray = $this->removeLeadingBlankLines($contentArray);
          $contentArray = $this->removeTrailingBlankLines($contentArray);
          $leastIndentation = $this->calculateLeastIndentation($contentArray);
          $contentArray = $this->removeIndentation($contentArray, $leastIndentation);
          if ($this->entirelyWhiteSpace($contentArray)) {
            $contentString = '';
          } else {
            $contentString = implode('', $contentArray);
          }
          $this->target->token(TokenType::STRING_LITERAL, $this->startLine, $this->startColumn, $this->line, $this->column, $contentString, $this->raw);
          $this->state = TokenizerState::BETWEEN_TOKENS;
        } else {
          $this->contentArray []= '\'\'';
          $this->contentArray []= $character;
          $this->state = TokenizerState::TRIPLE_QUOTED_STRING;
        }
        break;

      case TokenizerState::BACKTICK_STRING:
        if ($this->characterIsBacktick($character)) {
          $this->target->token(TokenType::BACKTICK_STRING_LITERAL, $this->startLine, $this->startColumn, $this->line, $this->column, $this->contentString, $this->raw);
          $this->state = TokenizerState::BETWEEN_TOKENS;
        } else {
          $this->contentString .= $character;
        }
        break;

      case TokenizerState::FIRST_FORWARD_SLASH:
        if ($this->characterIsForwardSlash($character)) {
          $this->contentString = '';
          $this->state = TokenizerState::LINE_COMMENT;
        } else {
          $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->startLine, $this->startColumn, '/', substr($this->raw, 0, -1));
          $this->state = TokenizerState::BETWEEN_TOKENS;
          $this->advanceParserState($character);
        }
        break;

      case TokenizerState::LINE_COMMENT:
        if ($this->characterIsNewLine($character)) {
          $this->target->token(TokenType::LINE_COMMENT, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, substr($this->raw, 0, -1));
          $this->state = TokenizerState::BETWEEN_TOKENS;
          $this->advanceParserState($character);
        } else {
          $this->contentString .= $character;
        }
        break;
    }
  }

  /**
   * Increment line/column counters as appropriate.
   * @param $character The next character.
   */
  private function advanceFilePosition($character)
  {
    // Track the line/column before advancing line position as if the next character ends the token we need to know which character was the last within that token.
    if (! $this->followingCarriageReturn || ! $this->characterIsNewLine($character)) {
      $this->previousLine = $this->line;
      $this->previousColumn = $this->column;
    }

    // Carriage returns need to be handled differently to normal newline characters as CR LF should count as one newline not two.
    if ($this->characterIsCarriageReturn($character)) {
      $this->line++;
      $this->column = 1;
      $this->followingCarriageReturn = true;
    } else {
      if ($this->characterIsLineFeed($character) && $this->followingCarriageReturn) {
        // Do nothing.
      } else if ($this->characterIsNewLine($character)) {
        $this->line++;
        $this->column = 1;
      } else {
        $this->column++;
      }
      $this->followingCarriageReturn = false;
    }
  }

  /**
   * Notify the tokenizer of a character.
   * @param string $character The next character.
   */
  public function character($character)
  {
    $this->raw .= $character;

    $this->advanceParserState($character);
    $this->advanceFilePosition($character);
  }

  /**
   * Notify the tokenizer of the end of the file.
   */
  public function endOfFile()
  {
    switch ($this->state) {
      case TokenizerState::BETWEEN_TOKENS:
        break;

      case TokenizerState::WHITE_SPACE:
        $this->target->token(TokenType::WHITE_SPACE, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, $this->raw);
        break;

      case TokenizerState::TOKEN:
        $this->target->token(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, $this->raw);
        break;

      case TokenizerState::FIRST_SINGLE_QUOTE:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::SECOND_SINGLE_QUOTE:
        $this->target->token(TokenType::STRING_LITERAL, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, '', $this->raw);
        break;

      case TokenizerState::SINGLE_QUOTED_STRING:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::SINGLE_QUOTED_STRING_BACKSLASH:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::DOUBLE_QUOTED_STRING:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::DOUBLE_QUOTED_STRING_BACKSLASH:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_BACKSLASH_CARRIAGE_RETURN:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_FIRST_SINGLE_QUOTE:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::TRIPLE_QUOTED_STRING_SECOND_SINGLE_QUOTE:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::BACKTICK_STRING:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::FIRST_FORWARD_SLASH:
        $this->target->token(TokenType::UNKNOWN, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->raw, $this->raw);
        break;

      case TokenizerState::LINE_COMMENT:
        $this->target->token(TokenType::LINE_COMMENT, $this->startLine, $this->startColumn, $this->previousLine, $this->previousColumn, $this->contentString, $this->raw);
        break;
    }

    $this->target->endOfFile($this->line, $this->column);
  }
}
