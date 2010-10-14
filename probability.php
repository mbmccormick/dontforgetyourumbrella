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
            echo "<span class='forecast'>There is a " . $pop . "% chance of precipitation today in " . $city . ", " . $state . ". </span>";
            if ($pop >= 40)
            {
                echo "<span class='umbrella'>Bring your <span class='yes'>umbrella</span>.</span><br />\n";
            }
            else
            {
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
    <p>Copyright &copy; 2010 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies LLC</a>. All rights reserved.</p>
</body>
</html>
