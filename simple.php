<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Don't Forget Your Umbrella!</title>
    <script type="text/javascript" src="/inc/util-functions.js"></script>
    <script type="text/javascript" src="/inc/clear-default-text.js"></script>
    <style>
        body
        {
            font-family: courier new,"helvetica neue",arial,sans-serif;
            padding: 20px;
        }
        
        .wrapper
        {
            display: table-cell;
            left: 0;
            margin: auto;
            position: absolute;
            right: 0;
            text-align: center;
            top: 13%;
            vertical-align: middle;
        }
        
        .huge
        {
            font-size: 240px;
            letter-spacing: -15px;
            font-weight: bold;
            color: #000000;
            padding: 50px;
        }

        .forecast
        {
            text-transform: lowercase;
            font-size: 12px;
            font-weight: normal;
            color: #666666;
        }

        p
        {
            color: #cccccc;
            text-transform: lowercase;
            font-size: 12px;
        }

        p a
        {
            color: #cccccc;
        }       

    </style>
<body>
    <div class="wrapper">
    <?php
        
        include("service.php");
        
        echo "<div class='huge'>" . $pop . "%</div>";

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
                echo "<span class='forecast'>" . $prefix . " <b>" . strtolower($cond) . "</b> with a high of <b>" . $high . "</b>&deg;F today in <b>" . $city . ", " . $state . "</b></span>\n";
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
                echo "<span class='forecast'>" . $prefix . " <b>" . strtolower($cond) . "</b> with a high of <b>" . $high . "</b>&deg;F today in <b>" . $city . ", " . $state . "</b></span>\n";
            }
        }
        else
        {
            error();
        }
        
    ?>
    <br />
    <br />
    <p>&copy; 2011 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a></p>
    </div>
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
