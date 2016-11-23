<?php 
	session_start();
	include 'dbconnect.php';
	$train_no = $_GET['tn'];
	$class = $_GET['cl'];
	$fair=$_GET['f'];
	$date=$_GET['d'];
	$cd=$_GET['c'];
	$date=date('Y-m-d', strtotime('-'.$cd.' day', strtotime($date)));
	if($class=='AC1'){
		$fair=$fair*4;
	}elseif($class=='AC2'){
		$fair=$fair*3;
	}elseif ($class == 'AC3') {
		$fair=$fair*2;
	}
	$sql="select ts_ac1,bs_ac1,ts_ac2,bs_ac2,ts_ac3,bs_ac3,ts_sl,bs_sl from status where train_no = ? and a_date = ?";
	$st=$conn->prepare($sql);
	$st->bind_param("is", $train_no, $date);
	$st->execute();
	$st->bind_result($ts_ac1,$bs_ac1,$ts_ac2,$bs_ac2,$ts_ac3,$bs_ac3,$ts_sl,$bs_sl);
	$st->fetch();
	$st->close();
	if($class=='AC1'){
		$ts=$ts_ac1;
		$bs=$bs_ac1;
		$cl='First AC';
	}elseif($class=='AC2'){
		$ts=$ts_ac2;
		$bs=$bs_ac2;
		$cl='Second AC';
	}elseif ($class == 'AC3') {
		$ts=$ts_ac3;
		$bs=$bs_ac3;
		$cl='Third AC';
	}else{
		$ts=$ts_sl;
		$bs=$bs_sl;
		$cl='Sleeper';
	}
	if($ts==''){
		$conn->query('call status_new_entry("'.$train_no.'","'.$date.'")');
		$sql="select ts_ac1,bs_ac1,ts_ac2,bs_ac2,ts_ac3,bs_ac3,ts_sl,bs_sl from status where train_no = ? and a_date = ?";
		$st=$conn->prepare($sql);
		$st->bind_param("is", $train_no, $date);
		$st->execute();
		$st->bind_result($ts_ac1,$bs_ac1,$ts_ac2,$bs_ac2,$ts_ac3,$bs_ac3,$ts_sl,$bs_sl);
		$st->fetch();
		$st->close();
		if($class=='AC1'){
			$ts=$ts_ac1;
			$bs=$bs_ac1;
			$cl='First AC';
		}elseif($class=='AC2'){
			$ts=$ts_ac2;
			$bs=$bs_ac2;
			$cl='Second AC';
		}elseif ($class == 'AC3') {
			$ts=$ts_ac3;
			$bs=$bs_ac3;
			$cl='Third AC';
		}else{
			$ts=$ts_sl;
			$bs=$bs_sl;
			$cl='Sleeper';
		}
	}	
		$as=$ts-$bs;
	
		//echo "mar gaya";
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Result Page</title>
	<style type="text/css">
		a{
			color: blue;
			text-decoration: none;
		}
		a:hover{
			background-color: red;
		}
	</style>
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
</div><br><br><br>
<div align="center" style="margin-top:10px;margin-bottom: 15px">
	<h1 style="color:blue">National Railway Railway System</h1>
</div>
<div>
	<table border="1" align="center" style="margin-top: 80px;border-collapse: collapse; font-size: 20px">
		<tr>
			<th>Train No</th>
			<th>Class</th>
			<th>Available Seats</th>
			<th>Total Fair</th>
			<th>Book</th>
		</tr >
		<tr align="center">
			<td><?php echo $train_no ?></td>
			<td><?php echo $cl ?></td>
			<td><?php echo $as ?></td>
			<td><?php echo $fair ?></td>
			<td><a href=#bookno >Book Now</a></td>
		</tr>
	</table>
</div>
</body>
</html>