<?php

    require "config.php";
    require "lib/twilio.php";
    
    include("lib/geoipcity.inc");
    include("lib/geoipregionvars.php");
        
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
        if ($geocode->result->address_component[2]->type == "administrative_area_level_1")
            $state = $geocode->result->address_component[2]->short_name;
        else if ($geocode->result->address_component[3]->type == "administrative_area_level_1")
            $state = $geocode->result->address_component[3]->short_name;
        else if ($geocode->result->address_component[4]->type == "administrative_area_level_1")
            $state = $geocode->result->address_component[4]->short_name;
        else if ($geocode->result->address_component[5]->type == "administrative_area_level_1")
            $state = $geocode->result->address_component[5]->short_name;
    }

    $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
    $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
    $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
    $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
    
    function textlink()
    {
        if ($_SERVER[QUERY_STRING] != null)
            echo "<br /><br /><h2><a href='/text?$_SERVER[QUERY_STRING]'>Sign up for text message notifications.</a></h2><br />";
        else
            echo "<br /><br /><h2><a href='/text'>Sign up for text message notifications.</a></h2><br />";
    }
    
    function backlink()
    {
        if ($_SERVER[QUERY_STRING] != null)
            echo "<br /><br /><h2><a href='/?$_SERVER[QUERY_STRING]'>Click here to go back.</a></h2><br />";
        else
            echo "<br /><br /><h2><a href='/'>Click here to go back.</a></h2><br />";
    }
    
    function error()
    {
        echo "<span class='forecast'>This isn't supposed to happen, but an error has occurred. </span>\n";
        echo "<span class='umbrella'>Bring your <span class='red'>umbrella</span> just in case.</span>\n";
    }
    
?>
