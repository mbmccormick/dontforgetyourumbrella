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
        try
        {
            $diff = 8 - (int)$row[timezone];
        
            $now = date("Y-m-d H:i:s");
            $nowlcl = date("Y-m-d H:i:s", strtotime("+" . $diff . " hour", strtotime($now)));
            
            $due = date("Y-m-d H:i:s", strtotime(date("Y-m-d") . "0" . $row[time] . ":00:00"));
            
            echo date("Y-m-d H:i:s", strtotime("-5 minute", strtotime($nowlcl))) . " < " . $due . " < " . date("Y-m-d H:i:s", strtotime("+5 minute", strtotime($nowlcl))) . "<br />\n";
            
            if (date("Y-m-d H:i:s", strtotime("-5 minute", strtotime($nowlcl))) < $due && $due < date("Y-m-d H:i:s", strtotime("+5 minute", strtotime($nowlcl))))
            {
                echo "Sending text message to " . $row[phonenumber] . ".<br />\n";
                
                $wunderapi = simplexml_load_file("http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=" . $row[zipcode]);
                $pop = $wunderapi->simpleforecast->forecastday[0]->pop;
                $cond = $wunderapi->simpleforecast->forecastday[0]->conditions;
                $high = $wunderapi->simpleforecast->forecastday[0]->high->fahrenheit;
                
                if ($pop >= $Threshold &&
                    strpos(strtolower($cond), "snow") === false &&
                    strpos(strtolower($cond), "flurries") === false)
                {
                    $zipcode = $row[zipcode];
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
                    $message = $prefix . " " . strtolower($cond) . " with a high of " . $high . "F today in " . $city . ", " . $state . ". Bring your umbrella!";

                    $client = new TwilioRestClient($AccountSid, $AuthToken);

                    $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
                        "POST", array(
                        "To" => $row['phonenumber'],
                        "From" => $PhoneNumber,
                        "Body" => $message
                    ));
                }
            }
        }
        catch (Exception $ex)
        {
            echo "Failed due to " . $ex . "<br />\n";
        }
        
        echo "<br />\n";
    }
    
?>
