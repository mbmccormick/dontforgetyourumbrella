<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>dontforgetyourumbrella.com</title>
    <link rel="stylesheet" href="/inc/stylesheet.css" />
    <script type="text/javascript" src="/inc/util-functions.js"></script>
    <script type="text/javascript" src="/inc/clear-default-text.js"></script>
<body>
    <?php
        
        include("service.php");
        
        if ($pop != null)
        {
            echo "<h1><span class='light'>there is a " . $pop . "% chance of <a href='/'>precipitation</a> today in " . $city . ", " . $state . ".</span> ";
            if ($pop >= 40)
            {
                echo "bring your <span class='purple'>umbrella</span>.</h1>\n";
            }
            else
            {
                echo "leave your <span class='purple'>umbrella</span> at home.</h1>\n";
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
