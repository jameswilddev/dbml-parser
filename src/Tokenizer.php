<?php

namespace JamesWildDev\DBMLParser;

/**
 * Finds tokens in a sequence of characters.
 */
final class Tokenizer
{
  /**
   * @var TokenizerTarget $target The handler of the tokens found.
   */
  private $target;

  /**
   * @var integer $line The number of the current line.
   */
  private $line = 1;

  /**
   * @var integer $column The number of the current column.
   */
  private $column = 1;

  /**
   * No token is in progress.
   */
  const STATE_BETWEEN_TOKENS = 0;

  /**
   * We've just received a carriage return.  This is identical to STATE_BETWEEN_TOKENS, except that an immediately following line feed will be effectively ignored.
   */
  const STATE_CARRIAGE_RETURN = 1;

  /**
   * We are at least one character into a word.
   */
  const STATE_WORD = 2;

  /**
   * A single quote has been encountered.
   * We need to wait for the next character or the end of the file to know whether it is a single line quote, a multiline quote, or something invalid.
   */
  const STATE_ONE_SINGLE_QUOTE = 3;

  /**
   * The state as of the latest character.
   */
  private $state = self::STATE_BETWEEN_TOKENS;

  /**
   * The codepoint for \n, LF, etc.
   */
  const CODEPOINT_LINE_FEED = 0x000A;

  /**
   * The codepoint for \n, LF, etc.
   */
  const CODEPOINT_CARRIAGE_RETURN = 0x000D;

  /**
   * The codepoint for '.
   */
  const CODEPOINT_SINGLE_QUOTE = 0x0027;

  /**
   * The codepoint for a space (" ").
   */
  const CODEPOINT_SPACE = 0x2002;

  /**
   * The codepoint for a tab (\t).
   */
  const CODEPOINT_TAB = 0x0009;

  /**
   * The codepoint for an opening brace ({).
   */
  const CODEPOINT_OPENING_BRACE = 0x007B;

  /**
   * The codepoint for a closing brace (}).
   */
  const CODEPOINT_CLOSING_BRACE = 0x007D;

  /**
   * The codepoint for an opening bracket ([]).
   */
  const CODEPOINT_OPENING_BRACKET = 0x005B;

  /**
   * The codepoint for a closing bracket (]).
   */
  const CODEPOINT_CLOSING_BRACKET = 0x005D;

  /**
   * The codepoint for a closing semicolon (;).
   */
  const CODEPOINT_SEMICOLON = 0x003B;

  /**
   * The codepoint for a greater than symbol (>).
   */
  const CODEPOINT_GREATER_THAN = 0x003E;

  /**
   * The codepoint for a less than symbol (>).
   */
  const CODEPOINT_LESS_THAN = 0x003C;

  /**
   * The codepoint for a hyphen (-).
   */
  const CODEPOINT_HYPHEN = 0x00AD;

  /**
   * The codepoint for a forward slash (/).
   */
  const CODEPOINT_FORWARD_SLASH = 0x002F;

  /**
   * The codepoint for an underscore (_).
   */
  const CODEPOINT_UNDERSCORE = 0x005F;

  /**
   * The codepoint for a zero digit.
   */
  const CODEPOINT_ZERO = 0x0030;

  /**
   * The codepoint for a nine digit.
   */
  const CODEPOINT_NINE = 0x0039;

  /**
   * The codepoint for an upper case letter A.
   */
  const CODEPOINT_UPPER_CASE_A = 0x0041;

  /**
   * The codepoint for an upper case letter Z.
   */
  const CODEPOINT_UPPER_CASE_Z = 0x005A;

  /**
   * The codepoint for a lower case letter A.
   */
  const CODEPOINT_LOWER_CASE_A = 0x0061;

  /**
   * The codepoint for a lower case letter Z.
   */
  const CODEPOINT_LOWER_CASE_Z = 0x007A;

  /**
   * @param TokenizerTarget $target The handler of the tokens found.
   */
  function __construct($target)
  {
    $this->target = $target;
  }

  /**
   * Notify the tokenizer of the next character in the file.
   * @param integer $codepoint The codepoint of the next character.
   */
  public function character($codepoint)
  {
    switch ($this->state) {
      case self::STATE_BETWEEN_TOKENS:
        switch ($codepoint) {
          case self::CODEPOINT_LINE_FEED:
            $this->line++;
            $this->column = 1;
            break;
          case self::CODEPOINT_CARRIAGE_RETURN:
            $this->line++;
            $this->column = 1;
            $this->state = self::STATE_CARRIAGE_RETURN;
            break;
          case self::CODEPOINT_SINGLE_QUOTE:
            $this->column++;
            $this->state = self::STATE_ONE_SINGLE_QUOTE;
            break;
          case self::CODEPOINT_SPACE:
          case self::CODEPOINT_TAB:
            $this->column++;
            break;
          case self::CODEPOINT_OPENING_BRACE:
            $this->target->openingBrace($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_CLOSING_BRACE:
            $this->target->closingBrace($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_OPENING_BRACKET:
            $this->target->openingBrace($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_CLOSING_BRACKET:
            $this->target->closingBrace($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_SEMICOLON:
            $this->target->semicolon($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_GREATER_THAN:
            $this->target->greaterThan($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_LESS_THAN:
            $this->target->greaterThan($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_HYPHEN:
            $this->target->hyphen($this->line, $this->column);
            $this->column++;
            break;
          case self::CODEPOINT_FORWARD_SLASH:
            $this->column++;
            $this->state = self::STATE_ONE_FORWARD_SLASH;
            break;
          case self::CODEPOINT_UNDERSCORE:
            $this->content = chr($codepoint);
            $this->startColumn = $this->column;
            $this->column++;
            $this->state = self::STATE_WORD;
            break;
          default:
            if (
              ($codepoint >= self::CODEPOINT_ZERO && $codepoint <= self::CODEPOINT_NINE)
              || ($codepoint >= self::CODEPOINT_UPPER_CASE_A && $codepoint <= self::CODEPOINT_UPPER_CASE_Z)
              || ($codepoint >= self::CODEPOINT_LOWER_CASE_A && $codepoint <= self::CODEPOINT_LOWER_CASE_Z)
            ) {
              $this->content = chr($codepoint);
              $this->startColumn = $this->column;
              $this->column++;
              $this->state = self::STATE_WORD;
            } else {
              $this->target->unexpectedCharacter($this->line, $this->column, $codepoint);
              $this->column++;
            }
            break;
        }
        break;

        case self::STATE_CARRIAGE_RETURN:
          switch ($codepoint) {
            case self::CODEPOINT_LINE_FEED:
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CARRIAGE_RETURN:
              $this->line++;
              $this->column = 1;
              $this->state = self::STATE_CARRIAGE_RETURN;
              break;
            case self::CODEPOINT_SINGLE_QUOTE:
              $this->column++;
              $this->state = self::STATE_ONE_SINGLE_QUOTE;
              break;
            case self::CODEPOINT_SPACE:
            case self::CODEPOINT_TAB:
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_OPENING_BRACE:
              $this->target->openingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CLOSING_BRACE:
              $this->target->closingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_OPENING_BRACKET:
              $this->target->openingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CLOSING_BRACKET:
              $this->target->closingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_SEMICOLON:
              $this->target->semicolon($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_GREATER_THAN:
              $this->target->greaterThan($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_LESS_THAN:
              $this->target->greaterThan($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_HYPHEN:
              $this->target->hyphen($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_FORWARD_SLASH:
              $this->target->unexpectedCharacter($this->line, $this->column, $codepoint);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_UNDERSCORE:
              $this->content = chr($codepoint);
              $this->startColumn = $this->column;
              $this->column++;
              $this->state = self::STATE_WORD;
              break;
            default:
              if (
                ($codepoint >= self::CODEPOINT_ZERO && $codepoint <= self::CODEPOINT_NINE)
                || ($codepoint >= self::CODEPOINT_UPPER_CASE_A && $codepoint <= self::CODEPOINT_UPPER_CASE_Z)
                || ($codepoint >= self::CODEPOINT_LOWER_CASE_A && $codepoint <= self::CODEPOINT_LOWER_CASE_Z)
              ) {
                $this->content = chr($codepoint);
                $this->startColumn = $this->column;
                $this->column++;
                $this->state = self::STATE_WORD;
              } else {
                $this->target->unexpectedCharacter($this->line, $this->column, $codepoint);
                $this->column++;
              }
              break;
          }
          break;

        case self::STATE_WORD:
          switch ($codepoint) {
            case self::CODEPOINT_LINE_FEED:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->line++;
              $this->column = 1;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CARRIAGE_RETURN:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->line++;
              $this->column = 1;
              $this->state = self::STATE_CARRIAGE_RETURN;
              break;
            case self::CODEPOINT_SINGLE_QUOTE:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->column++;
              $this->state = self::STATE_ONE_SINGLE_QUOTE;
              break;
            case self::CODEPOINT_SPACE:
            case self::CODEPOINT_TAB:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_OPENING_BRACE:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->openingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CLOSING_BRACE:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->closingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_OPENING_BRACKET:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->openingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CLOSING_BRACKET:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->closingBrace($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_SEMICOLON:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->semicolon($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_GREATER_THAN:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->greaterThan($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_LESS_THAN:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->greaterThan($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_HYPHEN:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->hyphen($this->line, $this->column);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_FORWARD_SLASH:
              $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
              $this->target->unexpectedCharacter($this->line, $this->column, $codepoint);
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_UNDERSCORE:
              $this->content .= chr($codepoint);
              $this->column++;
              break;
            default:
              if (
                ($codepoint >= self::CODEPOINT_ZERO && $codepoint <= self::CODEPOINT_NINE)
                || ($codepoint >= self::CODEPOINT_UPPER_CASE_A && $codepoint <= self::CODEPOINT_UPPER_CASE_Z)
                || ($codepoint >= self::CODEPOINT_LOWER_CASE_A && $codepoint <= self::CODEPOINT_LOWER_CASE_Z)
              ) {
                $this->content .= chr($codepoint);
                $this->column++;
              } else {
                $this->target->unexpectedCharacter($this->line, $this->column, $codepoint);
                $this->column++;
              }
              break;
          }
          break;

        case self::STATE_ONE_SINGLE_QUOTE:
          switch ($codepoint) {
            case self::CODEPOINT_LINE_FEED:
              $this->target->unexpectedCharacter($this->line, $this->column);
              $this->line++;
              $this->column = 1;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            case self::CODEPOINT_CARRIAGE_RETURN:
              $this->target->unexpectedCharacter($this->line, $this->column);
              $this->line++;
              $this->column = 1;
              $this->state = self::STATE_CARRIAGE_RETURN;
              break;
            case self::CODEPOINT_SINGLE_QUOTE:
              $this->target->stringLiteral($this->line, $this->startColumn, '');
              $this->column++;
              $this->state = self::STATE_BETWEEN_TOKENS;
              break;
            // todo backslash?
            default:
              $this->content = str($codepoint);
              $this->column++;
              $this->state = self::STATE_STRING_LITERAL;
          }
          break;
    }
  }

  /**
   * Notify the tokenizer of the end of the file.
   */
  public function endOfFile()
  {
    switch ($this->state) {
        case self::STATE_WORD:
          $this->target->word($this->line, $this->startColumn, $this->column - 1, $this->content);
          break;

        case self::STATE_ONE_SINGLE_QUOTE:
          $this->target->unexpectedEndOfFile($this->line, $this->column);
          break;
    }

    $this->target->endOfFile($this->line, $this->column);
  }
}
