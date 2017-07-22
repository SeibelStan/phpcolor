<?php

function getRgb($file) {
    $im = ImageCreateFromJPEG($file);
    
    $totalR = 0;
    $totalG = 0;
    $totalB = 0;
   
    $width = ImageSX($im);
    $height = ImageSY($im);
    
    for ($x = 0; $x < $width; $x++) {
         for ($y = 0; $y < $height; $y++) {
            $rgb = ImageColorAt($im, $x, $y);
            $totalR += ($rgb >> 16) & 0xFF;
            $totalG += ($rgb >> 8) & 0xFF;
            $totalB += $rgb & 0xFF;
        }
    }   
    ImageDestroy($im);   

    return [
        round($totalR / $width / $height),
        round($totalG / $width / $height),
        round($totalB / $width / $height)
    ];
}

function rgbToHsv($data) {
    $R = ($data[0] / 255);
    $G = ($data[1] / 255);
    $B = ($data[2] / 255);
    
    $maxRGB = max(array($R, $G, $B));
    $minRGB = min(array($R, $G, $B));
    $delta = $maxRGB - $minRGB;
    
    // Цветовой тон
    if($delta != 0) {
        if($maxRGB == $R) {
            $h = (($G-$B) / $delta);
        }
        elseif($maxRGB == $G) {
            $h = 2+($B-$R) / $delta;
        }
        elseif($maxRGB == $B) {
            $h = 4+($R-$G) / $delta;
        }
        $hue = round($h*60);
        if($hue < 0) { $hue += 360; }
    }
    else {
        $hue = 0;
    }
    
    // Насыщенность
    if($maxRGB != 0) {
        $saturation = round($delta / $maxRGB*100);
    }
    else {
        $saturation = 0;
    }
    
    // Яркость
    $value = round($maxRGB * 100);

    return [
        $hue,
        $saturation,
        $value
    ];
}

function getClearColor($data) {
    $hue = $data[2];
    $saturation = $data[1];
    $value = $data[2];

    if($value < 30) {
        $color = '#000000';
    }
    elseif($value > 85 && $saturation < 15) {
        $color = '#FFFFFF';
    }
    elseif($saturation < 25) {
        $color = '#909090';
    }
    else {
        if($hue > 320 || $hue <= 40) {
            $color = '#FF0000';
        }
        elseif($hue > 260 && $hue <= 320) {
            $color = '#FF00FF';
        }
        elseif($hue > 190 && $hue <= 260) {
            $color = '#0000FF';
        }
        elseif($hue > 175 && $hue <= 190) {
            $color = '#00FFFF';
        }
        elseif($hue > 70 && $hue <= 175) {
            $color = '#00FF00';
        }
        else {
            $color = '#FFFF00';
        }
    }

    return $color;
}