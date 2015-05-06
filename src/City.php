<?php

class City {
    private $x;
    private $y;
    
    public function __construct($x = null, $y = null) {
        if(is_null($x)) { $x = rand(0, 200); }
        if(is_null($y)) { $y = rand(0, 200); }
        $this->x = $x;
        $this->y = $y;
    }
    
    public function getX() {
        return $this->x;
    }
    
    public function getY() {
        return $this->y;
    }
    
    public function distanceTo(City $city) {
        $xDistance = abs($this->getX() - $city->getX());
        $yDistance = abs($this->getY() - $city->getY());
        return sqrt( ($xDistance * $xDistance) + ($yDistance * $yDistance) );
    }
    
    public function __toString(){
        return $this->getX() . ", " . $this->getY();
    }
}