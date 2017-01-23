<?php

/**
 * Coord short summary.
 *
 * Coord description.
 *
 * @version 1.0
 * @author mamar
 */
class Coord
{
    private $lat;
    private $lon;

    /**
     * Default constructor
     * @param mixed $lat 
     * @param mixed $lon 
     */
    public function ___contruct($lat = null, $lon) {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * Set lat
     * @param int $lat 
     */
    public function setLat(int $lat) {
        $this->lat = $lat;
    }

    /**
     * Set lon
     * @param int $lon 
     */
    public function setLon(int $lon) {
        $this->lon = $lon;
    }

    /**
     * get lat
     * @return integer
     */
    public function getLat() : int {
        return $this->lat;
    }

    /**
     * get lon
     * @return integer
     */
    public function getLon() : int{
        return $this->lon;
    }
}