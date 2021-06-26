<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\EndOfFileEvent;
use PHPUnit\Framework\TestCase;

final class EndOfFileEventTest extends TestCase
{
  public function test_false()
  {
    $tableEvent = new EndOfFileEvent(false);

    $this->assertFalse($tableEvent->expected);
  }

  public function test_true()
  {
    $tableEvent = new EndOfFileEvent(true);

    $this->assertTrue($tableEvent->expected);
  }
}
