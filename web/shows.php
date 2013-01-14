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
    <!--</div>
    <div id="search">
        <form method="post" action="#">
            <input type="submit" name="submit" value="logoff">
        </form>
	</div>-->
	<div class="br"></div>
    <div id="navlist">
        <ul>
            <li><a id="link1home" href="./index.php">home</a></li>
            <li><a href="config.php">config</a></li>
            <li><a href="run.php">app</a></li>
            <li><a href="shows.php">shows</a></li>
            <li><a href="logout.php">logoff</a></li>
        </ul>
    </div>
    <div id="content">
		<table >
		<form method="post" action="<?php  echo $_SERVER['PHP_SELF']; ?>">
			<tr>
				</td>
				<td align="center">
					<input type="hidden" name="series" value="run">
					<input type="submit" name="submit7" value="series info">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="shows" value="run">
					<input type="submit" name="submit8" value="shows config file">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="shows" value="run">
					<input type="submit" name="submit9" value="add show">
				</td>
			</tr>	
		</form>
		</table>
	<br />
	<?php

	if(!isset($_POST['submit7']))
	{	
		if(!isset($_POST['submit8']))
		{	
			if(!isset($_POST['submit9']))
			{	
				echo "<p> This is the shows page of TVMonkey. You can use this page to view and add shows to TVMonkey. 
				<br />
				<br />
				";
			}
		}
	}
	
	if(isset($_POST['submit7']))
	{
	
		echo "<pre><p>";
		ob_implicit_flush(true);
		ob_end_flush();
		$command = '../check_series.sh';
		system($command);
		echo "</p></pre>" ;
				
		echo "<p>";
		echo "Select a show for detailed information about it:";
		echo "<table style= \"line-height: 1.4em; 
    							font-size: 0.7em; 
    							margin-bottom: 20px; 
    							color: #f4f4f4;\">";
		$handle = fopen("../tvshows.config", "r");
		while (!feof($handle) ) 
		{
			$line = fgets($handle);
			$part = explode(':', $line);
			$sr = str_replace("."," ",$part[0]);
			echo "<form method=\"get\" action=\"series_details.php\">";
			if (strlen($sr) >= 3 )
			{
				echo "<tr><td>$sr</td><td><input type=\"hidden\" name=\"show\" value=\"$sr\"><input type=\"submit\" name=\"select\" value=\"show info\"></td></tr>";
			}
			echo "</form>";
		}
		fclose($handle);
		echo "</table>";
		echo "</p>";
	}
	
	if(isset($_POST['submit8']))
	{
		if (isset($_POST['shows']))
		{
			echo "<pre><p>" ;
			$file = file_get_contents("../tvshows.config");
			print $file;
			echo "</p></pre>" ;
			echo "<form method=\"post\" action=\"edit_shows.php\">";
			echo "<input type=\"hidden\" name=\"edit\" value=\"run\">";
			echo "<input type=\"submit\" name=\"edshow\" value=\"edit\">";
			echo "</form>";
		}
	}	
			
	if(isset($_POST['submit9']))
	{
		header("location:add_show.php");
	}	
	?>
	</div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.php">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>