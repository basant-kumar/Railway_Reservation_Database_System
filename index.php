<?php
	session_start();
	include_once 'dbconnect.php';

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['setjourney'])){
		if((strtotime($_POST['date'])<strtotime(date('Y-m-d')))){
			echo "<script type='text/javascript'>alert('Please Enter correct Date');</script>";
		}
		if($_POST['from']!='' && $_POST['to']!='' && $_POST['date']!='' ) {
					if (strpos($_POST['from'], ')') != true || strpos($_POST['from'], ')') != true){
						echo "<script type='text/javascript'>alert('Enter correct stations name');</script>";
					}else{
						$_SESSION['from']=$_POST['from'];
						$_SESSION['to']=$_POST['to'];
						$_SESSION['date']=$_POST['date'];
						header('Location:result.php');
					}
		}else{
			echo "<script type='text/javascript'>alert('data can not be empty');</script>";
		}

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
		<li><a  href="pnr_status.php">PNR Status</a></li>
		<li><a  href="cancel_ticket.php">Cancel Ticket</a></li>
		<li style="float: right;"><a href="logout.php">Log Out</a></li>
		<li style="float: right;"><p>Hi <?php echo " ".$_SESSION['user_name']."   "?></p></li>
		<?php } else {?>
		<li><a class="active" href="#home">Home</a></li>
		<li><a  href="pnr_status.php">PNR Status</a></li>
		<li style="float: right"><a  href="signup.php">SignUp</a></li>
		<li style="float: right"><a  href="login.php">Login</a></li>
		<?php }?>
	</ul>
</div>
<div align="center" style="margin-top: 60px">
	<h1 align="center">National Railway Reservation System</h1>
</div>
<div align="center" >
	<h1 style="color:Blue">Set Your Journey</h1>
</div>
<div>
	<form action="index.php" method="post">
	<table align="center" style="margin-top: 30px" width="300" height="150">
		<tr>
			<td>From: </td>
			<td><input list="stations"  name="from" placeholder="From"></td>
		</tr>

		<tr>
			<td>To: </td>
			<td><input list="stations" name="to" placeholder="To"></td>
		</tr>
		<tr>
			<td>Date of Journey: </td>
			<td><input type="date" name="date" placeholder="dd-mm-yyyy"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="setjourney"></td>
		</tr>
	</table>
	
	<?php 
		echo "<datalist id='stations'> ";
		$sql="select stn_code,stn_name from stations";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($stn_code,$stn_name);
		while($stmt->fetch()){
			echo '<option value="'.$stn_name.' ('.$stn_code.')">';
		}
		$stmt->close();
		echo "</datalist>";
	?>
	</form>
</div>
</body>
</html>