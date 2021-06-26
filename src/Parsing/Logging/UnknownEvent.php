<?php

namespace JamesWildDev\DBMLParser\Parsing\Logging;

/**
 * A record of an unknown sequence of tokens.
 */
final class UnknownEvent
{
  /**
   * @var array $tokenEvents The tokens found.
   */
  public $tokenEvents;

  /**
   * @param array $tokenEvents The tokens found.
   */
  function __construct($tokenEvents)
  {
    $this->tokenEvents = $tokenEvents;
  }
}
