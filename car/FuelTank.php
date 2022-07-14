<?php

const CAPACITY = 60;

class FuelTank
{
    private $storedFuel;

    public function __construct()
    {
        $this->storedFuel = 30;
    }

    public function get_storedFuel()
    {
        return $this->storedFuel;
    }
    public function set_storedFuel($newValue)
    {
        $this->storedFuel = $newValue;
    }
    public function fill_fuelTank()
    {
        $this->storedFuel = CAPACITY;
    }
    public function use_fuel($usedFuel)
    {
        $this->set_storedFuel($this->get_storedFuel() - $usedFuel);
    }
}