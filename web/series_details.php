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
            <li><a id="link1home" href="./index.php">Home</a></li>
            <li><a href="config.php">Config</a></li>
            <li><a href="run.php">app</a></li>
            <li><a href="shows.php">shows</a></li>
            <li><a href="logout.php">logoff</a></li>
        </ul>
    </div>
    <div id="content">
        <h3>TVMonkey</h3>
		<table>
		<form method="post" action="config.php">
<tr>
				<td align="center">
					<input type="hidden" name="vermon" value="run">
					<input type="submit" name="submit1" value="TVMonkey version">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="flexcon" value="run">
					<input type="submit" name="submit2" value="Flexget config file">
				</td>
				<td align="center"> | 
				</td>				
				<td align="center">
					<input type="hidden" name="tvmon" value="run">
					<input type="submit" name="submit3" value="TVMonkey config file">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="check" value="run">
					<input type="submit" name="submit6" value="check system config">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="series" value="run">
					<input type="submit" name="submit7" value="check series information">
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="hidden" name="shows" value="run">
					<input type="submit" name="submit8" value="TV shows config file">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="shows" value="run">
					<input type="submit" name="submit9" value="add show">
				</td>
				<td align="center"> | 
				</td>
			</tr>

		</form>
		<table>
		<br />
		<?php
		
		$config_file = "../tvmonkey.config";
		$comment = "#";
		$handle = fopen($config_file, "r");
		if ($handle)
		{
			while (($buffer = fgets($handle, 4096)) !== false)
			{
				if (!preg_match("$comment", $buffer))
				{
					$pieces = explode("=", $buffer);
					$option = trim($pieces[0]);
					$value = trim($pieces[1]);
					$config_values[$option] = $value;
				}
			}
		}
		if (!feof($handle)) 
		{
			echo "ERROR" ;
		}
		fclose($handle);
			
		$flexconf = "$config_values[FLEXCONF]" ;
		$show = $_GET['show'] ;
		echo "<p>Receiving detailed show information for <b>$show</b>:</p>";
		echo "<pre><p>";
		ob_implicit_flush(true);
		ob_end_flush();
		system("flexget -c ".$flexconf." --series \"".$show."\"");
		echo "</p></pre>" ;
		
		?>

    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.php">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>
