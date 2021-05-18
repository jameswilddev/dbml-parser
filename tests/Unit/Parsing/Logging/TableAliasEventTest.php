<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\TableAliasEvent;
use PHPUnit\Framework\TestCase;

final class TableAliasEventTest extends TestCase
{
  public function test()
  {
    $tableAliasEvent = new TableAliasEvent(
      'Test Table Name',
      'Test Name',
      12,
      31,
      64,
      17
    );

    $this->assertEquals('Test Table Name', $tableAliasEvent->tableName);
    $this->assertEquals('Test Name', $tableAliasEvent->name);
    $this->assertEquals(12, $tableAliasEvent->nameStartLine);
    $this->assertEquals(31, $tableAliasEvent->nameStartColumn);
    $this->assertEquals(64, $tableAliasEvent->nameEndLine);
    $this->assertEquals(17, $tableAliasEvent->nameEndColumn);
  }
}
