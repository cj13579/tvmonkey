<?php
session_start();
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword'];

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
$arr=array() ;
$users = $config_values[USERS] ;
$split = explode("|", $users);
foreach ( $split as $value)
{
	$s1 = explode(":", $value);
	$arr[] = $s1[0];
	$un = $s1[0] ;
	$arr[] = $s1[1];
	$pw = $s1[1] ;
	if ( $myusername == $un )
	{
		if ( $mypassword == $pw )
		{
			$_SESSION['myusername'] = "$myusername";
			$_SESSION['mypassword'] = "$myusername";
			header("location:login_success.php");
		}
	}
}

if ( $_SESSION['myusername'] !== "$myusername" )
{
	header("location:login_failure.php");
}
?>