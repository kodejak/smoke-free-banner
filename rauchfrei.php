<?php

/**
 *   Smoke free image banner generator.
 *   Copyright (C) 2015  Christian Handorf - kodejak at gmail dot com
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see http://www.gnu.org/licenses
 */

function secs_to_h($secs)
{
        $units = array(
                "Jahr"    => 12*30*24*3600,
                "Monat"   => 30*24*3600,
                "Tag"     => 24*3600,
                "Stunde"  => 3600,
                "Minute"  => 60,
        );
        
        $adds = array (
                "Jahr" => "e",
                "Monat"   => "e",
                "Tag"     => "e",
                "Stunde"  => "n",
                "Minute"  => "n",
        );

        if ( $secs == 0 ) return "0 seconds";

        $s = "";

        foreach ( $units as $name => $divisor ) {
                if ( $quot = intval($secs / $divisor) ) {
                        $s .= "$quot $name";
                        $s .= (abs($quot) > 1 ? $adds[$name] : "") . ", ";
                        $secs -= $quot * $divisor;
                }
        }

        return substr($s, 0, -2);
}

function secondsFromDate($dateStr) {
    $datefrom = strtotime($dateStr);
    $dateto = time();
    $seconds = $dateto - $datefrom;
    
    return $seconds;
}

       date_default_timezone_set('Europe/Berlin');
       
       // Add your smoke break date here:
       $sec = secondsFromDate('2014-10-29 09:45:00');
       $rauchdatum = strtotime('2014-10-29 09:45:00');
       
       $timestr = secs_to_h($sec);
       
       $days = $sec / 60 / 60 / 24;

       // Add your cigarettes per day here:
       $kippen = $days * 20;

       // Add your cigarettes per pack (19) and price per pack (5€) here
       $cash = ($kippen / 19) * 5;
       
       $kippen = number_format(floor($kippen), 0, ',', '.');
       $cash = number_format($cash, 2, ',', '.');
       
       $rauchdatumstr = date("d.m.Y", $rauchdatum); 

       $png_image = imagecreatefrompng('rauchfrei.png');
       
       $width = imagesx($png_image);
       $height = imagesy($png_image);
                    
       $black = ImageColorAllocate ($png_image, 0, 0, 0);
       
       // Use yout font here (must be found on your server)      
       $font = 'Raleway-Regular.ttf';
       
       // "Smoke free since"
       imagettftext($png_image, 10, 0, 80, 17, $black, $font, "Rauchfrei seit $rauchdatumstr:");
       imagettftext($png_image, 8, 0, 85, 32, $black, $font, $timestr);
       
       // "Cash saving:"
       imagettftext($png_image, 10, 0, 80, 50, $black, $font, "Ersparnis:");
       imagettftext($png_image, 8, 0, 85, 65, $black, $font, "$kippen Zigaretten / $cash Euro");

       header("Content-type: image/png");
       imagepng($png_image);
       
       imagedestory($png_image);     
       
?>
