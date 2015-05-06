<?php

class SimulatedAnnealing {
    // Calculate the acceptance probability
    public static function acceptanceProbability($energy, $newEnergy, $temperature) {
        // If the new solution is better, accept it
        if ($newEnergy < $energy) {
            return 1.0;
        }
        // If the new solution is worse, calculate an acceptance probability
        return exp(($energy - $newEnergy) / $temperature);
    }

    public static function main() {
header ('Content-Type: image/png');
$im = @imagecreatetruecolor(800, 200)
      or die('Cannot Initialize new GD image stream');
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  'derp', $text_color);
$color = imagecolorallocate($im, 255, 255, 255);
        // Create and add our cities
//        TourManager::addCity(new City(60, 200));
//        TourManager::addCity(new City(180, 200));
//        TourManager::addCity(new City(80, 180));
//        TourManager::addCity(new City(140, 180));
//        TourManager::addCity(new City(20, 160));
//        TourManager::addCity(new City(100, 160));
//        TourManager::addCity(new City(200, 160));
//        TourManager::addCity(new City(140, 140));
//        TourManager::addCity(new City(40, 120));
//        TourManager::addCity(new City(100, 120));
//        TourManager::addCity(new City(180, 100));
//        TourManager::addCity(new City(60, 80));
//        TourManager::addCity(new City(120, 80));
//        TourManager::addCity(new City(180, 60));
//        TourManager::addCity(new City(20, 40));
//        TourManager::addCity(new City(100, 40));
//        TourManager::addCity(new City(200, 40));
//        TourManager::addCity(new City(20, 20));
//        TourManager::addCity(new City(60, 20));
//        TourManager::addCity(new City(160, 20));
        
        
//        TourManager::addCity(new City(20, 160));
//        TourManager::addCity(new City(20, 20));
//        TourManager::addCity(new City(20, 40));
//        TourManager::addCity(new City(40, 120));
//        TourManager::addCity(new City(60, 20));
//        TourManager::addCity(new City(60, 200));
//        TourManager::addCity(new City(60, 80));
//        TourManager::addCity(new City(80, 180));
//        TourManager::addCity(new City(100, 120));
//        TourManager::addCity(new City(100, 160));
//        TourManager::addCity(new City(100, 40));
//        TourManager::addCity(new City(120, 80));
//        TourManager::addCity(new City(140, 140));
//        TourManager::addCity(new City(140, 180));
//        TourManager::addCity(new City(160, 20));
//        TourManager::addCity(new City(180, 100));
//        TourManager::addCity(new City(180, 200));
//        TourManager::addCity(new City(180, 60));
//        TourManager::addCity(new City(200, 160));
//        TourManager::addCity(new City(200, 40));
        
        for ($i = 0; $i < 50; $i++) {
            TourManager::addCity(new City());
        }

        // Set initial temp
        $temp = 1000;

        // Cooling rate
        $coolingRate = 0.003;

        // Initialize intial solution
        $currentSolution = new Tour();
        $currentSolution->generateIndividual();
        
        //echo("Initial solution distance: " . $currentSolution->getDistance() . "\n");

        // Set as current best
        $best = new Tour($currentSolution->getTour());
        $best->drawTour($im, $color);
        // Loop until system has cooled
        while ($temp > 1) {
            // Create new neighbour tour
            $newSolution = new Tour($currentSolution->getTour());

            // Get a random positions in the tour
            $maxIndex = $newSolution->tourSize() - 1;
            $tourPos1 = mt_rand(0, $maxIndex);
            //$tourPos2 = ($tourPos1 === $maxIndex)? 0 : $tourPos1 + 1;
            $tourPos2 = mt_rand(0, $maxIndex);

            // Get the cities at selected positions in the tour
            $citySwap1 = $newSolution->getCity($tourPos1);
            $citySwap2 = $newSolution->getCity($tourPos2);

            // Swap them
            $newSolution->setCity($tourPos2, $citySwap1);
            $newSolution->setCity($tourPos1, $citySwap2);
            
            // Get energy of solutions
            $currentEnergy = $currentSolution->getDistance();
            $neighbourEnergy = $newSolution->getDistance();

            // Decide if we should accept the neighbour
            if (self::acceptanceProbability($currentEnergy, $neighbourEnergy, $temp) > (rand(0,1000) / 1000)) {
                $currentSolution = new Tour($newSolution->getTour());
            }

            // Keep track of the best solution found
            if ($currentSolution->getDistance() 
                    < $best->getDistance()) {
                $best = new Tour($currentSolution->getTour());
            }
            
            // Cool system
            $temp *= 1-$coolingRate;
        }

//imageline($im, 20 , 30, 140, 170, $color);
$best->drawTour($im, $color, 200);
imagepng($im);
imagedestroy($im);
        //echo("Final solution distance: " . $best->getDistance() . "\n");
        //echo("Tour: " . $best . "\n");
    }
}
