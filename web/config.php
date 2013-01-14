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
				<td align="center">
					<input type="hidden" name="flexcon" value="run">
					<input type="submit" name="submit2" value="flexget config file">
				</td>
				<td align="center"> | 
				</td>				
				<td align="center">
					<input type="hidden" name="tvmon" value="run">
					<input type="submit" name="submit3" value="tvmonkey config file">
				</td>
				<td align="center"> | 
				</td>
				<td align="center">
					<input type="hidden" name="check" value="run">
					<input type="submit" name="submit6" value="check system config">
				</td>
			</tr>
		</form>
		<table>
		<br />
            <?php
			
			if(!isset($_POST['submit1']))
			{
				if(!isset($_POST['submit2']))
				{				
					if(!isset($_POST['submit3']))
					{
						if(!isset($_POST['submit4']))
						{
							if(!isset($_POST['submit5']))
							{
								if(!isset($_POST['submit6']))
								{
									echo "<p> This is the configuration page of TVMonkey. You can use this page to view and change the TVMonkey and 
									Flexget configuration files as well as check that your current system configuration is valid. 
									<br />
									<br />
									You are using TVMonkey version <b>0.4.1</b> </p>" ;
								}
							}
						}
					}
				}
			}
			if(isset($_POST['submit3']))
			{
				echo "<pre><p>" ;
				$file = file_get_contents("../tvmonkey.config");
				print $file;
				echo "</p></pre>" ;
				echo "<form method=\"post\" action=\"edit_tvmon.php\">";
				echo "<input type=\"hidden\" name=\"edit\" value=\"run\">";
				echo "<input type=\"submit\" name=\"submit5\" value=\"edit\">";
				echo "</form>";	
			}
			
			if(isset($_POST['submit1']))
			{
				if (isset($_POST['vermon']))
				{
					$x = shell_exec('../tvmover.sh --version') ;
					echo "<pre><p>$x</p></pre>" ;
				}
			}
			
			if(isset($_POST['submit2']))
			{
				if (isset($_POST['flexcon']))
				{
					echo "<pre><p>" ;
					$file = file_get_contents("../config.yml");
					print $file;
					echo "</p></pre>" ;
					echo "<form method=\"post\" action=\"edit_flex.php\">";
					echo "<input type=\"hidden\" name=\"edit\" value=\"run\">";
					echo "<input type=\"submit\" name=\"submit4\" value=\"edit\">";
					echo "</form>";
				}
			}
			if(isset($_POST['submit4']))
			{
				header("location:edit_flex.php");
			}
			
			if(isset($_POST['submit5']))
			{
				header("location:edit_tvmon.php");
			}
			
			if(isset($_POST['submit6']))
			{
				echo "<pre><p>";
				ob_implicit_flush(true);
				ob_end_flush();
				$command = '../config_check.sh -i';
				system($command);
				echo "</p></pre>" ;
			}
			?>
			</p>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.php">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>