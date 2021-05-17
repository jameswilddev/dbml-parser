<?php

namespace JamesWildDev\DBMLParser\Tokenization;

/**
 * Values which identify the states of tokenizers.
 */
class TokenizerState
{
  /**
   * No characters are currently being aggregated.
   */
  const BETWEEN_TOKENS = 0;

  /**
   * One or more white space characters are currently being aggregated.
   */
  const WHITE_SPACE = 1;

  /**
   * One or more token characters are currently being aggregated.
   */
  const TOKEN = 2;

  /**
   * One single quote has been encountered.  This could be the start of a string literal, a multiline string literal or an unknown sequence of characters.
   */
  const FIRST_SINGLE_QUOTE = 3;

  /**
   * Two single quotes have been encountered.  This could be an empty string literal, a multiline string literal or an unknown sequence of characters.
   */
  const SECOND_SINGLE_QUOTE = 4;

  /**
   * A single-line string is being aggregated.
   */
  const SINGLE_QUOTED_STRING = 5;

  /**
   * A single-line string is being aggregated.  The previous character was a backslash.
   */
  const SINGLE_QUOTED_STRING_BACKSLASH = 6;

  /**
   * A double-quoted string is being aggregated.
   */
  const DOUBLE_QUOTED_STRING = 7;

  /**
   * A double-quoted string is being aggregated; a backslash has been encountered.
   */
  const DOUBLE_QUOTED_STRING_BACKSLASH = 8;

  /**
   * A triple-quoted string is being aggregated.  No non-white-space characters have been found yet.
   */
  const TRIPLE_QUOTED_STRING = 9;

  /**
   * A triple-quoted string is being aggregated; a backslash has been encountered.
   */
  const TRIPLE_QUOTED_STRING_BACKSLASH = 10;

  /**
   * A triple-quoted string is being aggregated; a backslash and a carriage return have been encountered.
   */
  const TRIPLE_QUOTED_STRING_BACKSLASH_CARRIAGE_RETURN = 11;

  /**
   * A triple-quoted string is being aggregated; a single quote has been encountered.
   */
  const TRIPLE_QUOTED_STRING_FIRST_SINGLE_QUOTE = 12;

  /**
   * A triple-quoted string is being aggregated; two single quotes have been encountered.
   */
  const TRIPLE_QUOTED_STRING_SECOND_SINGLE_QUOTE = 13;

  /**
   * A single-line string is being aggregated.
   */
  const BACKTICK_STRING = 14;

  /**
   * A forward slash has been found; if the next character is also a forward slash, this is a line comment.  It is otherwise an error.
   */
  const FIRST_FORWARD_SLASH = 15;

  /**
   * A line comment is being aggregated.
   */
  const LINE_COMMENT = 16;
}
