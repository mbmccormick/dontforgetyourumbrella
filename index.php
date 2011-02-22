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
                if ($_SERVER[QUERY_STRING] != null)
                    echo "<span class='forecast'>" . $prefix . " <a title='Click here to view the probability of precipitation.' href='/probability?$_SERVER[QUERY_STRING]'>" . strtolower($cond) . "</a> with a high of " . $high . "&deg;F <a title='Click here to view the forecast for tomorrow.' href='/tomorrow?$_SERVER[QUERY_STRING]'>today</a> in " . $city . ", " . $state . ". </span>\n";
                else
                    echo "<span class='forecast'>" . $prefix . " <a title='Click here to view the probability of precipitation.' href='/probability'>" . strtolower($cond) . "</a> with a high of " . $high . "&deg;F <a title='Click here to view the forecast for tomorrow.' href='/tomorrow'>today</a> in " . $city . ", " . $state . ". </span>\n";
                echo "<span class='umbrella'>Bring your <span class='yes'>umbrella</span>. </span><br />\n";
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
                if ($_SERVER[QUERY_STRING] != null)
                    echo "<span class='forecast'>" . $prefix . " <a title='Click here to view the probability of precipitation.' href='/probability?$_SERVER[QUERY_STRING]'>" . strtolower($cond) . "</a> with a high of " . $high . "&deg;F <a title='Click here to view the forecast for tomorrow.' href='/tomorrow?$_SERVER[QUERY_STRING]'>today</a> in <a style='cursor: pointer;' onclick='changeLoc()' title='Click here to change your location.'>" . $city . ", " . $state . "</a>. </span>\n";
                else
                    echo "<span class='forecast'>" . $prefix . " <a title='Click here to view the probability of precipitation.' href='/probability'>" . strtolower($cond) . "</a> with a high of " . $high . "&deg;F <a title='Click here to view the forecast for tomorrow.' href='/tomorrow'>today</a> in <a style='cursor: pointer;' onclick='changeLoc()' title='Click here to change your location.'>" . $city . ", " . $state . "</a>. </span>\n";
                echo "<span class='umbrella'>Leave your <span class='no'>umbrella</span> at home. </span><br />\n";
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
    <p>&copy; 2011 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a></p>
    
    <script type="text/javascript">
    
        function changeLoc()
        {
            var zipcode = prompt("Please enter your zip code.");
            if (zipcode != null)
                location.href = "http://dontforgetyourumbrella.com/?zipcode=" + zipcode;
        }
    
    </script>
</body>
</html>
