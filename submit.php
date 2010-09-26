<?php
    
    include("service.php");
    require "config.php";
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db("$Database", $con);        
    
    $now = date("Y-m-d H:i:s");
        
    $sql = "INSERT INTO notify (phonenumber, zipcode, time, timezone, createddate) VALUES
                ('$_POST[phonenumber]', '$_POST[zipcode]', '$_POST[time]', '$_POST[timezone]', '$now')";
    
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
        "Body" => "This number is now signed up for reminders from http://dontforgetyourumbrella.com."
    ));
    
    header("Location: http://dontforgetyourumbrella.com/success.php");
    exit;   
    
?>
