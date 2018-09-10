<?php

namespace Bruchmann\Examples\Cars1\Domain\Repository\CSV;

/*
 * Repository for very simple model class as programming-example only.
 * Any usage is not intended serving practical intentions.
 *
 * @author         David Bruchmann <david.bruchmann@gmail.com>
 * @copyright 2018 David Bruchmann <david.bruchmann@gmail.com>
 */
class CarRepository extends \Bruchmann\Examples\Cars1\Domain\Repository\CSV\AbstractCsvRepository
{

    /**
     * @var \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    protected $car = null;

    /**
     * @var \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    protected $prev = null;

    /**
     * @var \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    protected $current = null;

    /**
     * @var \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    protected $next = null;

    /**
     * @return array<\Bruchmann\Examples\Cars1\Domain\Model\Car>
     */
    public function findAll()
    {
        $this->resetRelatives();
        if (is_resource($this->csv)) {
            $all = array();
            $this->rewind();
            while (!feof($this->csv)) {
                $row = fgetcsv ($this->csv, 0, $this->delimiter, $this->enclosure, $this->escape);
                if(isset($row[0]) && $row[0]) {
                    // construction with $this->car isn't really required here but it shows
                    // how 'suddenly' the Iterator-functions valid() and current() become available
                    //                                                          $uid,    $name,   $wheels, $doors,  $lamps
                    $this->car = new \Bruchmann\Examples\Cars1\Domain\Model\Car($row[0], $row[1], $row[2], $row[3], $row[4]);
                    if ($this->valid()) {
                        $all[] = $this->current();
                    }
                }
                $this->car = null;
            }
            return $all;
        } else {
            throw new \InvalidArgumentException('$this->csv is no resource.');
        }
    }

    /**
     * @param int $uid
     *
     * @return \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    public function findByUid(int $uid)
    {
        $cars = $this->findAll();
        foreach ($cars as $count => $car) {
            if ($car->getUid() === $uid) {
                $this->car = $car;
                $this->key = $count;
                if ($count===0) {
                    $this->isFirst = true;
                }
                if (count($cars)-1===$count) {
                    $this->isLast = true;
                }
                if (!$this->isFirst) {
                    $this->prev = $cars[$count - 1];
                }
                if (!$this->isLast) {
                    $this->next = $cars[$count + 1];
                }
                return $car;
            }
        }
    }

    /**
     * Even not checked by model or repository, $name is intended being unique.
     * If several $cars have the same $name, the first one is returned.
     *
     * @param string $name
     *
     * @return \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    public function findByName($name)
    {
        $cars = $this->findAll();
        $this->resetRelatives();
        foreach ($cars as $count => $car) {
            if ($car->getName() == $name) {
                $this->car = $car;
                $this->key = $count;
                if ($count===0) {
                    $this->isFirst = true;
                }
                if (count($cars)-1===$count) {
                    $this->isLast = true;
                }
                if (!$this->isFirst) {
                    $this->prev = $cars[$count - 1];
                }
                if (!$this->isLast) {
                    $this->next = $cars[$count + 1];
                }
                return $car;
            }
        }
    }

    /**
     * @param int $wheels
     *
     * @return array<\Bruchmann\Examples\Cars1\Domain\Model\Car>
     */
    public function findByWheels($wheels)
    {
        $cars = $this->findAll();
        $byWheels = array();
        foreach ($cars as $count => $car) {
            if ($car->getWheels() == $wheels) {
                $byWheels[] = $car;
            }
        }
        return $byWheels;
    }

    /**
     * @param int $doors
     *
     * @return array<\Bruchmann\Examples\Cars1\Domain\Model\Car>
     */
    public function findByDoors($doors)
    {
        $cars = $this->findAll();
        $byDoors = array();
        foreach ($cars as $count => $car) {
            if ($car->getDoors() == $doors) {
                $byDoors[] = $car;
            }
        }
        return $byDoors;
    }

    /**
     * @param int $lamps
     *
     * @return array<\Bruchmann\Examples\Cars1\Domain\Model\Car>
     */
    public function findByLamps($lamps)
    {
        $cars = $this->findAll();
        $byLamps = array();
        foreach ($cars as $count => $car) {
            if ($car->getLamps() == $lamps) {
                $byLamps[] = $car;
            }
        }
        return $byLamps;
    }

    /**
     * @return \Bruchmann\Examples\Cars1\Domain\Model\Car
     */
    function current()
    {
        return $this->car;
    }

    /**
     * @return bool
     */
    function valid()
    {
        return is_object($this->current());
    }
}
