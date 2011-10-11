<?php

    require "config.php";
    require "lib/twilio.php";
    
    include("lib/geoipcity.inc");
    include("lib/geoipregionvars.php");
        
    $ip = $_SERVER["REMOTE_ADDR"];
    $geo = geoip_open("lib/GeoLiteCity.dat", GEOIP_STANDARD);

    $record = geoip_record_by_addr($geo, $ip);
    $city = $record->city;
    $state = $record->region;
    $zipcode = $record->postal_code;

    if($_GET[zipcode] != null)
    {
        $zipcode = $_GET[zipcode];
        $geocode = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=" . $zipcode);
        $city = $geocode->result->address_component[1]->long_name;
        for ($i = 2; $i < 6; $i++)
        {
            if ($geocode->result->address_component[$i]->type == "administrative_area_level_1")
            {
                $state = $geocode->result->address_component[$i]->short_name;
                break;
            }
        }
    }

    $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
    $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
    $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
    $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
    
    function textlink()
    {
        if ($_SERVER[QUERY_STRING] != null)
            echo "<br /><br /><h2><a href='text.php?$_SERVER[QUERY_STRING]'>Sign up for text message notifications.</a></h2><br />";
        else
            echo "<br /><br /><h2><a href='text.php'>Sign up for text message notifications.</a></h2><br />";
    }
    
    function backlink()
    {
        if ($_SERVER[QUERY_STRING] != null)
            echo "<br /><br /><h2><a href='index.php?$_SERVER[QUERY_STRING]'>Click here to go back.</a></h2><br />";
        else
            echo "<br /><br /><h2><a href='index.php'>Click here to go back.</a></h2><br />";
    }
    
    function error()
    {
        echo "<span class='forecast'>This isn't supposed to happen, but an error has occurred. </span>\n";
        echo "<span class='umbrella'>Bring your <span class='red'>umbrella</span> just in case.</span>\n";
    }
    
?>
