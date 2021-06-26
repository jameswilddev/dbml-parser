<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of the end of the file.
 */
final class EndOfFileEvent
{
  /**
   * @var bool $expected True when the end-of-file was expected, otherwise, false.
   */
  public $expected;

  /**
   * @param bool $expected True when the end-of-file was expected, otherwise, false.
   */
  function __construct($expected)
  {
    $this->expected = $expected;
  }
}
