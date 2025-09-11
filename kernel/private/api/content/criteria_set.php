<?php
/**
 * File containing the ezpContentCriteriaSet class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package API
 */

/**
 * This class handles a list of content query criteria
 * @package API
 */
class ezpContentCriteriaSet implements ArrayAccess, Countable, Iterator
{
    /**
     * Array offset setter
     * Called when a criteria is added. Expects an empty array index syntax.
     *
     * @param mixed $offset
     * @param eZContentCriteria $value
     */
    public function offsetSet( $offset, $value ): void
    {
        $this->criteria[] = $value;
    }

    /**
     * Array offset getter
     *
     * @param mixed $offset
     */
    public function offsetGet( $offset ): mixed{
        return $this->criteria[$offset];
    }

    public function offsetExists( $offset ): bool {
        return isset ($this->criteria[$offset]);
    }

    public function offsetUnset( $offset ): void{
        unset( $this->criteria[$offset] );
    }

    /**
     * Returns the number of registered criteria
     * @note Implements the count() method of the Countable interface
     * @return int
     */
    public function count(): int
    {
        return count( $this->criteria );
    }

    //// Iterator interface

    public function key(): mixed
    {
        return  $this->pointer;
    }

    public function current (): mixed
    {
        return $this->criteria[$this->pointer];
    }

    public function next(): void
    {
        ++$this->pointer;
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }

    public function valid(): bool
    {
        return isset( $this->criteria[$this->pointer] );
    }

    private $criteria = array();

    /**
     * Iterator interface pointer
     * @var int
     */
    private $pointer = 0;
}
?>
