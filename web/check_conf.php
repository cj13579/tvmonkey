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
            <li><a href="index.php">Home</a></li>
            <li><a href="config.php">Config</a></li>
            <li><a href="run.php">app</a></li>
            <!--<li><a href="#">Link</a></li> -->
            <!--<li><a href="#">Link</a></li> -->
        </ul>
    </div>
    <div id="content">
		<div id="home" name="home1" >
			<h3>TVMonkey 0.4</h3>
			<?php
			if(isset($_POST['submit6']))
			{			
				echo "<pre><p>";

				// tell php to automatically flush after every output
				// including lines of output produced by shell commands
				ob_implicit_flush(true);
				ob_end_flush();

				$command = '../config_check.sh -i';
				system($command);

				echo "</p></pre>" ;
			)
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