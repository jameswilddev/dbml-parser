<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ColumnPrimaryKeyEvent;
use PHPUnit\Framework\TestCase;

final class ColumnPrimaryKeyEventTest extends TestCase
{
  public function test()
  {
    $columnPrimaryKeyEvent = new ColumnPrimaryKeyEvent(
      'Test Table Name',
      'Test Column Name'
    );

    $this->assertEquals('Test Table Name', $columnPrimaryKeyEvent->tableName);
    $this->assertEquals('Test Column Name', $columnPrimaryKeyEvent->columnName);
  }
}
