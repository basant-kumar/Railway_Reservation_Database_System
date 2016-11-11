<?php
	session_start();
	include_once 'dbconnect.php';
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
<div align="center" >
	<h1 style="color:Blue">Set Your Journey</h1>
</div>
<div>
	<form action="result.php" method="post">
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