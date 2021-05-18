<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnNotNullEvent;
use PHPUnit\Framework\TestCase;

final class ColumnNotNullEventTest extends TestCase
{
  public function test()
  {
    $columnNotNullEvent = new ColumnNotNullEvent(
      'Test Table Name',
      'Test Column Name'
    );

    $this->assertEquals('Test Table Name', $columnNotNullEvent->tableName);
    $this->assertEquals('Test Column Name', $columnNotNullEvent->columnName);
  }
}
