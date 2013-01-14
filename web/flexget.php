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

function pageY(elem) {
    return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
}
var buffer = 10; //scroll bar buffer
function resizeIframe() {
    var height = window.innerHeight || document.body.clientHeight || document.documentElement.clientHeight;
    height -= pageY(document.getElementById('ifm'))+ buffer ;
    height = (height < 0) ? 0 : height;
    document.getElementById('ifm').style.height = height + 'px';
}
window.onresize = resizeIframe;
window.onload = resizeIframe;
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
           <li><a href="flexget.php">flexget</a></li>
            <!--<li><a href="#">Link</a></li> -->
        </ul>
    </div>
    <div id="content">
		<div id="home" name="home1" >
			<h3>TVMonkey 0.3.1</h3>
			<br />
			<?php
			if(isset($_POST['submit1']))
			{
				if (isset($_POST['vermon']))
				{
					$x = shell_exec('/home/chris/Programs/tvmonkey/0.3.1/tvmover.sh --version') ;
					echo "<pre><p>$x</p></pre>" ;
				}
			}
			
			if(isset($_POST['submit2']))
			{
				if (isset($_POST['flexcon']))
				{
					echo "<pre><p>" ;
					$file = file_get_contents("/home/chris/.flexget/config.yml");
					print $file;
					echo "</p></pre>" ;
				}
			}
			?>
			<form method="post" action="<?php  echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="vermon" value="run">
			<input type="submit" name="submit1" value="Get TVMonkey version">
			<input type="hidden" name="flexcon" value="run">
			<input type="submit" name="submit2" value="Show Flexget Config">
			</form>
			<!-- ><iframe id="ifm" src="http://192.168.0.4:8080/home/" frameborder="0" width="100%" >You need a Frames Capable browser to view this content.</iframe> -->
		</div>
    </div>
    <div class="br"></div>
    <div id="footer">
        <p class="center">Copyright &copy; <a href="index.html">cj13579.dyndns-server.com</a> | <a href="http://www.leadbon.se">Design by Leadbon</a></p>
    </div>
</div>
</body>
</html>