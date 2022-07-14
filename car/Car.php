<?php

include_once 'FuelTank.php';

class Car
{
    private FuelTank $fuelTank;
    private $gearShift;
    private $distance;

    public function __construct()
    {
        $this->gearShift = 0;
        $this->distance = 0;
        $this->fuelTank = new FuelTank();
    }

    public function get_distance()
    {
        return $this->distance;
    }
    public function set_distance($newDistance)
    {
        $this->distance = $newDistance;
    }
    public function add_distance($addDistance)
    {
        $this->distance += $addDistance;
    }
    public function get_gearShift()
    {
        return $this->gearShift;
    }
    public function set_gearShift($newGearShift)
    {
        if ($newGearShift > 3)
        {
            $newGearShift = 3;
        }
        $this->gearShift = $newGearShift;
    }

    public function shit_up()
    {
        if ($this->gearShift != 3)
        {
            $this->gearShift += 1;
            return true;
        }
        return false;
    }
    public function fill_up_the_tank()
    {
        $this->gearShift = 0;
        $this->fuelTank->fill_fuelTank();
    }
    public function travel_distance()
    {
        $this->add_distance($this->get_gearShift());
        $this->fuelTank->use_fuel($this->get_gearShift());
    }
}