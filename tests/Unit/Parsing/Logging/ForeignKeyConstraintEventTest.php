<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\ForeignKeyConstraintEvent;
use PHPUnit\Framework\TestCase;

final class ForeignKeyConstraintEventTest extends TestCase
{
  public function test()
  {
    $foreignKeyConstraintEvent = new ForeignKeyConstraintEvent(
      'Test Referencing Table Name Or Alias',
      24,
      84,
      37,
      11,
      'Test Referencing Column Name',
      101,
      88,
      54,
      21,
      'Test Referenced Table Name Or Alias',
      22,
      46,
      73,
      47,
      'Test Referenced Column Name',
      12,
      54,
      33,
      72
    );

    $this->assertEquals('Test Referencing Table Name Or Alias', $foreignKeyConstraintEvent->referencingTableNameOrAlias);
    $this->assertEquals(24, $foreignKeyConstraintEvent->referencingTableNameOrAliasStartLine);
    $this->assertEquals(84, $foreignKeyConstraintEvent->referencingTableNameOrAliasStartColumn);
    $this->assertEquals(37, $foreignKeyConstraintEvent->referencingTableNameOrAliasEndLine);
    $this->assertEquals(11, $foreignKeyConstraintEvent->referencingTableNameOrAliasEndColumn);
    $this->assertEquals('Test Referencing Column Name', $foreignKeyConstraintEvent->referencingColumnName);
    $this->assertEquals(101, $foreignKeyConstraintEvent->referencingColumnNameStartLine);
    $this->assertEquals(88, $foreignKeyConstraintEvent->referencingColumnNameStartColumn);
    $this->assertEquals(54, $foreignKeyConstraintEvent->referencingColumnNameEndLine);
    $this->assertEquals(21, $foreignKeyConstraintEvent->referencingColumnNameEndColumn);
    $this->assertEquals('Test Referenced Table Name Or Alias', $foreignKeyConstraintEvent->referencedTableNameOrAlias);
    $this->assertEquals(22, $foreignKeyConstraintEvent->referencedTableNameOrAliasStartLine);
    $this->assertEquals(46, $foreignKeyConstraintEvent->referencedTableNameOrAliasStartColumn);
    $this->assertEquals(73, $foreignKeyConstraintEvent->referencedTableNameOrAliasEndLine);
    $this->assertEquals(47, $foreignKeyConstraintEvent->referencedTableNameOrAliasEndColumn);
    $this->assertEquals('Test Referenced Column Name', $foreignKeyConstraintEvent->referencedColumnName);
    $this->assertEquals(12, $foreignKeyConstraintEvent->referencedColumnNameStartLine);
    $this->assertEquals(54, $foreignKeyConstraintEvent->referencedColumnNameStartColumn);
    $this->assertEquals(33, $foreignKeyConstraintEvent->referencedColumnNameEndLine);
    $this->assertEquals(72, $foreignKeyConstraintEvent->referencedColumnNameEndColumn);
  }
}
