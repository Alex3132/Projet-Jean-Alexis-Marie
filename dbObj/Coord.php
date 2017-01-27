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
    public $lat;
    public $lon;

    /**
     * Default constructor
     * @param mixed $lat
     * @param mixed $lon
     */
    public function __construct($lat = null, $lon) {
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
    public function getLat() {
        return $this->lat;
    }

    /**
     * get lon
     * @return integer
     */
    public function getLon() {
        return $this->lon;
    }
}