<?php
    
    require "lib/twilio.php";
    require "config.php";

    $con = mysql_connect("$Server", "$Username", $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db("$Database", $con);
    
    $result = mysql_query("SELECT * FROM notify");
    
    while($row = mysql_fetch_array($result))
    {
        $diff = 8 - (int)$row[timezone];
        
        $now = date("Y-m-d H:i:s");
        $nowlcl = date("Y-m-d H:i:s", strtotime("+" . $diff . " hour", strtotime($now)));
        
        $due = date("Y-m-d H:i:s", strtotime(date("Y-m-d") . "0" . $row[time] . ":00:00"));
        
        echo date("Y-m-d H:i:s", strtotime("-5 minute", strtotime($nowlcl))) . " < " . $due . " < " . date("Y-m-d H:i:s", strtotime("+5 minute", strtotime($nowlcl))) . "<br />\n";
        
        if (date($nowlcl, "-5 minutes") < $due && $due < date($nowlcl, "+5 minutes"))
        {
            $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $row[zipcode]);
            $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
            $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
            $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
            
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

            if ($pop >= $Threshold)
            {
                $client = new TwilioRestClient($AccountSid, $AuthToken);

                $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
                    "POST", array(
                    "To" => $row['phonenumber'],
                    "From" => $PhoneNumber,
                    "Body" => $prefix . " " . $cond . " with a high of " . $high . " °F today. Bring your umbrella."
                ));
            }
        }
    }
    
?>
