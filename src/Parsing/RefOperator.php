<?php

namespace JamesWildDev\DBMLParser\Parsing;

/**
 * Values which identify the operator of a ref.
 */
class RefOperator
{
  /**
   * The first table/column refers to the second table/column.  For each row in the second table, there can be any number in the first.
   */
  const MANY_TO_ONE = 0;

  /**
   * The second table/column refers to the first table/column.  For each row in the first table, there can be any number in the second.
   */
  const ONE_TO_MANY = 1;

  /**
   * The first table/column and second table/column share a one-to-one relationship.
   */
  const ONE_TO_ONE = 2;
}
