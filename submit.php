<?php
    
    require "config.php";
    
    include("service.php");
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db("$Database", $con);        
    
    $now = date("Y-m-d H:i:s");
    
    $phone = str_replace("-", "", $_POST[phonenumber]);
    $phone = str_replace(".", "", $_POST[phonenumber]);
        
    $sql = "INSERT INTO notify (phonenumber, zipcode, time, timezone, createddate) VALUES
                ('" . $phone . "', '$_POST[zipcode]', '$_POST[time]', '$_POST[timezone]', '$now')";
    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    $client = new TwilioRestClient($AccountSid, $AuthToken);

    $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
        "POST", array(
        "To" => $_POST['phonenumber'],
        "From" => $PhoneNumber,
        "Body" => "This number is now signed up for notifications from http://dontforgetyourumbrella.com."
    ));
    
    if ($_SERVER[QUERY_STRING] != null)
        header("Location: success.php?$_SERVER[QUERY_STRING]");
    else
        header("Location: success.php");
    
    exit;   
    
?>
