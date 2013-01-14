<?php
error_reporting(E_ALL);
?>
<html>
<head>
 <title>TVMonkey Setup</title>
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
<!--       <ul>
            <li><a id="link1home" href="./index.php">Home</a></li>
            <li><a href="config.php">Config</a></li>
            <li><a href="run.php">app</a></li>
            <!--<li><a href="#">Link</a></li> -->
            <!--<li><a href="#">Link</a></li> 
-->
        </ul>
    </div>
    <div id="content">
	<?php
	
	if(isset($_POST['marker']))
	{
		$x = $_POST['marker'] ;
	}
	
	if(isset($_POST['another']))
	{
		$x = 2 ;
	}
	
	if(isset($_POST['done']))
	{
		$x = 6 ;
	}
	
	if(!isset($x))
	{
		echo "<p>Please fill in the form below to configure TVMonkey:</p>";
		echo "<table>";
		echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"><b>web interface login</b></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">username</td><td><input type=\"text\" name=\"username\" value=\"\"></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">password</td><td><input type=\"password\" name=\"password\" value=\"\"></td></tr>"; 
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">confirm password</td><td><input type=\"password\" name=\"confirm_password\" value=\"\"></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"><b>tvmonkey installation</b></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">where did you install tvmonkey to?</td><td><input type=\"text\" name=\"installdir\" value=\"\"></td></tr>";	
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">finished download location</td><td><input type=\"text\" name=\"movdir\" value=\"\"></td></tr>";
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"><b>transmission details</b></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">transmission host</td><td><input type=\"text\" name=\"tr_host\" value=\"\"></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">transmission port</td><td><input type=\"text\" name=\"tr_port\" value=\"\"></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">transmission username</td><td><input type=\"text\" name=\"tr_username\" value=\"\"></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">transmission password</td><td><input type=\"password\" name=\"tr_password\" value=\"\"></td></tr>"; 
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">confirm transmission password</td><td><input type=\"password\" name=\"confirm_tr_password\" value=\"\"></td></tr>";
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"><b>tvmonkey details</b></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">notification email address</td><td><input type=\"text\" name=\"email\" value=\"\"></td></tr>";
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">XBMC library IPs (separate with space)</td><td><input type=\"text\" name=\"xbmc_libs\" value=\"\"></td></tr>";	
		echo "<tr><td></td><td></td></tr>";
		echo "<tr><td style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">media locations (separate with a comma \",\")</td><td><input type=\"text\" name=\"medlocs\" value=\"/media/TV;/media/TV2\"></td></tr>";	
		echo "<tr><td></td><td align=\"right\"><input type=\"hidden\" name=\"marker\" value=\"1\"><input type=\"submit\" name=\"submit1\" value=\"go\"></td></tr>";
		echo "</table>";
	}
	
	if( $x == 1 )
	{
		echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		$handle = fopen("../tvmonkey.config", "a");
		if($handle)
		{
			$un = $_POST['username'] ;
			$pw = $_POST['password'] ; 
			$conpw = $_POST['confirm_password'] ;
			if ( $pw !== $conpw )
			{
				echo "<p>the passwords did not match please try again. </p>";
			}
			$write = "USERS=$un:$pw\n" ;
			fwrite($handle,stripslashes($write));
			$install = $_POST['installdir'] ;
			$write = "TVSHOWS=$install/tvshows.config\n" ;
			fwrite($handle,stripslashes($write));
			$movdir = $_POST['movdir'] ;
			$write = "MOV_DIR=$movdir\n" ;
			fwrite($handle,stripslashes($write));
			$write = "FLEXCONF=$install/config.yml\n" ;
			fwrite($handle,stripslashes($write));
			$trun = $_POST['tr_username'] ;
			$trpw = $_POST['tr_password'] ; 
			$trconpw = $_POST['confirm_tr_password'] ;		
			if ( $trpw !== $trconpw )
			{
				echo "<p>the transmission passwords did not match please try again. </p>";
			}		
			$write = "TR_CMD=\"transmission-remote --auth $trun:$trpw\"\n" ;
			fwrite($handle,stripslashes($write));
			$email = $_POST['email'] ;
			$write = "EMAIL=$email\n" ;
			fwrite($handle,stripslashes($write));
			$xbmc_libs = $_POST['xbmc_libs'] ;
			$write = "LIBRARY=$xbmc_libs\n";
			fwrite($handle,stripslashes($write));
			$medloc = $_POST['medlocs'] ;
			$write = "MED_LOC=$medloc\n" ;
			fwrite($handle,stripslashes($write));
			fclose($handle);
		}
		else
		{
			echo "<p>Unable to create tvmonkey.config file </p>";
		}

		$handle = fopen("../config.yml", "a");
		if($handle)
		{
			$write = "presets:\n" ;
			fwrite($handle,stripslashes($write));
			$write = "  transmissionrpc:\n" ;
			fwrite($handle,stripslashes($write));
			$write = "    transmission:\n" ;
			fwrite($handle,stripslashes($write));
			$trhost = $_POST['tr_host'];
			$trport = $_POST['tr_port'];
			$write = "      host: $trhost\n" ;
			fwrite($handle,stripslashes($write));
			$write = "      port: $trport\n" ;
			fwrite($handle,stripslashes($write));		
			$write = "      username: $trun\n" ;
			fwrite($handle,stripslashes($write));		
			$write = "      password: $trpw\n" ;
			fwrite($handle,stripslashes($write));
			$write = "      ratio: 0.1\n" ;
			fwrite($handle,stripslashes($write));
			$write = "      addpaused: No\n" ;
			fwrite($handle,stripslashes($write));
			$write = "  tv:\n" ;
			fwrite($handle,stripslashes($write));
			$write = "    series:\n" ;
			fwrite($handle,stripslashes($write));
			$write = "\n" ;
			fwrite($handle,stripslashes($write));
			$write = "\n" ;
			fwrite($handle,stripslashes($write));
			$write = "    exists_series:\n" ;
			fwrite($handle,stripslashes($write));
			$write = "\n" ;
			fwrite($handle,stripslashes($write));
			$write = "feeds:\n" ;
			fwrite($handle,stripslashes($write));
			fclose($handle);
		}
		else
		{
			echo "<p>Unable to create flexget config file </p>";
		}
		
		$handle = "../tvshows.config";
		if(!touch($handle))
		{
			echo "unable to create tvshows.config" ;
		}
		
		echo "<p>created configuration files <input type=\"hidden\" name=\"marker\" value=\"2\"><input type=\"submit\" name=\"submit1\" value=\"continue\">";
	}
	
	if( $x == 2 )
	{
		echo "<p>lets add some shows to TVMonkey</p>";
		echo "<table>";
		echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<tr>";
		echo "<td align=\"bottom\"><p>show: <input type=\"text\" name=\"show\"></p></td>";
		echo "<td><p>";
		echo "hdtv <input type=\"radio\" name=\"quality\" value=\"hdtv\" checked> ";
		echo "720p <input type=\"radio\" name=\"quality\" value=\"720P%7CHDTV\">";
		echo "</p></td>";
		echo "<td><p>";
		echo "<input type=\"hidden\" name=\"set\" value=\"go\">";
		echo "<input type=\"hidden\" name=\"marker\" value=\"3\">";
		echo "<input type=\"submit\" name=\"search\" value=\"search\">";
		echo "</p></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table>";
	}
	
	if( $x == 3 )
	{
		$show = $_POST['show'];
		$quality = $_POST['quality'];	
		$sr = str_replace(" ","+",$show);	
		$request = "http://ezrss.it/search/index.php?show_name=$sr&date=&quality=$quality&quality_exact=true&release_group=&mode=rss";
		$file = "dl.xml";
		$cmd = "wget -q \"$request\" -O $file";
		exec($cmd);
		if(!$xml=simplexml_load_file('dl.xml'))
		{
    		trigger_error('Error reading XML file',E_USER_ERROR);
		}
					
		if (filesize($file) < 800 )
		{
			echo "<p> No episodes were found. Try changing the quality for the show or search terms. </p>";
		}
			
		echo "<table>";
		$i = 0 ;
		foreach ($xml->channel->item as $item) 
		{
			$i++ ;
			//echo "<tr style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">";
			//echo "<td>";
			//echo $item->title;
			//echo "</td>";
  			//echo "</tr>";
		} 
		echo "<tr style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\"><td>found $i episodes of $show</td></tr>";
		echo "</table>";
		echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"><table>";
		echo "<tr><td align=\"bottom\"><p>add show $show to TVMonkey? </p></td><td><p><input type=\"submit\" name=\"add\" value=\"add show\"></p></td></tr>";
		echo "</table>";
		echo "<input type=\"hidden\" name=\"show\" value=\"$show\">";
		echo "<input type=\"hidden\" name=\"feed\" value=\"$request\">";
		echo "<input type=\"hidden\" name=\"marker\" value=\"4\">";
		echo "</form>";
	}
	
	if( $x == 4 )
	{
			
		$show = $_POST['show'];
		$feed = $_POST['feed'];
		
		echo "<p>which media location do you want $show to go to?</p>";
		echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<table>";
		
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
		if(!feof($handle)) 
		{
			echo "ERROR" ;
		}
			
		$loc = $config_values[MED_LOC] ;
		$split = explode(";", $loc);
		foreach ( $split as $value)
		{
			echo "<tr style=\"line-height: 1.4em; font-size: 0.7em; margin-bottom: 20px; color: #f4f4f4;\">";
			echo "<td><input type=\"radio\" name=\"medloc\" value=\"$value\"></td>";
			echo "<td>".$value."</td></tr>";
		}
		fclose($handle);
		echo "</table>";
		echo "<br />";
		echo "<input type=\"hidden\" name=\"show\" value=\"$show\">";
		echo "<input type=\"hidden\" name=\"feed\" value=\"$feed\">";
		echo "<input type=\"hidden\" name=\"marker\" value=\"5\">";
		echo "<p><input type=\"submit\" name=\"submit1\" value=\"add show\"></p>";
		echo "</form>";
	}
	
	if( $x == 5 )
	{
		$show = $_POST['show'];
		$feed = $_POST['feed'];
		$loc  = $_POST['medloc'];
		echo "<pre><p>";
		ob_implicit_flush(true);
		ob_end_flush();
		$command = '../add_show.sh \''.$show.'\' \''.$loc.'\' \''.$feed.'\'';
		system($command);
		echo "</p></pre>" ;
		echo "<table>";
		echo "<form name=\"form1\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<tr><td><input type=\"submit\" name=\"another\" value=\"add another\"></td><td><input type=\"submit\" name=\"done\" value=\"done\"></td></tr>";
		echo "</form>";	
		echo "</table>";
	}
	
	if( $x == 6 )
	{
		echo "<form name=\"form1\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<p><b>Congratulations</b> you have successfully configured TVMonkey. Click <b>go</b> to login.</p>";
		echo "<input type=\"hidden\" name=\"marker\" value=\"7\"> <input type=\"submit\" name=\"final\" value=\"go\">";
	}
	
	if( $x == 7 )
	{
		$_SESSION['myusername'] = "$un";
		header("location:index.php");
	}
	
	?>
	</form>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.php">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>
