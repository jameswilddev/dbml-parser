<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ForeignKeyConstraintEvent;
use PHPUnit\Framework\TestCase;

final class ForeignKeyConstraintEventTest extends TestCase
{
  public function test()
  {
    $foreignKeyConstraintEvent = new ForeignKeyConstraintEvent(
      'Test First Table Name Or Alias',
      24,
      84,
      37,
      11,
      'Test First Column Name',
      101,
      88,
      54,
      21,
      'Test Second Table Name Or Alias',
      22,
      46,
      73,
      47,
      'Test Second Column Name',
      12,
      54,
      33,
      72
    );

    $this->assertEquals('Test First Table Name Or Alias', $foreignKeyConstraintEvent->firstTableNameOrAlias);
    $this->assertEquals(24, $foreignKeyConstraintEvent->firstTableNameOrAliasStartLine);
    $this->assertEquals(84, $foreignKeyConstraintEvent->firstTableNameOrAliasStartColumn);
    $this->assertEquals(37, $foreignKeyConstraintEvent->firstTableNameOrAliasEndLine);
    $this->assertEquals(11, $foreignKeyConstraintEvent->firstTableNameOrAliasEndColumn);
    $this->assertEquals('Test First Column Name', $foreignKeyConstraintEvent->firstColumnName);
    $this->assertEquals(101, $foreignKeyConstraintEvent->firstColumnNameStartLine);
    $this->assertEquals(88, $foreignKeyConstraintEvent->firstColumnNameStartColumn);
    $this->assertEquals(54, $foreignKeyConstraintEvent->firstColumnNameEndLine);
    $this->assertEquals(21, $foreignKeyConstraintEvent->firstColumnNameEndColumn);
    $this->assertEquals('Test Second Table Name Or Alias', $foreignKeyConstraintEvent->secondTableNameOrAlias);
    $this->assertEquals(22, $foreignKeyConstraintEvent->secondTableNameOrAliasStartLine);
    $this->assertEquals(46, $foreignKeyConstraintEvent->secondTableNameOrAliasStartColumn);
    $this->assertEquals(73, $foreignKeyConstraintEvent->secondTableNameOrAliasEndLine);
    $this->assertEquals(47, $foreignKeyConstraintEvent->secondTableNameOrAliasEndColumn);
    $this->assertEquals('Test Second Column Name', $foreignKeyConstraintEvent->secondColumnName);
    $this->assertEquals(12, $foreignKeyConstraintEvent->secondColumnNameStartLine);
    $this->assertEquals(54, $foreignKeyConstraintEvent->secondColumnNameStartColumn);
    $this->assertEquals(33, $foreignKeyConstraintEvent->secondColumnNameEndLine);
    $this->assertEquals(72, $foreignKeyConstraintEvent->secondColumnNameEndColumn);
  }
}
