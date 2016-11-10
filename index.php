<?php
	session_start();
	include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<style>
		ul{
			list-style-type: none;
			margin: 0;
			padding: 0;
			background-color: #747a84;
			overflow: hidden;
			position: fixed;
			top: 0;
			width: 100%;
		}
		li{
			float: left;
		}
		li a{
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;

		}
		li a:hover:not(.active){
			background-color: black;
		}
		li a.active{
			background-color: #4CAF50;
		}
	</style>
</head>
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
</div><br>
<div align="center" style="margin: 100px">
	<h1 align="center">National Railway Reservation System</h1>
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>