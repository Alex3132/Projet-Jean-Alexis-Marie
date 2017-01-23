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

    public function ___contruct($lat = null, $lon) {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public function setLat(int $lat) {
        $this->lat = $lat;
    }

    public function setLon(int $lon) {
        $this->lon = $lon;
    }
}