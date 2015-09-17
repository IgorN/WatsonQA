<?php

namespace Babylon\WatsonBundle\Model;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

/**
 * Simple collection.
 */
class Collection implements
    Countable,
    IteratorAggregate,
    ArrayAccess
{
    /**
     * @var array
     */
    private $elements;

    /**
     * Initialization of the required data.
     *
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        $this->elements = $elements;
    }

    /**
     * Count elements of an object.
     *
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * Retrieve an array iterator.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * Whether a offset exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return bool
     */
    public function offsetSet($offset, $value)
    {
        if (! isset($offset)) {
            return $this->add($value);
        }
        $this->set($offset, $value);
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     *
     * @return null
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * Checks whether the collection contains a specific key/index.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function containsKey($key)
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * Removes an element with a specific key/index from the collection.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function remove($key)
    {
        if (! isset($this->elements[$key]) && ! array_key_exists($key, $this->elements)) {
            return null;
        }
        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    /**
     * Gets the element with the given key/index.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->elements[$key]) ? $this->elements[$key] : null;
    }

    /**
     * Adds an element to the collection.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function add($value)
    {
        $this->elements[] = $value;

        return true;
    }

    /**
     * Set an element.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;
    }
}