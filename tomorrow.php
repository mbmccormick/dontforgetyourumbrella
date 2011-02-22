<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Don't Forget Your Umbrella!</title>
    <link rel="stylesheet" href="/inc/stylesheet.css" />
    <script type="text/javascript" src="/inc/util-functions.js"></script>
    <script type="text/javascript" src="/inc/clear-default-text.js"></script>
<body>
    <?php
        
        include("service.php");
        
        $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
        $pop = $wunderapi->simpleforecast->forecastday[1]->pop;
        $cond = $wunderapi->simpleforecast->forecastday[1]->conditions;
        $high = $wunderapi->simpleforecast->forecastday[1]->high->fahrenheit;
            
        if ($pop != null)
        {
            if ($pop >= $Threshold)
            {
                $prefix = "There will be";
                if (strpos(strtolower($cond), "chance") !== false)
                {
                    $prefix = "There is a";
                }
                else
                {
                    if (substr($cond, strlen($cond) - 1, 1) == "m")
                        $cond = $cond . "s";
                }
                echo "<span class='forecast'>" . $prefix . " " . strtolower($cond) . " with a high of " . $high . "&deg;F tomorrow in " . $city . ", " . $state . ". </span>";
                echo "<span class='umbrella'>Bring your <span class='yes'>umbrella</span>.</span><br />\n";
            }
            else
            {
                $prefix = "It will be";
                if (strpos(strtolower($cond), "chance") !== false)
                {
                    $prefix = "There is a ";
                }
                if (strpos(strtolower($cond), "thunderstorm") !== false)
                {
                    $prefix = "There will be a ";
                }
                echo "<span class='forecast'>" . $prefix . " " .  strtolower($cond) . " with a high of " . $high . "&deg;F tomorrow in " . $city . ", " . $state . ". </span>";
                echo "<span class='umbrella'>Leave your <span class='no'>umbrella</span> at home.</span><br />\n";
            }	
            
            backlink();
        }
        else
        {
            error();
        }
        
    ?>
    <br />
    <br />
    <p>&copy; 2011 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a></p>
</body>
</html>
