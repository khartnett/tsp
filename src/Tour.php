<?php

class Tour {
    // Holds our tour of cities
    private $tour = array();
    // Cache
    private $distance = 0;
    
    // Constructs a tour from another tour
    public function __construct($tour = array()) {
        $this->tour = $tour;
    }
    
    // Returns tour information
    public function getTour() {
        return $this->tour;
    }
    
    // Creates a random individual
    public function generateIndividual() {
        // Loop through all our destination cities and add them to our tour
        for ($cityIndex = 0; $cityIndex < TourManager::numberOfCities(); $cityIndex++) {
          $this->setCity($cityIndex, TourManager::getCity($cityIndex));
        }
        // Randomly reorder the tour
        //shuffle($this->tour);
    }

    // Gets a city from the tour
    public function getCity($tourPosition) {
        return $this->tour[$tourPosition];
    }

    // Sets a city in a certain position within a tour
    public function setCity($tourPosition, City $city) {
        $this->tour[$tourPosition] = $city;
        // If the tours been altered we need to reset the fitness and distance
        $this->distance = 0;
    }
    
    // Gets the total distance of the tour
    public function getDistance() {
        if ($this->distance == 0) {
            $tourDistance = 0;
            // Loop through our tour's cities
            for ($cityIndex=0; $cityIndex < $this->tourSize(); $cityIndex++) {
                // Get city we're traveling from
                $fromCity = $this->getCity($cityIndex);
                // Check we're not on our tour's last city, if we are set our 
                // tour's final destination city to our starting city
                if($cityIndex+1 < $this->tourSize()){
                    $destinationCity = $this->getCity($cityIndex+1);
                }
                else{
                    $destinationCity = $this->getCity(0);
                }
                // Get the distance between the two cities
                $tourDistance += $fromCity->distanceTo($destinationCity);
            }
            $this->distance = $tourDistance;
        }
        return $this->distance;
    }

    // Get number of cities on our tour
    public function tourSize() {
        return count($this->tour);
    }
    
    public function __toString() {
        $geneString = "|";
        for ($i = 0; $i < $this->tourSize(); $i++) {
            $geneString .= $this->getCity($i) . "|";
        }
        return $geneString;
    }
}
