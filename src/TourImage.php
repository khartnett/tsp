<?php

class TourImage extends Tour {
    
    public function drawTourDots($image, $color, $offset = 0, $thick = true) {
        for ($i = 0; $i < $this->tourSize(); $i++) {
            $currentCity = $this->getCity($i);
            imagesetpixel(
                $image,
                $currentCity->getX() + $offset,
                $currentCity->getY(),
                $color
            );
            if ($thick) {
                imagesetpixel(
                    $image,
                    $currentCity->getX() + $offset + 1,
                    $currentCity->getY(),
                    $color
                );
                imagesetpixel(
                    $image,
                    $currentCity->getX() + $offset,
                    $currentCity->getY() + 1,
                    $color
                );
                imagesetpixel(
                    $image,
                    $currentCity->getX() + $offset - 1,
                    $currentCity->getY(),
                    $color
                );
                imagesetpixel(
                    $image,
                    $currentCity->getX() + $offset,
                    $currentCity->getY() - 1,
                    $color
                );
            }
        }
    }
    
    public function drawTour($image, $color, $offset = 0) {
        $lastCity = $this->getCity($this->tourSize() - 1);
        for ($i = 0; $i < $this->tourSize(); $i++) {
            $currentCity = $this->getCity($i);
            imageline(
                $image,
                $lastCity->getX() + $offset,
                $lastCity->getY(),
                $currentCity->getX() + $offset,
                $currentCity->getY(),
                $color);
            $lastCity = $currentCity;
        }
    }
}
