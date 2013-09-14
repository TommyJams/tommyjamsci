<?
ob_start();

if (!isset($_SESSION)) {
session_start();
}
include('../connect.php');
if(isset($_SESSION['username']))
{
	$username=$_SESSION['username'];
	$password=md5($_SESSION['password']);
	$role="p";
}
elseif(isset($_SESSION['username_artist']))
{
	$username=$_SESSION['username_artist'];
	$password=md5($_SESSION['password_artist']);
	$role="a";
}
else
{
	header("index.php");
	exit;
}
?>
<html>
<head>
	<link rel='stylesheet' href='css/edit.css'>
	<!-- Include the JS files -->
</head>
<body>
	<div id="box" style="display:block;">		<div class="head">			<h1>THANK YOU</h1>		</div>		<div id="textContainer">
						<p>Your feedback has been saved successfully!</p>				</div>			</div>
</body>
</html>