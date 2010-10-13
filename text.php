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
        
        if (strlen($zipcode) == 0)
            $zipcode = "(zip)";
        
    ?>
	<form action='/submit.php' method='post'>
        <div class='form'>
		    A text message will be sent to <input name='phonenumber' type='text' class='cleardefault' style='width: 460px;' value='(phone)' /> 
		    at 
		    <select name='time'>
			    <option default='true'>(time)</option>
			    <option value='6'>6am</option>
			    <option value='7'>7am</option>
			    <option value='8'>8am</option>
			    <option value='9'>9am</option>
			    <option value='10'>10am</option>
		    </select>&nbsp;
		    <select name='timezone'>
			    <option default='true'>(zone)</option>
			    <option value='5'>est</option>
			    <option value='6'>cst</option>
			    <option value='7'>mst</option>
			    <option value='8'>pst</option>
		    </select> 
		    whenever you need an <span class='yes'>umbrella</span> in <input type='text' name='zipcode' value='<?php echo $zipcode; ?>' style='width: 240px;' class='cleardefault' />. 
		    <input type='submit' value='Submit' />
		</div>
    </form>
    <br />
    <br />
    <br />
    <h2><a href='/'>Click here to go back.</a></h2>
    <br />
    <br />
    <br />
    <p>Copyright &copy; 2010 <a style="text-decoration: none;" href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies LLC</a>. All rights reserved.</p>
</body>
</html>
