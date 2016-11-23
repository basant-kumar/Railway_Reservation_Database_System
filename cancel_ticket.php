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
if(isset($_POST['submit2'])){
	if(!empty($_POST['check_list'])){
		$train_no = "";
		$c1 = $c2 = 0;
		$pnr_no = $_POST['pnr_no'];
		$coach = $_POST['coach'];
		$s_date = $_POST['s_date'];
		$sql = "select train_no from tickets where pnr_no = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i",$pnr_no);
		$stmt->execute();
		$stmt->bind_result($train_no);
		$stmt->fetch();
		$stmt->close();

		$sql = "select count(*) from passenger where train_no=  ? and coach = ? and s_date = ? and t_status != 'Confirm'";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("iss",$train_no,$coach,$s_date);
		$stmt->execute();
		$stmt->bind_result($c1);
		$stmt->fetch();
		$stmt->close();

		foreach($_POST['check_list'] as $cnt){
				$sql1 = "insert into cancel_tickets values(?,?,?,?,?)";
				$stmt1 = $conn->prepare($sql1);
				$stmt1->bind_param('iisis',$pnr_no,$train_no,$coach,$cnt,$s_date);
				$stmt1->execute();
				$c2 = $c2+1;
			}
			for($i=0;$i<min($c2,$c1);$i++){
				$sql = "delete from cancel_tickets where pnr_no = ? and seat_no = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('ii',$pnr_no,$_POST['check_list'][$i]);
				$stmt->execute();
			}
			//$stmt->close();

			//include 'dbconnect.php';
			if($coach == "AC1"){
				$sql = "update status set bs_ac1 = bs_ac1 - ? where train_no = ? and a_date = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('iis',min($c2,$c1),$train_no,$s_date);
				$stmt->execute();
			}
			if($coach == "AC2"){
				$sql = "update status set bs_ac2 = bs_ac2 - ? where train_no = ? and a_date = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('iis',min($c2,$c1),$train_no,$s_date);
				$stmt->execute();
			}
			if($coach == "AC3"){
				$sql = "update status set bs_ac3 = bs_ac3 - ? where train_no = ? and a_date = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('iis',min($c2,$c1),$train_no,$s_date);
				$stmt->execute();
			}
			if($coach == "Sleeper"){
				$sql = "update status set bs_sl = bs_sl - ? where train_no = ? and a_date = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('iis',min($c2,$c1),$train_no,$s_date);
				$stmt->execute();
			}
		
	}else{
		echo "<script type='text/javascript'>alert('Select at least one passenger');</script>";
	}
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
<div align="center">
<h3 align="center">Enter your PNR No</h3>
<form method="POST" action=cancel_ticket.php>
	<input type="text" name="pnr_no" placeholder="PNR No">
	<input type="submit" name="submit">
</form>
</div>
<?php } else if($err != "") echo $err; else {?>
<div align="center">
	<h4>Check the ticket to be cancelled</h4>
	<form action="cancel_ticket.php" method="POST">
		<table>
			<tr>
				<th>
					Select
				</th>
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
				<td><input type="checkbox" name="check_list[]" value=<?php echo $p_seat_no; ?>>
				</td>
				<td><?php echo $p_name; ?></td>
				<td><?php echo $p_age; ?></td>
				<td><?php echo $p_gen; ?></td>
				<td><?php echo $p_seat_no; ?></td>
				<td><?php echo $p_coach; ?></td>
				<td><?php echo $p_status; ?></td>
			</tr>
			<?php }?>
		</table>
		<input type="hidden" name="pnr_no" value = <?php echo $pnr_no; ?> >
		<input type="hidden" name="coach" value = <?php echo $p_coach; ?> >
		<input type="hidden" name="s_date" value = <?php echo $s_date; ?> >
		<input type="submit" name="submit2">
	</form>
</div>
<?php }?>
</body>
</html>