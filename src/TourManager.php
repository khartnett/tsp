<?php

class TourManager {
    // Holds our cities
    private static $destinationCities = array();

    // Adds a destination city
    public static function addCity(City $city) {
        self::$destinationCities[] = $city;
    }
    
    // Get a city
    public static function getCity($index){
        return self::$destinationCities[$index];
    }
    
    // Get the number of destination cities
    public static function numberOfCities(){
        return count(self::$destinationCities);
    }
}
