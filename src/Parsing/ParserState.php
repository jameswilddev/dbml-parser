<?php

namespace JamesWildDev\DBMLParser\Parsing;

/**
 * Values which identify the states of parsers.
 */
class ParserState
{
  /**
   * No tokens are currently being aggregated.
   */
  const BETWEEN_STATEMENTS = 0;

  /**
   * The keyword "table" has been stated but nothing more.
   */
  const TABLE = 1;

  /**
   * The keyword "table" and the following name have been given.
   */
  const TABLE_NAMED = 2;

  /**
   * The alias of a table is next ("table {name} as").
   */
  const TABLE_AS = 3;

  /**
   * The next token should be the opening brace of a table.
   */
  const TABLE_ALIASED = 4;

  /**
   * Inside a table, but not parsing any particular thing yet.
   */
  const TABLE_BODY = 5;

  /**
   * A column has been named.
   */
  const COLUMN_NAMED = 6;

  /**
   * A column has been named and given a type.
   */
  const COLUMN_TYPED = 7;

  /**
   * The size of a column is expected next (following "(", the opening parenthesis of a column size).
   */
  const COLUMN_BEFORE_SIZE = 8;

  /**
   * The size of a column has been given and the closing parenthesis (")") is expected next.
   */
  const COLUMN_SIZED = 9;

  /**
   * The closing parenthesis (")") has been given following a column's size.
   */
  const COLUMN_AFTER_SIZE = 10;

  /**
   * Either a closing bracket ("]") or the start of a column attribute ("pk", "not null", etc.) is expected.
   */
  const COLUMN_AFTER_COMMA = 11;

  /**
   * The "default" attribute has been added to a column.  Next is a semicolon.
   */
  const COLUMN_DEFAULT = 12;

  /**
   * The "default" attribute has been added to a column, and has been followed by a semicolon.  Next is a string literal describing the default.
   */
  const COLUMN_DEFAULT_SEMICOLON = 13;

  /**
   * The "pk" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_PRIMARY_KEY = 14;

  /**
   * The "increment" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_INCREMENT = 15;

  /**
   * A constant "default" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_CONSTANT_DEFAULT = 16;

  /**
   * A calculated "default" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_CALCULATED_DEFAULT = 17;

  /**
   * The word "not" has been added to a column.  Next is "null".
   */
  const COLUMN_NOT = 18;

  /**
   * A "not null" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_NOT_NULL = 19;

  /**
   * The word "note" has been added to a column.  Next is a semicolon.
   */
  const COLUMN_NOTE = 20;

  /**
   * The word "note" and a semicolon have been added to a column.  Next is a string literal.
   */
  const COLUMN_NOTE_SEMICOLON = 21;

  /**
   * The word "note", a semicolon and a string literal have been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_NOTE = 22;

  /**
   * The word "ref" has been added to a column.  Next is a semicolon.
   */
  const COLUMN_REF = 23;

  /**
   * The word "ref" and a semicolon have been added to a column.  Next is an operator.
   */
  const COLUMN_REF_SEMICOLON = 24;

  /**
   * The word "ref", a semicolon and an operator have been added to a column.  Next is a referenced table name.
   */
  const COLUMN_REF_OPERATOR = 25;

  /**
   * The word "ref", a semicolon, an operator and a referenced table name or alias have been added to a column.  Next is a period between the referenced table and column names.
   */
  const COLUMN_REF_REFERENCED_TABLE_NAME_OR_ALIAS = 26;

  /**
   * The word "ref", a semicolon, an operator, a referenced table name or alias and a period have been added to a column.  Next is a referenced column name.
   */
  const COLUMN_REF_PERIOD = 27;

  /**
   * The word "ref", a semicolon, an operator, a referenced table name or alias, a period and a referenced column name have been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_REF = 28;

  /**
   * The word "indexes" has been given in a table body.  Next is an opening brace ("{").
   */
  const INDEXES = 29;

  /**
   * Inside an index block, but not parsing any particular index yet.
   */
  const INDEXES_BODY = 30;

  /**
   * The columns of an index have been given.  Next is a closing brace ("}"), opening bracket ("["), identifier of another column to index, or an opening parenthesis (of a list of columns).
   */
  const INDEX_COLUMNS = 31;

  /**
   * An opening parenthesis ("(") for a multiple-column index has been given.  Next is an identifier of the first column.
   */
  const INDEX_OPENING_PARENTHESIS = 32;

  /**
   * A name of a column to index has been given.  Next is a comma (",") or a closing parenthesis (")").
   */
  const INDEX_MULTIPLE_NAME = 33;

  /**
   * Between attributes of an index.
   */
  const INDEX_AFTER_COMMA = 34;

  /**
   * The "unique" attribute has been added to an index.  Next is a comma (",") or a closing bracket ("]").
   */
  const INDEX_AFTER_UNIQUE = 35;

  /**
   * The word "name" has been added to an index.  Next is a semicolon (":").
   */
  const INDEX_NAME = 36;

  /**
   * The word "name" and a semicolon (":") have been added to an index.  Next is a name (a string literal).
   */
  const INDEX_NAME_SEMICOLON = 37;

  /**
   * A "name" attribute has been added to an index.  Next is a comma (",") or a closing bracket ("]").
   */
  const INDEX_AFTER_NAME = 38;

  /**
   * The "unique" attribute has been added to a column.  Next is a closing bracket ("]") or a comma (",").
   */
  const COLUMN_AFTER_UNIQUE = 39;

  /**
   * The word "note" has been added to a table.  Next is a semicolon (":") or an opening brace ("{").
   */
  const TABLE_NOTE = 40;

  /**
   * The word "note" and a semicolon have been added to a table.  Next is a string literal.
   */
  const TABLE_NOTE_SEMICOLON = 41;

  /**
   * The word "ref" has been added.  Next is a semicolon.
   */
  const REF = 42;

  /**
   * The word "ref" and a semicolon have been added.  Next is a referencing table name.
   */
  const REF_SEMICOLON = 43;

  /**
   * The word "ref", a semicolon, an operator and a referencing table name or alias have been added.  Next is a period between the referencing table and column names.
   */
  const REF_REFERENCING_TABLE_NAME_OR_ALIAS = 44;

  /**
   * The word "ref", a semicolon, a referencing table name or alias and a period have been added.  Next is a referencing column name.
   */
  const REF_REFERENCING_PERIOD = 45;

  /**
   * The word "ref", a semicolon, a referencing table name or alias, a period and a referencing column name have been added.  Next is an operator.
   */
  const REF_REFERENCING_COLUMN_NAME = 46;

  /**
   * The word "ref", a semicolon, a referencing table name or alias, a period, a referencing column name and an operator have been added.  Next is a referenced table name.
   */
  const REF_OPERATOR = 47;

  /**
   * The word "ref", a semicolon, a referencing table name or alias, a period, a referencing column name, an operator and a referenced table name have been added.  Next is a period between the referenced table and column names.
   */
  const REF_REFERENCED_TABLE_NAME_OR_ALIAS = 48;

  /**
   * The word "ref", a semicolon, a referencing table name or alias, a period, a referencing column name, an operator, a referenced table name and a period have been added.  Next is a referenced column name.
   */
  const REF_REFERENCED_PERIOD = 49;

  /**
   * The word "enum" has been added.  Next is the name of the enum.
   */
  const ENUM = 50;

  /**
   * The word "enum" and the following name have been given.  Next is the opening brace. ("{").
   */
  const ENUM_NAME = 51;

  /**
   * Inside an enum, but not parsing any particular thing yet.
   */
  const ENUM_BODY = 52;

  /**
   * The name of an enum value has been given.
   */
  const ENUM_VALUE_NAME = 53;

  /**
   * The name of an enum value and an opening bracket have been given.  Next is the word "note" or a closing bracket ("]").
   */
  const ENUM_VALUE_OPENING_BRACKET = 54;

  /**
   * The name of an enum value, an opening bracket and the word "note" have been given.  Next is a semicolon (":").
   */
  const ENUM_VALUE_NOTE = 55;

  /**
   * The name of an enum value, an opening bracket, the word "note" and a semicolon have been given.  Next is the content of the note.
   */
  const ENUM_VALUE_NOTE_SEMICOLON = 56;

  /**
   * The name of an enum value, an opening bracket, the word "note", a semicolon and the content of the note have been given.  Next is the closing bracket ("]").
   */
  const ENUM_VALUE_NOTE_CONTENT = 57;

  /**
   * The word "note" and an opening brace have been added to a table.  Next is a string literal.
   */
  const TABLE_NOTE_OPENING_BRACE = 58;

  /**
   * The word "note", an opening brace and a string literal have been added to a table.  Next is a closing brace ("}").
   */
  const TABLE_NOTE_BRACED_CONTENT = 59;

  /**
   * The word "ref" and an opening brace have been added.  Next is a referencing table name.
   */
  const BRACED_REF = 60;

  /**
   * The word "ref", an opening brace, an operator and a referencing table name or alias have been added.  Next is a period between the referencing table and column names.
   */
  const BRACED_REF_REFERENCING_TABLE_NAME_OR_ALIAS = 61;

  /**
   * The word "ref", an opening brace, a referencing table name or alias and a period have been added.  Next is a referencing column name.
   */
  const BRACED_REF_REFERENCING_PERIOD = 62;

  /**
   * The word "ref", an opening brace, a referencing table name or alias, a period and a referencing column name have been added.  Next is an operator.
   */
  const BRACED_REF_REFERENCING_COLUMN_NAME = 63;

  /**
   * The word "ref", an opening brace, a referencing table name or alias, a period, a referencing column name and an operator have been added.  Next is a referenced table name.
   */
  const BRACED_REF_OPERATOR = 64;

  /**
   * The word "ref", an opening brace, a referencing table name or alias, a period, a referencing column name, an operator and a referenced table name have been added.  Next is a period between the referenced table and column names.
   */
  const BRACED_REF_REFERENCED_TABLE_NAME_OR_ALIAS = 65;

  /**
   * The word "ref", an opening brace, a referencing table name or alias, a period, a referencing column name, an operator, a referenced table name and a period have been added.  Next is a referenced column name.
   */
  const BRACED_REF_REFERENCED_PERIOD = 66;

  /**
   * The word "ref", an opening brace, a referencing table name or alias, a period, a referencing column name, an operator, a referenced table name, a period and a referenced column name have been added.  Next is a closing brace ("}").
   */
  const BRACED_REF_REFERENCED_COLUMN_NAME = 67;
}
