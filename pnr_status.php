<?php
session_start();
include 'dbconnect.php';

if(isset($_POST['submit'])){
	//include 'dbconnect.php';
	$err  ="";
	$pnr_no = $p_name = $p_age = $p_gen = $p_seat_no = $p_coach = $p_status = $tn = $s_date = "";
	$pnr_no = $_POST['pnr_no'];
	$sql  = "select * from passenger where pnr_no = ? order by p_name";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param('i',$pnr_no);
	$stmt->execute();
	$stmt->bind_result($pnr_no,$p_name,$p_age,$p_gen,$p_seat_no,$p_coach,$tn,$s_date,$p_status);
	$stmt->store_result();
	if(!$stmt->fetch()){
		$err = "PNR not found";
	}
	$stmt->data_seek(0);
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Ticket Cancellation</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
</head>
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
</div><br><br><br><br><br><br>

<?php if(!isset($_POST['submit'])) {?>
<h3 align="center">Enter your PNR No</h3>
<div align="center">
<form method="POST" action=pnr_status.php>
	<input type="text" name="pnr_no" placeholder="PNR No">
	<input type="submit" name="submit">
</form>
</div>
<div align="center">
	<?php } else if($err != "") echo $err; else {?>	
</div>

<div align="center">
	<h4>Result</h4>
		<table>
			<tr>
				<th>
					Name
				</th>
				<th>
					Age
				</th>
				<th>
					Gender
				</th>
				<th>
					Seat No
				</th>
				<th>
					Coach
				</th>
				<th>
					Status
				</th>
			</tr>
			<?php $counter = 1; while($stmt->fetch()) { ?>
			<tr>
				<td><?php echo $p_name; ?></td>
				<td><?php echo $p_age; ?></td>
				<td><?php echo $p_gen; ?></td>
				<td><?php echo $p_seat_no; ?></td>
				<td><?php echo $p_coach; ?></td>
				<td><?php echo $p_status; ?></td>
			</tr>
			<?php }?>
		</table>	
</div>
<?php }?>
</body>
</html>