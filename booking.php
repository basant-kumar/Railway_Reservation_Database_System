<?php
session_start();
include 'dbconnect.php';
		$from = $_SESSION['from'];
		$to = $_SESSION['to'];
		$train_name = 	$_SESSION['train_name'];
		$train_type =	$_SESSION['train_type'] ;
		$fat = 	$_SESSION['fat'] ;
		$fdt = 	$_SESSION['fdt'] ;
		$tat = 	$_SESSION['tat'] ;
		$tdt = 	$_SESSION['tdt'] ;
		$dist = 	$_SESSION['dist'] ;
		$tn = 	$_SESSION['tn'] ;
		$cl = 	$_SESSION['cl'];
		$fair = 	$_SESSION['f'] ;
		$date_of_journey =	$_SESSION['d'] ;
?>


<!DOCTYPE>
<html>
<head>
	<title>
		Journey Details
	</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
</head>
<body style=" background-color: #f7f7f7; ">
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
	<h3 align="center" style="color: blue">Journey Details</h3>
	<table align="center" >
		<tr>
			<td>
				Train No: 
			</td>
			<td>
				<?php echo $tn; ?>
			</td>
		</tr>
		<tr>
			<td>
				Train Name: 
			</td>
			<td >
				<?php echo $train_name; ?>
			</td>
		</tr>
		<tr>
			<td>
				Journey Date: 
			</td>
			<td>
				<?php echo $date_of_journey; ?>
			</td>
		</tr>
		<tr>
			<td>
				Train Type: 
			</td>
			<td>
				 <?php echo $train_type; ?>
			</td>
		</tr>
		<tr>
			<td>
				From Station: 
			</td>
			<td>
				<?php echo $from; ?>
			</td>
		</tr>
		<tr>
			<td>
				To Station: 
			</td>
			<td>
				 <?php echo $to; ?>
			</td>
		</tr>
		<tr>
			<td>
				Distance: 
			</td>
			<td>
				<?php echo $dist.'(KM)'; ?>
			</td>
		</tr>
		<tr>
			<td>
				Fair: 
			</td>
			<td>
				<?php echo $fair.'/-'; ?>
			</td>
		</tr>
		<tr>
			<td>
				Class: 
			</td>
			<td>
				 <?php echo $cl; ?>
			</td>
		</tr>


	</table>


<div>
	<h3 align="center" style="color:red">Passenger Details</h3>
	<table align="center" border="1" align="center" style="margin-top: 10px;border-collapse: collapse;">
	<form action=confirm.php method="POST">
		<tr align="left">
			<th>S. NO.</th>
			<th>Name</th>
			<th>Age</th>
			<th>Gender</th>
		</tr>
		<tr>
			<th>1:</th>
			<td> <input type="text" name="name1" placeholder="Name"> </td>
			<td> <input type="integer" name="age1" placeholder="Age"> </td>
			<td><select name="gender1">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		<tr>
			<th>2:</th>
			<td> <input type="text" name="name2" placeholder="Name"> </td>
			<td> <input type="integer" name="age2" placeholder="Age"> </td>
			<td><select name="gender2">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		<tr>
			<th>3:</th>
			<td> <input type="text" name="name3" placeholder="Name"> </td>
			<td> <input type="integer" name="age3" placeholder="Age"> </td>
			<td><select name="gender3">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		<tr>
			<th>4:</th>
			<td> <input type="text" name="name4" placeholder="Name"> </td>
			<td> <input type="integer" name="age4" placeholder="Age"> </td>
			<td><select name="gender4">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		<tr>
			<th>5:</th>
			<td> <input type="text" name="name5" placeholder="Name"> </td>
			<td> <input type="integer" name="age5" placeholder="Age"> </td>
			<td><select name="gender5">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		<tr>
			<th>6:</th>
			<td> <input type="text" name="name6" placeholder="Name"> </td>
			<td> <input type="integer" name="age6" placeholder="Age"> </td>
			<td><select name="gender6">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				
			</td>
		</tr>
		
	</table>
	<p align="center"><input type="submit" name="submit"></p>
	</form>
</div>




</body>


</html>