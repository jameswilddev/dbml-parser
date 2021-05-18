<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnIncrementEvent;
use PHPUnit\Framework\TestCase;

final class ColumnIncrementEventTest extends TestCase
{
  public function test()
  {
    $columnIncrementEvent = new ColumnIncrementEvent(
      'Test Table Name',
      'Test Column Name'
    );

    $this->assertEquals('Test Table Name', $columnIncrementEvent->tableName);
    $this->assertEquals('Test Column Name', $columnIncrementEvent->columnName);
  }
}
