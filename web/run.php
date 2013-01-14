<?php
session_start() ;
error_reporting(E_ALL);
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
			<?php
				
			if(isset($_POST['test']))
			{
				echo "<p>";
				echo "TVMonkey is running in test mode - I wont download any shows!";
				echo "</p>";
				echo "<pre><p>";
				ob_implicit_flush(true);
				ob_end_flush();
				$command = '../tvmover.sh --testweb';
				system($command);
				echo "</p></pre>" ;
				
			}
			elseif (isset($_POST['submit']))
			{
				echo "<pre><p>";
				ob_implicit_flush(true);
				ob_end_flush();
				$command = '../tvmover.sh --web';
				system($command);

				echo "</p></pre>" ;
			}
			?>
			<form name="form1" method="post" action="<?php  echo $_SERVER['PHP_SELF']; ?>">
			<p> <input type="checkbox" name="test" value="test" /> Run in test mode </p>
			<input type="hidden" name="go" value="run">
			<input type="submit" name="submit" value="Run TVMonkey">
			</form>			
		</div>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.html">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>