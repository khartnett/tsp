<?php

class TravelingSalesman {

    public static function main() {
        srand(654332);
        self::addCities();

        // Initialize intial solution
        $currentSolution = new TourImage();
        $currentSolution->generateIndividual();

        // Set as current best
        $best = new TourImage($currentSolution->getTour());
        
        $startTour = clone $best;
        
        $timeStart = microtime(true);
        $best = self::optimizeTwoOp($best);
        
        $timeEnd = microtime(true);
        $time = $timeEnd - $timeStart;
        
        self::draw($startTour, $best, $time);
    }
    
    protected static function addCities() {
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
    }
    
    protected static function draw($startTour, $endTour, $time) {
        header ('Content-Type: image/png');
        $im = @imagecreatetruecolor(600, 200)
            or die('Cannot Initialize new GD image stream');
        $text_color = imagecolorallocate($im, 233, 14, 91);
        $dot_color = imagecolorallocate($im, 150, 150, 255);
        $color = imagecolorallocate($im, 255, 255, 255);

        $startTour->drawTourDots($im, $dot_color);
        $startTour->drawTourDots($im, $dot_color, 200);
        $startTour->drawTourDots($im, $dot_color, 400);
        $startTour->drawTour($im, $color, 200);
        
        imagestring($im, 1, 5, 5,  'time: ' . $time, $text_color);
        $endTour->drawTour($im, $color, 400);
        imagepng($im);
        imagedestroy($im);
    }


    public static function optimizeTwoOp(Tour $tour) {
        $tourSize = $tour->tourSize();
        $best = 0;
        $bestSwap = array();
        // TODO: change for statements to tourSize minus 1 for A to Z trips
        for ($tourPosA = 0; $tourPosA < $tourSize; $tourPosA++) {
            $tourPosB = ($tourPosA + 1) % $tourSize;
            for ($tourPosC = 0; $tourPosC < $tourSize; $tourPosC++) {
                $tourPosD = ($tourPosC + 1) % $tourSize;
                
                if ($tourPosA === $tourPosC) {
                    continue;
                }
                
                // Get the cities at selected positions in the tour
                $cityA = $tour->getCity($tourPosA);
                $cityB = $tour->getCity($tourPosB);
                $cityC = $tour->getCity($tourPosC);
                $cityD = $tour->getCity($tourPosD);

                $distanceAB = $cityA->distanceTo($cityB);
                $distanceCD = $cityC->distanceTo($cityD);
                $distanceAC = $cityA->distanceTo($cityC);
                $distanceBD = $cityB->distanceTo($cityD);

                $gain = ($distanceAB + $distanceCD) - ($distanceAC + $distanceBD);
                if ($gain > $best) {
                    $best = $gain;
                    $bestSwap = array($tourPosA, $tourPosB, $tourPosC, $tourPosD);
                }
            }
        }
        if ($bestSwap) {
            $iA = $bestSwap[0];
            $iB = $bestSwap[1];
            $iC = $bestSwap[2];
            $iD = $bestSwap[3];

            $newSolution = new TourImage();
            $i = 0;
            if (true) { //maintain first city
                if ($iA < $iC) {
                    // add cities starting at 0 until you reach A
                    while ($i <= $iA) {
                        $newSolution->setCity($i, $tour->getCity($iC));
                        $i++;
                    }
                    // add C and decrement until you reach B
                    // add D and increment until you reach tour size
                } else {
                    // add cities startint at 0 until you reach C
                    // add A and decrement until you reach D
                    // add B and increment until tour size
                }
                unset($tour);
                return self::optimizeTwoOp($newSolution);
            }
            
            $newSolution->setCity($i, $tour->getCity($iA));
            $i++;
            while ($iC != $iB) {
                $newSolution->setCity($i, $tour->getCity($iC));
                $i++;
                $iC = ($iC-1) % $tourSize;
            }
            $newSolution->setCity($i, $tour->getCity($iB));
            $i++;
            while ($iD != $iA) {
                $newSolution->setCity($i, $tour->getCity($iD));
                $i++;
                $iD = ($iD+1) % $tourSize;
            }
            unset($tour);
            return self::optimizeTwoOp($newSolution);
        }
        return $tour;
    }
}
