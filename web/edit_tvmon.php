<?php
session_start() ;
if(isset($_SESSION['myusername']))
	{

	}
else
	{
		header("location:main_login.php");
	}
?>
<script>
function showonlyone(thechosenone) {
     $('div[name|="newboxes"]').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).show(200);
          }
          else {
               $(this).hide(600);
          }
     });
}
</script>
<html>
<head>
 <title>TVMonkey Web Interface</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="logo">
        <h1><span class="blue">TV</span>Monkey</h1>
    </div>
    <!--<div id="search">
        <form method="post" action="#">
            <input type="text" value="" size="15" />
            <button>search</button>
        </form>
	</div>-->
	<div class="br"></div>
    <div id="navlist">
        <ul>
            <li><a id="link1home" href="./index.php">Home</a></li>
            <li><a href="config.php">Config</a></li>
            <li><a href="run.php">app</a></li>
            <!--<li><a href="#">Link</a></li> -->
            <!--<li><a href="#">Link</a></li> -->
        </ul>
    </div>
    <div id="content">
		<br />
        <?php 
		// set file to read 
		$filename = "../tvmonkey.config"; 

		$newdata = $_POST['newd']; 
		
		if(isset($_POST['submit1']))
		{
			header("location:config.php");
		}
			
		if ($newdata != '') 
		{  
			$fw = fopen($filename, 'w') or die('Insufficent permissions to open file with write access!'); 
			$fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file'); 
			fclose($fw);
			$command= 'fromdos ../tvmonkey.config' ;
			system($command);
		}

		$fh = fopen($filename, "r") or die("Could not open file!"); 
		$data = fread($fh, filesize($filename)) or die("Could not read file!"); 
		fclose($fh); 
		echo "<h3>Contents of File</h3> ";
		if(isset($newdata))
		{
			echo "<p>";
			echo "Changes saved successfully";
			echo "</p>";
		}
		echo "<form method=\"post\" action=\"$_SERVER[php_self]\">";
		echo "<input type=\"submit\" value=\"Change\"> ";	
		echo "<input type=\"hidden\" name=\"cancel\" value=\"cancel\">";
		echo "<input type=\"submit\" name=\"submit1\"value=\"Cancel/Done\">";
		echo "<textarea name='newd' cols='100%' rows='50'>$data</textarea> ";
		echo "<input type='submit' value='Change'> ";
		echo "<input type=\"hidden\" name=\"cancel\" value=\"cancel\">";
		echo "<input type=\"submit\" name=\"submit1\"value=\"Cancel/Done\">";		
		echo "</form>"; 

		?>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.php">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>
