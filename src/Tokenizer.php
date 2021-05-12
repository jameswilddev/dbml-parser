<?php

namespace JamesWildDev\DBMLParser;

final class Tokenizer
{
  private TokenizerTarget $target;

  function __construct(TokenizerTarget $target)
  {
    $this->target = $target;
  }

  public function tokenize(int $codepoint): void
  {

  }

  public function endOfFile(): void
  {

  }
}
