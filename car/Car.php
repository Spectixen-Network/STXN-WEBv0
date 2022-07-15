<?php

include_once 'FuelTank.php';

class Car
{
    private $fuelTank;
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
    public function shift_up()
    {
        if ($this->gearShift != 3)
        {
            $this->gearShift++;
            return true;
        }
        return false;
    }
    public function fill_up_the_tank()
    {
        $this->gearShift = 0;
        $this->fuelTank->fill_fuelTank();
    }
    public function get_storedFuel()
    {
        return $this->fuelTank->get_storedFuel();
    }
    public function set_storedFuel($newValue)
    {
        $this->fuelTank->set_storedFuel($newValue);
    }
    public function out_of_fuel()
    {
        $this->set_gearShift(0);
        $this->fuelTank->set_storedFuel(0);
    }
}