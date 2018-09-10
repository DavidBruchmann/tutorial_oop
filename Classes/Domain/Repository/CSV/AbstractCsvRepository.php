<?php

namespace Bruchmann\Examples\Cars1\Domain\Repository\CSV;

/**
 * Abstract repository class for CSV file(s), implementing interfaces \Iterator and \ArrayAccess
 *
 * @see http://php.net/manual/en/class.iterator.php
 * @see http://php.net/manual/en/class.arrayaccess.php
 * @see http://php.net/manual/en/function.fputcsv.php
 * @see http://php.net/manual/en/function.fgetcsv.php
 * @see http://php.net/manual/en/function.str-getcsv.php
 *
 * @author         David Bruchmann <david.bruchmann@gmail.com>
 * @copyright 2018 David Bruchmann <david.bruchmann@gmail.com>
 */
abstract class AbstractCsvRepository implements \Iterator, \ArrayAccess
{
    /**
     * @var string
     */
    protected $csvFile = '';

    /**
     * @var string
     */
    protected $basePath = '';

    /**
     * @var resource
     */
    protected $csv = null;

    /**
     * @var bool
     */
    protected $readOnly = false;

    /**
     * @var string
     */
    protected $delimiter = '';

    /**
     * @var string
     */
    protected $enclosure = '';

    /**
     * @var string
     */
    protected $escape = '';

    /**
     * @var object
     */
    protected $prev = null;

    /**
     * @var object
     */
    protected $current = null;

    /**
     * @var object
     */
    protected $next = null;

    /**
     * @var int
     */
    protected $key = null;

    /**
     * @var bool
     */
    protected $isFirst = false;

    /**
     * @var bool
     */
    protected $isLast = false;

    /**
     * @param string  path to csv-file
     * @param bool    if csv-file shall be opened read only
     * @param string  delimiter used in csv-file
     * @param string  enclosure used in csv-file
     * @param string  escape used in csv-file
     */
    public function __construct($csvFile, $readOnly=false, $delimiter = ';', $enclosure = '"', $escape = "\\")
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
        $this->initCsvFile($csvFile);
        $this->readOnly = $readOnly;
        $this->initCsv();
    }

    /**
     * @param string  $basePath to this framework
     *
     * @return object $this for chaining
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * @param string  path to csv-file
     *
     * @return object $this for chaining
     */
    public function initCsvFile($csvFile)
    {
        if (is_file($csvFile)) {
            if (is_readable($csvFile)) {
                $this->csvFile = $csvFile;
            } else {
                throw new \InvalidArgumentException('CSV file must be readable.');
            }
        } else {
            throw new \InvalidArgumentException('Path to CSV file must be valid.');
        }
        return $this;
    }

    /**
     * Is initializing file-resource.
     *
     * @return object $this for chaining
     */
    protected function initCsv()
    {
        if (!$this->csv) {
            $mode = $this->readOnly ? 'r' : 'r+';
            $this->csv = fopen($this->csvFile, $mode);
        }
        return $this;
    }

    /**
     * Resets all variable relative to current object.
     * These variables are only useful if a single object is chosen.
     * Exception is this->current which might be used in a loop;
     */
    protected function resetRelatives()
    {
        $this->prev = null;
        $this->current = null;
        $this->next = null;
        $this->key = null;
        $this->valid = false;
        $this->isFirst = false;
        $this->isLast = false;
    }

    /**
     * @important To be defined in extending class
     *
     * @return array<[object of single model]>
     */
    public function findAll()
    {
    }

    /**
     * required by Iterator Interface
     *
     * @return object of single model
     */
    function key()
    {
        return $this->key;
    }

    /**
     * Not required by any interface but useful
     *
     * @return object of single model
     */
    function prev()
    {
        return $this->prev;
    }

    /**
     * required by Iterator Interface
     *
     * @return object of single model
     */
    function next()
    {
        return $this->next;
    }

    /**
     * required by Iterator Interface
     *
     * rewinds array $this->csv
     */
    function rewind()
    {
        rewind($this->csv);
    }

    /**
     * required by Iterator Interface
     *
     * @important To be defined in extending class
     *
     * @return object of single model
     */
    function current()
    {
    }

    /**
     * required by Iterator Interface
     *
     * @return bool
     */
    function valid()
    {
        return is_object($this->current());
    }

    /*
     * required by ArrayAccess Interface
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ($offset > -1 && $offset < count($this->csv));
    }

    /*
     * required by ArrayAccess Interface
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->csv[$offset];
    }

    /*
     * required by ArrayAccess Interface
     *
     * @param mixed $offset
     *
     * @return object $this for chaining
     */
    public function offsetSet($offset, $value)
    {
        $this->csv[$offset] = $value;
        return $this;
    }

    /*
     * required by ArrayAccess Interface
     *
     * @param mixed $offset
     *
     * @return object $this for chaining
     */
    public function offsetUnset($offset)
    {
        unset($this->csv[$offset]);
        return $this;
    }
}
