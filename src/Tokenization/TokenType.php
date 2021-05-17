<?php

namespace JamesWildDev\DBMLParser\Tokenization;

/**
 * Values which identify the types of tokens.
 */
class TokenType
{
  /**
   * The token is a sequence of characters without any kind of delimiter.
   */
  const KEYWORD_SYMBOL_OR_IDENTIFIER = 0;

  /**
   * The token is a string literal (non-backtick-delimited).
   */
  const STRING_LITERAL = 1;

  /**
   * The token is a backtick-delimited string literal.
   */
  const BACKTICK_STRING_LITERAL = 2;

  /**
   * The token is a sequence of white space characters.
   */
  const WHITE_SPACE = 3;

  /**
   * The token is a line comment.
   */
  const LINE_COMMENT = 4;

  /**
   * The token is an unknown sequence of characters.
   */
  const UNKNOWN = 5;
}
