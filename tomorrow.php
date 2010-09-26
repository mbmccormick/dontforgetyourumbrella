<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>dontforgetyourumbrella.com</title>
    <link rel="stylesheet" href="inc/stylesheet.css" />
    <script type="text/javascript" src="inc/util-functions.js"></script>
    <script type="text/javascript" src="inc/clear-default-text.js"></script>
<body>
    <?php
        
        include("service.php");
        
        $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $zipcode);
        $pop = $wunderapi->simpleforecast->forecastday[1]->pop;
        $cond = $wunderapi->simpleforecast->forecastday[1]->conditions;
        $high = $wunderapi->simpleforecast->forecastday[1]->high->fahrenheit;
            
        if ($pop != null)
        {
            if ($pop >= 40)
            {
                $prefix = "there will be";
                if (strpos(strtolower($cond), "chance") !== false)
                {
                    $prefix = "there is a";
                }
                else
                {
                    if (substr($cond, strlen($cond) - 1, 1) == "m")
                        $cond = $cond . "s";
                }
                echo "<h1><span class='light'>" . $prefix . " " . $cond . " with a high of " . $high . "&deg;F <a href='index.php'>tomorrow</a> in " . $city . ", " . $state . ".</span> ";
                echo "bring your <span class='fuscia'>umbrella</span>.</h1>\n";
            }
            else
            {
                $prefix = "it will be";
                if (strpos(strtolower($cond), "chance") !== false)
                {
                    $prefix = "there is a ";
                }
                if (strpos(strtolower($cond), "thunderstorm") !== false)
                {
                    $prefix = "there will be a ";
                }
                echo "<h1><span class='light'>" . $prefix . " " .  $cond . " with a high of " . $high . "&deg;F <a href='index.php'>tomorrow</a> in " . $city . ", " . $state . ".</span> ";
                echo "leave your <span class='fuscia'>umbrella</span> at home.</h1>\n";
            }	
            textlink();
        }
        else
        {
            error();
        }
        
    ?>
    <br />
    <br />
    <p>Copyright &copy; 2010 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies LLC</a>. All rights reserved.</p>
</body>
</html>
