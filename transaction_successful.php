<?php
session_start();
$pnr = $_SESSION['pnr_no'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaction Details</title>
</head>
<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
<body style=" background-color: #f7f7f7;">
<div>
	<ul>
		<?php if(isset($_SESSION['user_name'])){ ?>
		<li><a class="active" href="index.php">Home</a></li>
		<li><a  href="pnr_status.php">PNR Status</a></li>
		<li><a  href="cancel_ticket.php">Cancel Ticket</a></li>
		<li style="float: right;"><a href="logout.php">Log Out</a></li>
		<li style="float: right;"><p>Hi <?php echo " ".$_SESSION['user_name']."   "?></p></li>
		<?php } else {?>
		<li><a class="active" href="index.php">Home</a></li>
		<li><a  href="pnr_status.php">PNR Status</a></li>
		<li style="float: right"><a  href="signup.php">SignUp</a></li>
		<li style="float: right"><a  href="login.php">Login</a></li>
		<?php }?>
	</ul>
</div><br><br><br>
	<h3 align="center"> Transaction Successful</h3>
	<h3 align="center">PNR No: <?php echo $pnr; ?> </h3>
	<h5 align="center">please note down your PNR No</h5> 
</body>
</html>