<?php

    include("lib/geoipcity.inc");
    include("lib/geoipregionvars.php");
    require "lib/twilio.php";
        
    $ip = $_SERVER["REMOTE_ADDR"];
    $geo = geoip_open("/home/mattps/dontforgetyourumbrella.com/lib/GeoLiteCity.dat", GEOIP_STANDARD);

    $record = geoip_record_by_addr($geo, $ip);
    $city = $record->city;
    $state = $record->region;
    $zipcode = $record->postal_code;

    if($_GET[zipcode] != null)
    {
        $zipcode = $_GET[zipcode];
        $geocode = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=" . $zipcode);
        $city = $geocode->result->address_component[1]->long_name;
        if ($geocode->result->address_component[3]->type == "administrative_area_level_1")
            $state = $geocode->result->address_component[3]->short_name;
        else
            $state = $geocode->result->address_component[4]->short_name;
    }

    $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
    $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
    $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
    $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
    
    function success()
    {
        echo "<h1><span class='light'>Hooray. Your settings have been saved.</span> ";
        echo "You will receive a text message when you need your <span class='orange'>umbrella</span>.</h1>\n";
    }
    
    function textlink()
    {
        echo "<br /><br /><h2><a href='text.php'>Sign up for text message notifications.</a></h2><br />";
    }
    
    function error()
    {
        echo "<h1><span class='light'>This isn't supposed to happen, but an error has occurred.</span> ";
        echo "bring your <span class='red'>umbrella</span> just in case.</h1>\n";
    }
    
?>
