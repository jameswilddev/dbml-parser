<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing\Logging;

use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnCalculatedDefaultEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnConstantDefaultEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnIncrementEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnNoteEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnNotNullEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\ColumnPrimaryKeyEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\EndOfFileEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\EnumEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\EnumValueEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\EnumValueNoteEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\RefEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\IndexEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\LogParserTarget;
use JamesWildDev\DBMLParser\Parsing\Logging\TableAliasEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\TableEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\TableNoteEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\UnknownEvent;
use JamesWildDev\DBMLParser\Parsing\RefOperator;
use PHPUnit\Framework\TestCase;

final class LogParserTargetTest extends TestCase
{
  public function test_initially_empty()
  {
    $logParserTarget = new LogParserTarget();

    $this->assertEmpty($logParserTarget->events);
  }

  public function test_logs_all_events()
  {
    $logParserTarget = new LogParserTarget();

    $logParserTarget->columnNote(
      'Test Column Note Table Name',
      'Test Column Note Column Name',
      'Test Column Note Content',
      77,
      42,
      932,
      21
    );
    $logParserTarget->columnPrimaryKey(
      'Test Column Primary Key Table Name',
      'Test Column Primary Key Column Name'
    );
    $logParserTarget->columnIncrement(
      'Test Column Increment Table Name',
      'Test Column Increment Column Name'
    );
    $logParserTarget->enum(
      'Test Enum Name',
      62,
      78,
      94,
      268
    );
    $logParserTarget->enumValue(
      'Test Enum Value Enum Name',
      'Test Enum Value Name',
      47,
      28,
      79,
      58
    );
    $logParserTarget->enumValueNote(
      'Test Enum Value Note Enum Name',
      'Test Enum Value Note Name',
      'Test Enum Value Note Content',
      72,
      52,
      95,
      52
    );
    $logParserTarget->columnNotNull(
      'Test Column Not Null Table Name',
      'Test Column Not Null Column Name'
    );
    $logParserTarget->endOfFile(true);
    $logParserTarget->columnConstantDefault(
      'Test Column Constant Default Table Name',
      'Test Column Constant Default Column Name',
      'Test Column Constant Default Content',
      883,
      21,
      45,
      78
    );
    $logParserTarget->endOfFile(false);
    $logParserTarget->columnCalculatedDefault(
      'Test Column Calculated Default Event Table Name',
      'Test Column Calculated Default Event Column Name',
      'Test Column Calculated Default Event Content',
      222,
      48,
      52,
      10
    );
    $logParserTarget->ref(
      'Test Ref First Table Name Or Alias',
      883,
      632,
      644,
      512,
      'Test Ref First Column Name',
      38,
      92,
      25,
      70,
      RefOperator::ONE_TO_ONE,
      'Test Ref Second Table Name Or Alias',
      104,
      160,
      80,
      98,
      'Test Ref Second Column Name',
      401,
      5022,
      46,
      70
    );
    $logParserTarget->index(
      'Test Index Table Name',
      [
        [
          'name' => 'Test Index Column A Name',
          'nameStartLine' => 72,
          'nameStartColumn' => 14,
          'nameEndLine' => 64,
          'nameEndColumn' => 55,
        ],
        [
          'name' => 'Test Index Column B Name',
          'nameStartLine' => 26,
          'nameStartColumn' => 85,
          'nameEndLine' => 71,
          'nameEndColumn' => 22,
        ],
        [
          'name' => 'Test Index Column C Name',
          'nameStartLine' => 46,
          'nameStartColumn' => 58,
          'nameEndLine' => 99,
          'nameEndColumn' => 86,
        ],
      ],
      'Test Index Name',
      653,
      232,
      396,
      942,
      true
    );
    $logParserTarget->table(
      'Test Table Name',
      38,
      95,
      46,
      55
    );
    $logParserTarget->tableAlias(
      'Test Table Alias Table Name',
      'Test Table Alias Name',
      31,
      26,
      11,
      87
    );
    $logParserTarget->tableNote(
      'Test Table Note Table Name',
      'Test Table Note Content',
      65,
      82,
      44,
      12
    );
    $logParserTarget->column(
      'Test Column Table Name',
      'Test Column Name',
      48,
      99,
      105,
      75,
      'Test Column Type',
      'Test Column Size'
    );
    $logParserTarget->unknown(
      [
        new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
        new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
        new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
      ]
    );

    $this->assertEquals([
      new ColumnNoteEvent(
        'Test Column Note Table Name',
        'Test Column Note Column Name',
        'Test Column Note Content',
        77,
        42,
        932,
        21
      ),
      new ColumnPrimaryKeyEvent(
        'Test Column Primary Key Table Name',
        'Test Column Primary Key Column Name'
      ),
      new ColumnIncrementEvent(
        'Test Column Increment Table Name',
        'Test Column Increment Column Name'
      ),
      new EnumEvent(
        'Test Enum Name',
        62,
        78,
        94,
        268
      ),
      new EnumValueEvent(
        'Test Enum Value Enum Name',
        'Test Enum Value Name',
        47,
        28,
        79,
        58
      ),
      new EnumValueNoteEvent(
        'Test Enum Value Note Enum Name',
        'Test Enum Value Note Name',
        'Test Enum Value Note Content',
        72,
        52,
        95,
        52
      ),
      new ColumnNotNullEvent(
        'Test Column Not Null Table Name',
        'Test Column Not Null Column Name'
      ),
      new EndOfFileEvent(true),
      new ColumnConstantDefaultEvent(
        'Test Column Constant Default Table Name',
        'Test Column Constant Default Column Name',
        'Test Column Constant Default Content',
        883,
        21,
        45,
        78
      ),
      new EndOfFileEvent(false),
      new ColumnCalculatedDefaultEvent(
        'Test Column Calculated Default Event Table Name',
        'Test Column Calculated Default Event Column Name',
        'Test Column Calculated Default Event Content',
        222,
        48,
        52,
        10
      ),
      new RefEvent(
        'Test Ref First Table Name Or Alias',
        883,
        632,
        644,
        512,
        'Test Ref First Column Name',
        38,
        92,
        25,
        70,
        RefOperator::ONE_TO_ONE,
        'Test Ref Second Table Name Or Alias',
        104,
        160,
        80,
        98,
        'Test Ref Second Column Name',
        401,
        5022,
        46,
        70
      ),
      new IndexEvent(
        'Test Index Table Name',
        [
          [
            'name' => 'Test Index Column A Name',
            'nameStartLine' => 72,
            'nameStartColumn' => 14,
            'nameEndLine' => 64,
            'nameEndColumn' => 55,
          ],
          [
            'name' => 'Test Index Column B Name',
            'nameStartLine' => 26,
            'nameStartColumn' => 85,
            'nameEndLine' => 71,
            'nameEndColumn' => 22,
          ],
          [
            'name' => 'Test Index Column C Name',
            'nameStartLine' => 46,
            'nameStartColumn' => 58,
            'nameEndLine' => 99,
            'nameEndColumn' => 86,
          ],
        ],
        'Test Index Name',
        653,
        232,
        396,
        942,
        true
      ),
      new TableEvent(
        'Test Table Name',
        38,
        95,
        46,
        55
      ),
      new TableAliasEvent(
        'Test Table Alias Table Name',
        'Test Table Alias Name',
        31,
        26,
        11,
        87
      ),
      new TableNoteEvent(
        'Test Table Note Table Name',
        'Test Table Note Content',
        65,
        82,
        44,
        12
      ),
      new ColumnEvent(
        'Test Column Table Name',
        'Test Column Name',
        48,
        99,
        105,
        75,
        'Test Column Type',
        'Test Column Size'
      ),
      new UnknownEvent(
        [
          new TokenEvent(TokenType::UNKNOWN, 20, 63, 99, 65, 'Test Unknown Content', 'Test Unknown Raw'),
          new TokenEvent(TokenType::WHITE_SPACE, 44, 23, 72, 11, 'Test White Space Content', 'Test White Space Raw'),
          new TokenEvent(TokenType::STRING_LITERAL, 22, 40, 88, 35, 'Test String Literal Content', 'Test String Literal Raw'),
        ]
      ),
    ], $logParserTarget->events);
  }
}
