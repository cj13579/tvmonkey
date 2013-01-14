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
		<?php
		if(!isset($_POST['add']))
			{
				if(!isset($_POST['submit1']))
				{	
					echo "<p>search for the show that you wish to add:</p>";
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
						echo "<input type=\"submit\" name=\"search\" value=\"search\">";
						echo "</p></td>";
					echo "</tr>";
					echo "</form>";
					echo "</table>";
				}
			}
		
		
		if(isset($_POST['submit1']))
		{
			$show = $_POST['show'];
			$feed = $_POST['feed'];
			$loc  = $_POST['medloc'];
			echo "<pre><p>";
			ob_implicit_flush(true);
			ob_end_flush();
//			echo "$show <br />";
//			echo ' \''.$feed.'\'<br />';
//			echo "$loc <br />";
			$command = '../add_show.sh \''.$show.'\' \''.$loc.'\' \''.$feed.'\'';
//			echo $command ;
			system($command);
			echo "</p></pre>" ;
			echo "<form name=\"form1\" method=\"post\" action=\"run.php\">";
			echo "<p> <input type=\"checkbox\" name=\"test\" value=\test\" /> Run in test mode </p>";
			echo "<input type=\"hidden\" name=\"go\" value=\"run\">";
			echo "<input type=\"submit\" name=\"submit\" value=\"Run TVMonkey\">";
			echo "</form>";	
		
		}
				
		if(isset($_POST['search']))
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
			foreach ($xml->channel->item as $item) 
			{
				echo "<tr style=\"line-height: 1.4em; 
    								font-size: 0.7em; 
    								margin-bottom: 20px; 
   									 color: #f4f4f4;\">";
				echo "<td><a href=\"".$item->enclosure[url]."\" target=\"_blank\"> <img src=\"show_info.png\"></a></td>";
				echo "<td>";
				echo $item->title;
				echo "</td>";
  				echo "</tr>";
			} 
			echo "</table>";
			echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"><table>";
			echo "<tr><td align=\"bottom\"><p>add show $show to TVMonkey? </p></td><td><p><input type=\"submit\" name=\"add\" value=\"add show\"></p></td></tr>";
			echo "</table>";
			echo "<input type=\"hidden\" name=\"show\" value=\"$show\">";
			echo "<input type=\"hidden\" name=\"feed\" value=\"$request\">";
			echo "</form>";
		}
		
		if(isset($_POST['add']))
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
			if (!feof($handle)) 
			{
				echo "ERROR" ;
			}
			
			$loc = $config_values[MED_LOC] ;
			$split = explode(",", $loc);
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
			echo "<p><input type=\"submit\" name=\"submit1\" value=\"add show\"></p>";
			echo "</form>";
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