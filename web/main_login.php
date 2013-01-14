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
            <!--<li><a href="index.php">Home</a></li>-->
            <!--<li><a href="config.php">Config</a></li>-->
            <!--<li><a href="run.php">app</a></li>-->
            <!--<li><a href="#">Link</a></li> -->
            <!--<li><a href="#">Link</a></li>-->
		</ul>
    </div>
    <div id="content">
		<div id="home" name="home1" >
			<form name="form1" method="post" action="check_login.php">
				<table>
				<tr><td><strong>Username: </strong></td><td><input name="myusername" type="text" id="myusername"></td></tr>
				<tr><td><strong>Password: </strong></td><td><input name="mypassword" type="password" id="mypassword"></td></tr>
				</table>
				<input type="submit" name="Submit" value="Login">
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