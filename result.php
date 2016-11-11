<?php 
	session_start();
	include_once 'dbconnect.php';

	if(isset($_POST['setjourney'])){
		$from=$_POST['from'];
		$to=$_POST['to'];
		$date=$_POST['date'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
<body style=" background-color: #f7f7f7;">
<div>
	<ul>
		<?php if(isset($_SESSION['user_name'])){ ?>
		<li><a class="active" href="#home">Home</a></li>
		<li style="float: right;"><a href="logout.php">Log Out</a></li>
		<li style="float: right;"><p>Hi <?php echo " ".$_SESSION['user_name']."   "?></p></li>
		<?php } else {?>
		<li><a class="active" href="#home">Home</a></li>
		<li style="float: right"><a  href="signup.php">SignUp</a></li>
		<li style="float: right"><a  href="login.php">Login</a></li>
		<?php }?>
	</ul>
</div>
<div align="center" style="margin-top: 60px">
	<h1 align="center">National Railway Reservation System</h1>
</div>