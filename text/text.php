<?php

    require "../lib/twilio.php";
    require "../config.php";

    $client = new TwilioRestClient($AccountSid, $AuthToken);

    if (strpos(trim(strtolower($_POST[Body])), "f") == 0)
    {
        include("../service.php");

        if ($pop != null)
        {
            if ($pop >= 40)
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
                $message = $prefix . " " . strtolower($cond) . " with a high of " . $high . "°F today in " . $city . ", " . $state . ". Bring your umbrella.";
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
                $message = $prefix . " " . strtolower($cond) . " with a high of " . $high . "°F today in " . $city . ", " . $state . ". Leave your umbrella at home.";
            }
            
            // respond with forecast
            $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
                "POST", array(
                "To" => $_POST[From],
                "From" => $PhoneNumber,
                "Body" => $message
            ));  
        }
    }
    else if (strpos(trim(strtolower($_POST[Body])), "stop") !== false)
    {
        $con = mysql_connect($Server, $Username, $Password);
        if (!$con)
        {
            die("Could not connect: " . mysql_error());
        }

        mysql_select_db($Database, $con);
        
        $number1 = str_replace("+1", "", $_POST[From]);
        $number2 = $_POST[From];
        
        $sql = "DELETE FROM notify WHERE phonenumber = '$number1' OR phonenumber = '$number2')";
        
        mysql_close();
        
        // respond with confirmation
        $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
            "POST", array(
            "To" => $_POST[From],
            "From" => $PhoneNumber,
            "Body" => "You have been successfully unsubscribed."
        ));
    }
    else
    {
        // respond with invalid syntax
        $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
            "POST", array(
            "To" => $_POST[From],
            "From" => $PhoneNumber,
            "Body" => "Don't Forget Your Umbrella! For forecast, text 'f 90210'. To unsubscribe, text 'stop'. Visit us at http://dontforgetyourumbrella.com."
        ));
    }
    
?>
