<?php
session_start() ;
$config_file = "../tvmonkey.config";
$z = file_exists($config_file) ;
if ( $z == 1 )
{
	#$comment = "#";
	$handle = @fopen($config_file, "r");
	if ($handle)
	{
		while (($buffer = fgets($handle, 4096)) !== false)
		{
			#if (!preg_match("$comment", $buffer))
			#{
				$pieces = explode("=", $buffer);
				$option = trim($pieces[0]);
				$value = trim($pieces[1]);
				$config_values[$option] = $value;
			#}
		}
	}
	if (!feof($handle)) 
	{
		echo "ERROR" ;
	}
}
	
$loc = $config_values[FLEXCONF] ;
$a = file_exists($loc) ;
$shows = $config_values[TVSHOWS] ;
$b = file_exists($shows) ;

if( $z == 0 )
{
	if( $b == 0 )
	{
		if( $a == 0 )
		{
			header("location:setup.php");
		}
	}
}

elseif(isset($_SESSION['myusername']))
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
            <li><a href="index.php">Home</a></li>
            <li><a href="config.php">Config</a></li>
            <li><a href="run.php">app</a></li>
            <li><a href="shows.php">shows</a></li>
            <li><a href="logout.php">logoff</a></li>
        </ul>
    </div>
    <div id="content">
		<div id="home" name="home1" >
			<p> Welcome to the TVMonkey Web Application </p>
			<strong>media volumes:</strong>
			<br />
			<?php
			
			echo "<pre><p>";
			
			$config_file = "../tvmonkey.config";
			#$comment = "#";
			$handle = fopen($config_file, "r");
			if ($handle)
			{
				while (($buffer = fgets($handle, 4096)) !== false)
				{
					#if (!preg_match("$comment", $buffer))
					#{
						$pieces = explode("=", $buffer);
						$option = trim($pieces[0]);
						$value = trim($pieces[1]);
						$config_values[$option] = $value;
					#}
				}
			}
			if (!feof($handle)) 
			{
				echo "ERROR" ;
			}
			
			$arr=array() ;
			
			$loc = $config_values[MED_LOC] ;
			$split = explode(",", $loc);
			foreach ( $split as $value)
			{
				$tv = exec("du -hs $value");
				$arr[] = exec("du -s $value | cut -f 1");
				echo "$tv<br />";
			}
			
			echo "";
			$x = array_sum($arr) ;
			$x = ($x/1024000) ;
			echo "<p>total = "; echo round($x) ; echo "G</p></pre>";
			echo "</p></pre>";
			
			$config_file = "../tvmonkey.config";
			#$comment = "#";
			$handle = fopen($config_file, "r");
			if ($handle)
			{
				while (($buffer = fgets($handle, 4096)) !== false)
				{
					#if (!preg_match("$comment", $buffer))
					#{
						$pieces = explode("=", $buffer);
						$option = trim($pieces[0]);
						$value = trim($pieces[1]);
						$config_values[$option] = $value;
					#}
				}
			}
			if (!feof($handle)) 
			{
				echo "ERROR" ;
			}
			fclose($handle);
			
			echo "<strong>shows we are watching for:</strong>";
			echo "<br />";
			echo "<pre><p>";
				$handle = fopen("../tvshows.config", "r");
				while (!feof($handle) ) 
				{
					$line = fgets($handle);
					$part = explode(':', $line);
					$sr = str_replace("."," ",$part[0]);
					print $sr . "<br />";
				}
				fclose($handle);
			echo "</p></pre>" ;	

			?>
		</div>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.html">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>
