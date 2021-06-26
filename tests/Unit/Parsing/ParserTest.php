<?php

namespace JamesWildDev\DBMLParser\Tests\Unit\Parsing;

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
use JamesWildDev\DBMLParser\Parsing\Logging\IndexEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\LogParserTarget;
use JamesWildDev\DBMLParser\Parsing\Logging\RefEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\TableAliasEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\TableEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\TableNoteEvent;
use JamesWildDev\DBMLParser\Parsing\Logging\UnknownEvent;
use JamesWildDev\DBMLParser\Parsing\Parser;
use JamesWildDev\DBMLParser\Parsing\RefOperator;
use JamesWildDev\DBMLParser\Tokenization\TokenType;
use JamesWildDev\DBMLParser\Tokenization\Tokenizer;
use JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent;;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
  public function test_empty_file()
  {
    $logParserTarget = new LogParserTarget();
    $parser = new Parser($logParserTarget);

    $parser->endOfFile(1, 1);

    $this->assertEquals([new EndOfFileEvent(true)], $logParserTarget->events);
  }

  public function test_non_empty_file()
  {
    $logParserTarget = new LogParserTarget();
    $parser = new Parser($logParserTarget);
    $tokenizer = new Tokenizer($parser);

    foreach (str_split("
      tABlE table_a_name as table_a_alias {
        column_a_name column_a_type
        column_b_name column_b_type(column_b_size)
        column_c_name column_c_type [pk]
        column_d_name column_d_type [increment]
        column_e_name column_e_type [default: 'column e default']
        column_f_name column_f_type [default: `column f default`]
        column_g_name column_g_type [not null] /
        column_h_name column_h_type [note: 'column h note']
        column_i_name column_i_type [ref: > column_i_ref_table.column_i_ref_column]
        column_j_name column_j_type [ref: < column_j_ref_table.column_j_ref_column] ]->
        column_k_name column_k_type [ref: - column_k_ref_table.column_k_ref_column]
        'column_l_name' column_l_type // Comments are ignored.
        column_m_name column_m_type [ref: > 'column_m_ref_table'.column_m_ref_column]
        column_n_name column_n_type [ref: > column_n_ref_table.'column_n_ref_column']
        column_o_name column_o_type [unique]
        column_p_name column_p_type [default: column_p_default]
        IndeXES {
          index_a_column_a
          (index_b_column_a)
          (index_c_column_a, index_c_column_b)
          (index_d_column_a, index_d_column_b, index_d_column_c)
          index_e_column_a [name: 'test index e name']
          index_f_column_a [unique]
          index_g_column_a [name: 'test index g name', unique]
          'index_h_column_a'
          ('index_i_column_a', 'index_i_column_b', 'index_i_column_c')
        }
        NoTE: 'table_a_note'
      }

      rEF: ref_a_table_a.ref_a_column_a > ref_a_table_b.ref_a_column_b
      REf: ref_b_table_a.ref_b_column_a < ref_b_table_b.ref_b_column_b
      ReF: ref_c_table_a.ref_c_column_a - ref_c_table_b.ref_c_column_b
      rEf: 'ref_d_table_a'.ref_d_column_a > ref_d_table_b.ref_d_column_b
      ref: ref_e_table_a.'ref_e_column_a' > ref_e_table_b.ref_e_column_b
      REF: ref_f_table_a.ref_f_column_a > 'ref_f_table_b'.ref_f_column_b
      ref: ref_g_table_a.ref_g_column_a > ref_g_table_b.'ref_g_column_b'

      eNuM enum_a_name {
        enum_a_value_a
        'enum_a_value_b'
        enum_a_value_c [note: 'enum_a_value_c_note']
      }

      ENum 'enum_b_name' {}

      TABle 'table_b_name' {}
      tabLE table_c_name as 'table_c_alias' {
        NoTE { 'table_c_note' }
      }

      rEF { ref_h_table_a.ref_h_column_a > ref_h_table_b.ref_h_column_b }
      REf { ref_i_table_a.ref_i_column_a < ref_i_table_b.ref_i_column_b }
      ReF { ref_j_table_a.ref_j_column_a - ref_j_table_b.ref_j_column_b }
      rEf { 'ref_k_table_a'.ref_k_column_a > ref_k_table_b.ref_k_column_b }
      ref { ref_l_table_a.'ref_l_column_a' > ref_l_table_b.ref_l_column_b }
      REF { ref_m_table_a.ref_m_column_a > 'ref_m_table_b'.ref_m_column_b }
      ref { ref_n_table_a.ref_n_column_a > ref_n_table_b.'ref_n_column_b' }

      unexpected

      table with_empty_column_attributes { name_of_column_with_empty_attributes type_of_column_with_empty_attributes [] }
      table with_all_attributes_in_one_column { name_of_column_with_all_attributes type_of_column_with_all_attributes [pk, increment, not null, note: 'example note', unique, default: 'example default', ref: > other_table_name.other_column_name, default: `other example default`, unique] }
      table which_tests_index_edge_cases {
        indexes {}
        indexes {(abc, def, ghi) [unique, name: 'example name']}
      }
      enum which_tests_edge_cases { example_value_name }
      table which_tests_column_edge_cases {
        example_column_name_a example_column_type_a(example_column_size_a) [note: example_column_note_a]
        example_column_name_b example_column_type_b
      }
      table which_tests_additional_column_edge_cases {
        example_column_name_a example_column_type_a(example_column_size_a)
      }
    ") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new TableEvent('table_a_name', 2, 13, 2, 24),
      new TableAliasEvent('table_a_name', 'table_a_alias', 2, 29, 2, 41),
      new ColumnEvent('table_a_name', 'column_a_name', 3, 9, 3, 21, 'column_a_type', null),
      new ColumnEvent('table_a_name', 'column_b_name', 4, 9, 4, 21, 'column_b_type', 'column_b_size'),
      new ColumnEvent('table_a_name', 'column_c_name', 5, 9, 5, 21, 'column_c_type', null),
      new ColumnPrimaryKeyEvent('table_a_name', 'column_c_name'),
      new ColumnEvent('table_a_name', 'column_d_name', 6, 9, 6, 21, 'column_d_type', null),
      new ColumnIncrementEvent('table_a_name', 'column_d_name'),
      new ColumnEvent('table_a_name', 'column_e_name', 7, 9, 7, 21, 'column_e_type', null),
      new ColumnConstantDefaultEvent('table_a_name', 'column_e_name', 'column e default', 7, 47, 7, 64),
      new ColumnEvent('table_a_name', 'column_f_name', 8, 9, 8, 21, 'column_f_type', null),
      new ColumnCalculatedDefaultEvent('table_a_name', 'column_f_name', 'column f default', 8, 47, 8, 64),
      new ColumnEvent('table_a_name', 'column_g_name', 9, 9, 9, 21, 'column_g_type', null),
      new ColumnNotNullEvent('table_a_name', 'column_g_name'),
      new ColumnEvent('table_a_name', 'column_h_name', 10, 9, 10, 21, 'column_h_type', null),
      new ColumnNoteEvent('table_a_name', 'column_h_name', 'column h note', 10, 44, 10, 58),
      new ColumnEvent('table_a_name', 'column_i_name', 11, 9, 11, 21, 'column_i_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_i_name', 11, 9, 11, 21, RefOperator::MANY_TO_ONE, 'column_i_ref_table', 11, 45, 11, 62, 'column_i_ref_column', 11, 64, 11, 82),
      new ColumnEvent('table_a_name', 'column_j_name', 12, 9, 12, 21, 'column_j_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_j_name', 12, 9, 12, 21, RefOperator::ONE_TO_MANY, 'column_j_ref_table', 12, 45, 12, 62, 'column_j_ref_column', 12, 64, 12, 82),
      new UnknownEvent([
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 85, 12, 85, ']', ']'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 86, 12, 86, '-', '-'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 87, 12, 87, '>', '>'),
      ]),
      new ColumnEvent('table_a_name', 'column_k_name', 13, 9, 13, 21, 'column_k_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_k_name', 13, 9, 13, 21, RefOperator::ONE_TO_ONE, 'column_k_ref_table', 13, 45, 13, 62, 'column_k_ref_column', 13, 64, 13, 82),
      new ColumnEvent('table_a_name', 'column_l_name', 14, 9, 14, 23, 'column_l_type', null),
      new ColumnEvent('table_a_name', 'column_m_name', 15, 9, 15, 21, 'column_m_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_m_name', 15, 9, 15, 21, RefOperator::MANY_TO_ONE, 'column_m_ref_table', 15, 45, 15, 64, 'column_m_ref_column', 15, 66, 15, 84),
      new ColumnEvent('table_a_name', 'column_n_name', 16, 9, 16, 21, 'column_n_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_n_name', 16, 9, 16, 21, RefOperator::MANY_TO_ONE, 'column_n_ref_table', 16, 45, 16, 62, 'column_n_ref_column', 16, 64, 16, 84),
      new ColumnEvent('table_a_name', 'column_o_name', 17, 9, 17, 21, 'column_o_type', null),
      new IndexEvent('table_a_name', [
        [
          'name' => 'column_o_name',
          'nameStartLine' => 17,
          'nameStartColumn' => 9,
          'nameEndLine' => 17,
          'nameEndColumn' => 21,
        ],
      ], null, null, null, null, null, true),
      new ColumnEvent('table_a_name', 'column_p_name', 18, 9, 18, 21, 'column_p_type', null),
      new ColumnConstantDefaultEvent('table_a_name', 'column_p_name', 'column_p_default', 18, 47, 18, 62),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_a_column_a',
          'nameStartLine' => 20,
          'nameStartColumn' => 11,
          'nameEndLine' => 20,
          'nameEndColumn' => 26,
        ],
      ], null, null, null, null, null, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_b_column_a',
          'nameStartLine' => 21,
          'nameStartColumn' => 12,
          'nameEndLine' => 21,
          'nameEndColumn' => 27,
        ],
      ], null, null, null, null, null, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_c_column_a',
          'nameStartLine' => 22,
          'nameStartColumn' => 12,
          'nameEndLine' => 22,
          'nameEndColumn' => 27,
        ],
        [
          'name' => 'index_c_column_b',
          'nameStartLine' => 22,
          'nameStartColumn' => 30,
          'nameEndLine' => 22,
          'nameEndColumn' => 45,
        ],
      ], null, null, null, null, null, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_d_column_a',
          'nameStartLine' => 23,
          'nameStartColumn' => 12,
          'nameEndLine' => 23,
          'nameEndColumn' => 27,
        ],
        [
          'name' => 'index_d_column_b',
          'nameStartLine' => 23,
          'nameStartColumn' => 30,
          'nameEndLine' => 23,
          'nameEndColumn' => 45,
        ],
        [
          'name' => 'index_d_column_c',
          'nameStartLine' => 23,
          'nameStartColumn' => 48,
          'nameEndLine' => 23,
          'nameEndColumn' => 63,
        ],
      ], null, null, null, null, null, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_e_column_a',
          'nameStartLine' => 24,
          'nameStartColumn' => 11,
          'nameEndLine' => 24,
          'nameEndColumn' => 26,
        ],
      ], 'test index e name', 24, 35, 24, 53, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_f_column_a',
          'nameStartLine' => 25,
          'nameStartColumn' => 11,
          'nameEndLine' => 25,
          'nameEndColumn' => 26,
        ],
      ], null, null, null, null, null, true),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_g_column_a',
          'nameStartLine' => 26,
          'nameStartColumn' => 11,
          'nameEndLine' => 26,
          'nameEndColumn' => 26,
        ],
      ], 'test index g name', 26, 35, 26, 53, true),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_h_column_a',
          'nameStartLine' => 27,
          'nameStartColumn' => 11,
          'nameEndLine' => 27,
          'nameEndColumn' => 28,
        ],
      ], null, null, null, null, null, false),
      new IndexEvent('table_a_name', [
        [
          'name' => 'index_i_column_a',
          'nameStartLine' => 28,
          'nameStartColumn' => 12,
          'nameEndLine' => 28,
          'nameEndColumn' => 29,
        ],
        [
          'name' => 'index_i_column_b',
          'nameStartLine' => 28,
          'nameStartColumn' => 32,
          'nameEndLine' => 28,
          'nameEndColumn' => 49,
        ],
        [
          'name' => 'index_i_column_c',
          'nameStartLine' => 28,
          'nameStartColumn' => 52,
          'nameEndLine' => 28,
          'nameEndColumn' => 69,
        ],
      ], null, null, null, null, null, false),
      new TableNoteEvent('table_a_name', 'table_a_note', 30, 15, 30, 28),
      new RefEvent('ref_a_table_a', 33, 12, 33, 24, 'ref_a_column_a', 33, 26, 33, 39, RefOperator::MANY_TO_ONE, 'ref_a_table_b', 33, 43, 33, 55, 'ref_a_column_b', 33, 57, 33, 70),
      new RefEvent('ref_b_table_a', 34, 12, 34, 24, 'ref_b_column_a', 34, 26, 34, 39, RefOperator::ONE_TO_MANY, 'ref_b_table_b', 34, 43, 34, 55, 'ref_b_column_b', 34, 57, 34, 70),
      new RefEvent('ref_c_table_a', 35, 12, 35, 24, 'ref_c_column_a', 35, 26, 35, 39, RefOperator::ONE_TO_ONE, 'ref_c_table_b', 35, 43, 35, 55, 'ref_c_column_b', 35, 57, 35, 70),
      new RefEvent('ref_d_table_a', 36, 12, 36, 26, 'ref_d_column_a', 36, 28, 36, 41, RefOperator::MANY_TO_ONE, 'ref_d_table_b', 36, 45, 36, 57, 'ref_d_column_b', 36, 59, 36, 72),
      new RefEvent('ref_e_table_a', 37, 12, 37, 24, 'ref_e_column_a', 37, 26, 37, 41, RefOperator::MANY_TO_ONE, 'ref_e_table_b', 37, 45, 37, 57, 'ref_e_column_b', 37, 59, 37, 72),
      new RefEvent('ref_f_table_a', 38, 12, 38, 24, 'ref_f_column_a', 38, 26, 38, 39, RefOperator::MANY_TO_ONE, 'ref_f_table_b', 38, 43, 38, 57, 'ref_f_column_b', 38, 59, 38, 72),
      new RefEvent('ref_g_table_a', 39, 12, 39, 24, 'ref_g_column_a', 39, 26, 39, 39, RefOperator::MANY_TO_ONE, 'ref_g_table_b', 39, 43, 39, 55, 'ref_g_column_b', 39, 57, 39, 72),
      new EnumEvent('enum_a_name', 41, 12, 41, 22),
      new EnumValueEvent('enum_a_name', 'enum_a_value_a', 42, 9, 42, 22),
      new EnumValueEvent('enum_a_name', 'enum_a_value_b', 43, 9, 43, 24),
      new EnumValueEvent('enum_a_name', 'enum_a_value_c', 44, 9, 44, 22),
      new EnumValueNoteEvent('enum_a_name', 'enum_a_value_c', 'enum_a_value_c_note', 44, 31, 44, 51),
      new EnumEvent('enum_b_name', 47, 12, 47, 24),
      new TableEvent('table_b_name', 49, 13, 49, 26),
      new TableEvent('table_c_name', 50, 13, 50, 24),
      new TableAliasEvent('table_c_name', 'table_c_alias', 50, 29, 50, 43),
      new TableNoteEvent('table_c_name', 'table_c_note', 51, 16, 51, 29),
      new RefEvent('ref_h_table_a', 54, 13, 54, 25, 'ref_h_column_a', 54, 27, 54, 40, RefOperator::MANY_TO_ONE, 'ref_h_table_b', 54, 44, 54, 56, 'ref_h_column_b', 54, 58, 54, 71),
      new RefEvent('ref_i_table_a', 55, 13, 55, 25, 'ref_i_column_a', 55, 27, 55, 40, RefOperator::ONE_TO_MANY, 'ref_i_table_b', 55, 44, 55, 56, 'ref_i_column_b', 55, 58, 55, 71),
      new RefEvent('ref_j_table_a', 56, 13, 56, 25, 'ref_j_column_a', 56, 27, 56, 40, RefOperator::ONE_TO_ONE, 'ref_j_table_b', 56, 44, 56, 56, 'ref_j_column_b', 56, 58, 56, 71),
      new RefEvent('ref_k_table_a', 57, 13, 57, 27, 'ref_k_column_a', 57, 29, 57, 42, RefOperator::MANY_TO_ONE, 'ref_k_table_b', 57, 46, 57, 58, 'ref_k_column_b', 57, 60, 57, 73),
      new RefEvent('ref_l_table_a', 58, 13, 58, 25, 'ref_l_column_a', 58, 27, 58, 42, RefOperator::MANY_TO_ONE, 'ref_l_table_b', 58, 46, 58, 58, 'ref_l_column_b', 58, 60, 58, 73),
      new RefEvent('ref_m_table_a', 59, 13, 59, 25, 'ref_m_column_a', 59, 27, 59, 40, RefOperator::MANY_TO_ONE, 'ref_m_table_b', 59, 44, 59, 58, 'ref_m_column_b', 59, 60, 59, 73),
      new RefEvent('ref_n_table_a', 60, 13, 60, 25, 'ref_n_column_a', 60, 27, 60, 40, RefOperator::MANY_TO_ONE, 'ref_n_table_b', 60, 44, 60, 56, 'ref_n_column_b', 60, 58, 60, 73),
      new UnknownEvent([
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 62, 7, 62, 16, 'unexpected', 'unexpected'),
      ]),
      new TableEvent('with_empty_column_attributes', 64, 13, 64, 40),
      new ColumnEvent('with_empty_column_attributes', 'name_of_column_with_empty_attributes', 64, 44, 64, 79, 'type_of_column_with_empty_attributes', null),
      new TableEvent('with_all_attributes_in_one_column', 65, 13, 65, 45),
      new ColumnEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes', 65, 49, 65, 82, 'type_of_column_with_all_attributes', null),
      new ColumnPrimaryKeyEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes'),
      new ColumnIncrementEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes'),
      new ColumnNotNullEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes'),
      new ColumnNoteEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes', 'example note', 65, 151, 65, 164),
      new IndexEvent(
        'with_all_attributes_in_one_column',
        [
          [
            'name' => 'name_of_column_with_all_attributes',
            'nameStartLine' => 65,
            'nameStartColumn' => 49,
            'nameEndLine' => 65,
            'nameEndColumn' => 82,
          ],
        ],
        null,
        null,
        null,
        null,
        null,
        true
      ),
      new ColumnConstantDefaultEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes', 'example default', 65, 184, 65, 200),
      new RefEvent('with_all_attributes_in_one_column', 65, 13, 65, 45, 'name_of_column_with_all_attributes', 65, 49, 65, 82, RefOperator::MANY_TO_ONE, 'other_table_name', 65, 210, 65, 225, 'other_column_name', 65, 227, 65, 243),
      new ColumnCalculatedDefaultEvent('with_all_attributes_in_one_column', 'name_of_column_with_all_attributes', 'other example default', 65, 255, 65, 277),
      new IndexEvent(
        'with_all_attributes_in_one_column',
        [
          [
            'name' => 'name_of_column_with_all_attributes',
            'nameStartLine' => 65,
            'nameStartColumn' => 49,
            'nameEndLine' => 65,
            'nameEndColumn' => 82,
          ],
        ],
        null,
        null,
        null,
        null,
        null,
        true
      ),
      new TableEvent('which_tests_index_edge_cases', 66, 13, 66, 40),
      new IndexEvent(
        'which_tests_index_edge_cases',
        [
          [
            'name' => 'abc',
            'nameStartLine' => 68,
            'nameStartColumn' => 19,
            'nameEndLine' => 68,
            'nameEndColumn' => 21,
          ],
          [
            'name' => 'def',
            'nameStartLine' => 68,
            'nameStartColumn' => 24,
            'nameEndLine' => 68,
            'nameEndColumn' => 26,
          ],
          [
            'name' => 'ghi',
            'nameStartLine' => 68,
            'nameStartColumn' => 29,
            'nameEndLine' => 68,
            'nameEndColumn' => 31,
          ],
        ],
        'example name',
        68,
        49,
        68,
        62,
        true
      ),
      new EnumEvent('which_tests_edge_cases', 70, 12, 70, 33),
      new EnumValueEvent('which_tests_edge_cases', 'example_value_name', 70, 37, 70, 54),
      new TableEvent('which_tests_column_edge_cases', 71, 13, 71, 41),
      new ColumnEvent('which_tests_column_edge_cases', 'example_column_name_a', 72, 9, 72, 29, 'example_column_type_a', 'example_column_size_a'),
      new ColumnNoteEvent('which_tests_column_edge_cases', 'example_column_name_a', 'example_column_note_a', 72, 83, 72, 103),
      new ColumnEvent('which_tests_column_edge_cases', 'example_column_name_b', 73, 9, 73, 29, 'example_column_type_b', null),
      new TableEvent('which_tests_additional_column_edge_cases', 75, 13, 75, 52),
      new ColumnEvent('which_tests_additional_column_edge_cases', 'example_column_name_a', 76, 9, 76, 29, 'example_column_type_a', 'example_column_size_a'),
      new EndOfFileEvent(true),
    ], $logParserTarget->events);
  }

  public function test_file_with_interrupted_structure()
  {
    $logParserTarget = new LogParserTarget();
    $parser = new Parser($logParserTarget);
    $tokenizer = new Tokenizer($parser);

    foreach (str_split("
      tABlE table_a_name as table_a_alias {
        column_a_name column_a_type
        column_b_name column_b_type(column_b_size)
        column_c_name column_c_type [pk]
        column_d_name column_d_type [increment]
        column_e_name column_e_type [default: 'column e default']
        column_f_name column_f_type [default: `column f default`]
        column_g_name column_g_type [not null] /
        column_h_name column_h_type [note: 'column h note']
        column_i_name column_i_type [ref: > column_i_ref_table.column_i_ref_column]
        column_j_name column_j_type [ref: < column_j_ref_table.column_j_ref_column] ]->
        column_k_name column_k_type [ref: - column_k_ref_table.column_k_ref_column]
    ") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new TableEvent('table_a_name', 2, 13, 2, 24),
      new TableAliasEvent('table_a_name', 'table_a_alias', 2, 29, 2, 41),
      new ColumnEvent('table_a_name', 'column_a_name', 3, 9, 3, 21, 'column_a_type', null),
      new ColumnEvent('table_a_name', 'column_b_name', 4, 9, 4, 21, 'column_b_type', 'column_b_size'),
      new ColumnEvent('table_a_name', 'column_c_name', 5, 9, 5, 21, 'column_c_type', null),
      new ColumnPrimaryKeyEvent('table_a_name', 'column_c_name'),
      new ColumnEvent('table_a_name', 'column_d_name', 6, 9, 6, 21, 'column_d_type', null),
      new ColumnIncrementEvent('table_a_name', 'column_d_name'),
      new ColumnEvent('table_a_name', 'column_e_name', 7, 9, 7, 21, 'column_e_type', null),
      new ColumnConstantDefaultEvent('table_a_name', 'column_e_name', 'column e default', 7, 47, 7, 64),
      new ColumnEvent('table_a_name', 'column_f_name', 8, 9, 8, 21, 'column_f_type', null),
      new ColumnCalculatedDefaultEvent('table_a_name', 'column_f_name', 'column f default', 8, 47, 8, 64),
      new ColumnEvent('table_a_name', 'column_g_name', 9, 9, 9, 21, 'column_g_type', null),
      new ColumnNotNullEvent('table_a_name', 'column_g_name'),
      new ColumnEvent('table_a_name', 'column_h_name', 10, 9, 10, 21, 'column_h_type', null),
      new ColumnNoteEvent('table_a_name', 'column_h_name', 'column h note', 10, 44, 10, 58),
      new ColumnEvent('table_a_name', 'column_i_name', 11, 9, 11, 21, 'column_i_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_i_name', 11, 9, 11, 21, RefOperator::MANY_TO_ONE, 'column_i_ref_table', 11, 45, 11, 62, 'column_i_ref_column', 11, 64, 11, 82),
      new ColumnEvent('table_a_name', 'column_j_name', 12, 9, 12, 21, 'column_j_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_j_name', 12, 9, 12, 21, RefOperator::ONE_TO_MANY, 'column_j_ref_table', 12, 45, 12, 62, 'column_j_ref_column', 12, 64, 12, 82),
      new UnknownEvent([
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 85, 12, 85, ']', ']'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 86, 12, 86, '-', '-'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 87, 12, 87, '>', '>'),
      ]),
      new ColumnEvent('table_a_name', 'column_k_name', 13, 9, 13, 21, 'column_k_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_k_name', 13, 9, 13, 21, RefOperator::ONE_TO_ONE, 'column_k_ref_table', 13, 45, 13, 62, 'column_k_ref_column', 13, 64, 13, 82),
      new EndOfFileEvent(false),
    ], $logParserTarget->events);
  }

  public function test_file_with_interrupted_invalid_characters()
  {
    $logParserTarget = new LogParserTarget();
    $parser = new Parser($logParserTarget);
    $tokenizer = new Tokenizer($parser);

    foreach (str_split("
      tABlE table_a_name as table_a_alias {
        column_a_name column_a_type
        column_b_name column_b_type(column_b_size)
        column_c_name column_c_type [pk]
        column_d_name column_d_type [increment]
        column_e_name column_e_type [default: 'column e default']
        column_f_name column_f_type [default: `column f default`]
        column_g_name column_g_type [not null] /
        column_h_name column_h_type [note: 'column h note']
        column_i_name column_i_type [ref: > column_i_ref_table.column_i_ref_column]
        column_j_name column_j_type [ref: < column_j_ref_table.column_j_ref_column] ]->
    ") as $character) {
      $tokenizer->character($character);
    }
    $tokenizer->endOfFile();

    $this->assertEquals([
      new TableEvent('table_a_name', 2, 13, 2, 24),
      new TableAliasEvent('table_a_name', 'table_a_alias', 2, 29, 2, 41),
      new ColumnEvent('table_a_name', 'column_a_name', 3, 9, 3, 21, 'column_a_type', null),
      new ColumnEvent('table_a_name', 'column_b_name', 4, 9, 4, 21, 'column_b_type', 'column_b_size'),
      new ColumnEvent('table_a_name', 'column_c_name', 5, 9, 5, 21, 'column_c_type', null),
      new ColumnPrimaryKeyEvent('table_a_name', 'column_c_name'),
      new ColumnEvent('table_a_name', 'column_d_name', 6, 9, 6, 21, 'column_d_type', null),
      new ColumnIncrementEvent('table_a_name', 'column_d_name'),
      new ColumnEvent('table_a_name', 'column_e_name', 7, 9, 7, 21, 'column_e_type', null),
      new ColumnConstantDefaultEvent('table_a_name', 'column_e_name', 'column e default', 7, 47, 7, 64),
      new ColumnEvent('table_a_name', 'column_f_name', 8, 9, 8, 21, 'column_f_type', null),
      new ColumnCalculatedDefaultEvent('table_a_name', 'column_f_name', 'column f default', 8, 47, 8, 64),
      new ColumnEvent('table_a_name', 'column_g_name', 9, 9, 9, 21, 'column_g_type', null),
      new ColumnNotNullEvent('table_a_name', 'column_g_name'),
      new ColumnEvent('table_a_name', 'column_h_name', 10, 9, 10, 21, 'column_h_type', null),
      new ColumnNoteEvent('table_a_name', 'column_h_name', 'column h note', 10, 44, 10, 58),
      new ColumnEvent('table_a_name', 'column_i_name', 11, 9, 11, 21, 'column_i_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_i_name', 11, 9, 11, 21, RefOperator::MANY_TO_ONE, 'column_i_ref_table', 11, 45, 11, 62, 'column_i_ref_column', 11, 64, 11, 82),
      new ColumnEvent('table_a_name', 'column_j_name', 12, 9, 12, 21, 'column_j_type', null),
      new RefEvent('table_a_name', 2, 13, 2, 24, 'column_j_name', 12, 9, 12, 21, RefOperator::ONE_TO_MANY, 'column_j_ref_table', 12, 45, 12, 62, 'column_j_ref_column', 12, 64, 12, 82),
      new UnknownEvent([
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 85, 12, 85, ']', ']'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 86, 12, 86, '-', '-'),
        new TokenEvent(TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER, 12, 87, 12, 87, '>', '>'),
      ]),
      new EndOfFileEvent(false),
    ], $logParserTarget->events);
  }
}
