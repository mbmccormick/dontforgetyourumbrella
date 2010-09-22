<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>dontforgetyourumbrella.com</title>
    <style>
        body
        {
            font-family: helvetica;
            padding: 20px;
            text-transform: uppercase;
        }

        h1
        {
            font-size: 80px;
            padding: 0px;
            margin: 0px;
        }
        
        a
        {
            text-decoration: none;
            color: #cccccc;
        }

        #main
        {
        }

        .blue
        {
            color: #248eff;
        }

        .yellow
        {
            color: #f5db1b;
        }
        
        .light
        {
            color: #cccccc;
        }
    </style>
<body>
<div id="main">
<?php
    
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
        $state = $geocode->result->address_component[3]->short_name;
    }

    $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
    $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
    $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
    $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
    
    echo "<h1><span class='light'>there is a " . $pop . "% chance of <a href='index.php'>precipitation</a> today in " . $city . ", " . $state . ".</span> ";
    if ($pop >= 50)
    {
        echo "bring your <span class='blue'>umbrella</span>.</h1>\n";
    }
    else
    {
        echo "leave your <span class='yellow'>umbrella</span> at home.</h1>\n";
    }		

?>
<br />
<br />
<p>Copyright &copy; 2010 <a style="color: #000000; text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies LLC</a>. All rights reserved.</p>
</div>
</body>
</html>
