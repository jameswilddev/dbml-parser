<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Parsing\Logging\RefEvent;
use PHPUnit\Framework\TestCase;

final class RefEventTest extends TestCase
{
  public function test()
  {
    $refEvent = new RefEvent(
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

    $this->assertEquals('Test First Table Name Or Alias', $refEvent->firstTableNameOrAlias);
    $this->assertEquals(24, $refEvent->firstTableNameOrAliasStartLine);
    $this->assertEquals(84, $refEvent->firstTableNameOrAliasStartColumn);
    $this->assertEquals(37, $refEvent->firstTableNameOrAliasEndLine);
    $this->assertEquals(11, $refEvent->firstTableNameOrAliasEndColumn);
    $this->assertEquals('Test First Column Name', $refEvent->firstColumnName);
    $this->assertEquals(101, $refEvent->firstColumnNameStartLine);
    $this->assertEquals(88, $refEvent->firstColumnNameStartColumn);
    $this->assertEquals(54, $refEvent->firstColumnNameEndLine);
    $this->assertEquals(21, $refEvent->firstColumnNameEndColumn);
    $this->assertEquals('Test Second Table Name Or Alias', $refEvent->secondTableNameOrAlias);
    $this->assertEquals(22, $refEvent->secondTableNameOrAliasStartLine);
    $this->assertEquals(46, $refEvent->secondTableNameOrAliasStartColumn);
    $this->assertEquals(73, $refEvent->secondTableNameOrAliasEndLine);
    $this->assertEquals(47, $refEvent->secondTableNameOrAliasEndColumn);
    $this->assertEquals('Test Second Column Name', $refEvent->secondColumnName);
    $this->assertEquals(12, $refEvent->secondColumnNameStartLine);
    $this->assertEquals(54, $refEvent->secondColumnNameStartColumn);
    $this->assertEquals(33, $refEvent->secondColumnNameEndLine);
    $this->assertEquals(72, $refEvent->secondColumnNameEndColumn);
  }
}
