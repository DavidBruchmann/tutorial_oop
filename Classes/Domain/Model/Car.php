<?php

namespace Bruchmann\Examples\Cars1\Domain\Model;

/**
 * Very simple model as programming-example only.
 * Any usage is not intended serving practical intentions.
 *
 * @author         David Bruchmann <david.bruchmann@gmail.com>
 * @copyright 2018 David Bruchmann <david.bruchmann@gmail.com>
 */
class Car
{
    /*
     * @var int
     */
    protected $uid;

    /*
     * @var string
     */
    protected $name;

    /*
     * @var int
     */
    protected $wheels;

    /*
     * @var int
     */
    protected $doors;

    /*
     * @var int
     */
    protected $lamps;

    /**
     * @param int $uid       if $uid is a string it will be converted to integer
     * @param string $name
     * @param int $wheels    if $wheels is a string it will be converted to integer
     * @param int $doors     if $doors is a string it will be converted to integer
     * @param int $lamps     if $lamps is a string it will be converted to integer
     */
    public function __construct($uid, $name, $wheels, $doors, $lamps)
    {
        $this->setUid($uid);
        $this->setName($name);
        $this->setWheels($wheels);
        $this->setDoors($doors);
        $this->setLamps($lamps);
    }

//    /**
//     * Was intended for template engine "smarty"
//     */
//    public function value($key)
//    {
//        return $this->{'get' . ucfirst($key)};
//    }

    /**
     * @return array $car
     */
    public function toArray()
    {
        return array(
            'uid' => $this->getUid(),
            'name' => $this->getName(),
            'wheels' => $this->getWheels(),
            'doors' => $this->getDoors(),
            'lamps' => $this->getLamps()
        );
    }

    /**
     * @param int $uid       if $uid is a string it will be converted to integer
     */
    public function setUid($uid)
    {
        $this->uid = intval($uid);
    }

    /**
     * @return int $uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $wheels    if $wheels is a string it will be converted to integer
     */
    public function setWheels($wheels)
    {
        $this->wheels = intval($wheels);
    }

    /**
     * @return int $wheels
     */
    public function getWheels()
    {
        return $this->wheels;
    }

    /**
     * @param int $doors     if $doors is a string it will be converted to integer
     */
    public function setDoors($doors)
    {
        $this->doors = intval($doors);
    }

    /**
     * @return int $doors
     */
    public function getDoors()
    {
        return $this->doors;
    }

    /**
     * @param int $lamps     if $lamps is a string it will be converted to integer
     */
    public function setLamps($lamps)
    {
        $this->lamps = intval($lamps);
    }

    /**
     * @return int $lamps
     */
    public function getLamps()
    {
        return $this->lamps;
    }
}
