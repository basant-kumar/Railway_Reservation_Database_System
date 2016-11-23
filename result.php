<?php 
	session_start();
<<<<<<< HEAD
	include 'dbconnect.php';
		//$_SESSION['flag']=0;
		$ffrom=$_SESSION['from'];
		preg_match('#\((.*?)\)#', $ffrom, $from);
		$tto=$_SESSION['to'];
		preg_match('#\((.*?)\)#', $tto, $to);
		$date=$_SESSION['date'];
		$timestamp=strtotime($date);
		$day=date('w',$timestamp);
		$class='';
		$stmt=$conn->query('call search_trains("'.$from[1].'","'.$to[1].'","'.$day.'")');
		//if($conn) echo "bahar mar ja";
		if(isset($_GET['tn'])){
			include 'dbconnect.php';
			//if($conn) echo "mar ja";
			$train_no = $_GET['tn'];
			$class = $_GET['cl'];
			$fair=$_GET['f'];
			$date=$_GET['d'];
			$cd=$_GET['c'];

			$_SESSION['train_name'] = $_GET['train_name'];
			$_SESSION['train_type'] = $_GET['train_type'];
			$_SESSION['fat'] = $_GET['fat'];
			$_SESSION['fdt'] = $_GET['fdt'];
			$_SESSION['tat'] = $_GET['tat'];
			$_SESSION['tdt'] = $_GET['tdt'];
			$_SESSION['dist'] = $_GET['dist'];
			$_SESSION['tn'] = $_GET['tn'];
			$_SESSION['cl'] = $_GET['cl'];
			$_SESSION['d'] = $_GET['d']; //date of journey...


			$date=date('Y-m-d', strtotime('-'.$cd.' day', strtotime($date)));
			 $_SESSION['s_date'] = $date; //date at which train starts from source...
			if($class=='AC1'){
				$fair=$fair * 4;
			}else if($class=='AC2'){
				$fair=$fair * 3;
			}else if ($class == 'AC3') {
				$fair=$fair*2;
			}
			$_SESSION['f'] = $fair; 
			$sql="select ts_ac1,bs_ac1,ts_ac2,bs_ac2,ts_ac3,bs_ac3,ts_sl,bs_sl from status where train_no = ? and a_date = ?";
			//echo $train_no.' '.$class.' '.$fair.' '.$date.' '.$cd;
			$st=$conn->prepare($sql);
			//if(!$st) echo "tu bhi mar ja";
			$st->bind_param('is', $train_no, $date);
			$st->execute();
			$st->bind_result($ts_ac1,$bs_ac1,$ts_ac2,$bs_ac2,$ts_ac3,$bs_ac3,$ts_sl,$bs_sl);
			$st->fetch();
			$st->close();
			if($class=='AC1'){
				//echo "<script type='text/javascript'>alert('mar ja');</script>";
				$ts=$ts_ac1;
				$bs=$bs_ac1;
				$cl='First AC';
			}else if($class=='AC2'){
				$ts=$ts_ac2;
				$bs=$bs_ac2;
				$cl='Second AC';
			}else if ($class == 'AC3') {
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
				$_SESSION['bs'] = $bs;
				$_SESSION['ts'] = $ts;
		}

=======
	include_once 'dbconnect.php';

	if(isset($_POST['setjourney'])){
		$ffrom=$_POST['from'];
		preg_match('#\((.*?)\)#', $ffrom, $from);
		$tto=$_POST['to'];
		preg_match('#\((.*?)\)#', $tto, $to);
		$date=$_POST['date'];
		$timestamp=strtotime($date);
		$day=date('w',$timestamp);
		$stmt=$conn->query('call search_trains("'.$from[1].'","'.$to[1].'","'.$day.'")');
		

	}
>>>>>>> origin/master
?>

<!DOCTYPE html>
<html>
<head>
<<<<<<< HEAD
	<title>Result Page</title>
=======
	<title>Home Page</title>
>>>>>>> origin/master
	<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
	<style type="text/css">
		a{
			color: blue;
			text-decoration: none;
		}
		a:hover{
			background-color: red;
		}
	</style>
<<<<<<< HEAD
	<script type="text/javascript">
		fun($train_no,$fair,$current_day,$cl){
			alert($train_no);
			echo "mar ja";
		}
	</script>
</head>
=======
>>>>>>> origin/master
<body style=" background-color: #f7f7f7;">
<div>
	<ul>
		<?php if(isset($_SESSION['user_name'])){ ?>
<<<<<<< HEAD
		<li><a class="active" href="index.php">Home</a></li>
		<li><a  href="pnr_status.php">PNR Status</a></li>
		<li><a  href="cancel_ticket.php">Cancel Ticket</a></li>
		<li style="float: right;"><a href="logout.php">Log Out</a></li>
		<li style="float: right;"><p>Hi <?php echo " ".$_SESSION['user_name']."   "?></p></li>
		<?php } else {?>
		<li><a class="active" href="index.php">Home</a></li>
		<li><a  href="pnr_status.php">PNR Status</a></li>
=======
		<li><a class="active" href="#home">Home</a></li>
		<li style="float: right;"><a href="logout.php">Log Out</a></li>
		<li style="float: right;"><p>Hi <?php echo " ".$_SESSION['user_name']."   "?></p></li>
		<?php } else {?>
		<li><a class="active" href="#home">Home</a></li>
>>>>>>> origin/master
		<li style="float: right"><a  href="signup.php">SignUp</a></li>
		<li style="float: right"><a  href="login.php">Login</a></li>
		<?php }?>
	</ul>
<<<<<<< HEAD
</div><br><br><br>
			<h2 align="center">Select Your Train</h2>
			<?php if($stmt->num_rows > 0){?>
			<table border="1" align="center" style="margin-top: 30px;border-collapse: collapse;">
				<tr>
					<th>Train No.</th>
					<th>Train Name</th>
					<th>Train Type</th>
					<th>From</th>
					<th>Arrival Time</th>
					<th>Departure Time</th>
					<th>To</th>
					<th>Arrival Time</th>
					<th>Departure Time</th>
					<th>Days of Journey</th>
					<th>Distance (KM)</th>
					<th>Class</th>
				</tr>
				<?php while($result=$stmt->fetch_assoc()){?>
					
				<tr align="center">
					<td><?php echo $result['train_no'] ?></td>
					<td><?php echo $result['train_name'] ?></td>
					<td><?php echo $result['train_type'] ?></td>
					<td><?php echo $from[1] ?></td>
					<td><?php echo $result['fat'] ?></td>
					<td><?php echo $result['fdt'] ?></td>
					<td><?php echo $to[1] ?></td>
					<td><?php echo $result['tat'] ?></td>
					<td><?php echo $result['tdt'] ?></td>
					<td><?php echo $result['extra_day'] ?></td>
					<td><?php echo $result['dist'] ?></td>
					<td>
						<a href="result.php?tn=<?php echo $result['train_no']; ?>
									&&f=<?php echo $result['fair']; ?>&&d=<?php echo $date; ?>
									&&train_name=<?php echo $result['train_name']; ?>
									&&train_type=<?php echo $result['train_type']; ?>
									&&fat=<?php echo $result['fat']; ?>&&fdt=<?php echo $result['fdt']; ?>
									&&tat=<?php echo $result['tat']; ?>&&tdt=<?php echo $result['tdt']; ?>
									&&extra_day=<?php echo $result['extra_day']; ?>
									&&dist=<?php echo $result['dist']; ?>
									&&c=<?php echo $result['current_day']; ?>&&cl=AC1" >AC1</a>
						<a href="result.php?tn=<?php echo $result['train_no']; ?>
									&&f=<?php echo $result['fair']; ?>&&d=<?php echo $date; ?>
									&&train_name=<?php echo $result['train_name']; ?>
									&&train_type=<?php echo $result['train_type']; ?>
									&&fat=<?php echo $result['fat']; ?>&&fdt=<?php echo $result['fdt']; ?>
									&&tat=<?php echo $result['tat']; ?>&&tdt=<?php echo $result['tdt']; ?>
									&&extra_day=<?php echo $result['extra_day']; ?>
									&&dist=<?php echo $result['dist']; ?>
									&&c=<?php echo $result['current_day']; ?>&&cl=AC2 " >AC2</a>
						<a href="result.php?tn=<?php echo $result['train_no']; ?>
									&&f=<?php echo $result['fair']; ?>&&d=<?php echo $date; ?>
									&&train_name=<?php echo $result['train_name']; ?>
									&&train_type=<?php echo $result['train_type']; ?>
									&&fat=<?php echo $result['fat']; ?>&&fdt=<?php echo $result['fdt']; ?>
									&&tat=<?php echo $result['tat']; ?>&&tdt=<?php echo $result['tdt']; ?>
									&&extra_day=<?php echo $result['extra_day']; ?>
									&&dist=<?php echo $result['dist']; ?>
									&&c=<?php echo $result['current_day']; ?>&&cl=AC3 " >AC3</a>
						<a href="result.php?tn=<?php echo $result['train_no']; ?>
									&&f=<?php echo $result['fair']; ?>&&d=<?php echo $date; ?>
									&&train_name=<?php echo $result['train_name']; ?>
									&&train_type=<?php echo $result['train_type']; ?>
									&&fat=<?php echo $result['fat']; ?>&&fdt=<?php echo $result['fdt']; ?>
									&&tat=<?php echo $result['tat']; ?>&&tdt=<?php echo $result['tdt']; ?>
									&&extra_day=<?php echo $result['extra_day']; ?>
									&&dist=<?php echo $result['dist']; ?>
									&&c=<?php echo $result['current_day']; ?>&&cl=Sleeper " >SL</a>
					</td>
				</tr>
				<?php }?>
			</table>
			<?php }else{?>
				<div align="center" style="margin-top: 80px">
					<h1 align="center">Sorry !! No Trains Available</h1>
				</div>
				<?php }?>

		</div>
		<?php $stmt->close();?>
		<?php if(isset($_GET['tn'])){?>
		
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
					<td><a href= <?php if(!isset($_SESSION['user_name'])){ $_SESSION['goto'] = 1;  echo "login.php";}else echo "booking.php"?> >Book Now</a></td>
				</tr>
			</table>
		</div>
		<?php  }?>
</body>		
</html>

=======
</div>
<div>
	<?php if($stmt->num_rows > 0){?>
	<table border="1" align="center" style="margin-top: 80px;border-collapse: collapse;">
		<tr>
			<th>Train No.</th>
			<th>Train Name</th>
			<th>Train Type</th>
			<th>From</th>
			<th>Arrival Time</th>
			<th>Departure Time</th>
			<th>To</th>
			<th>Arrival Time</th>
			<th>Departure Time</th>
			<th>Days of Journey</th>
			<th>Distance (KM)</th>
			<th>Fair</th>
			<th>Class</th>
		</tr>
		<?php while($result=$stmt->fetch_assoc()){?>
			
		<tr>
			<td><?php echo $result['train_no'] ?></td>
			<td><?php echo $result['train_name'] ?></td>
			<td><?php echo $result['train_type'] ?></td>
			<td><?php echo $from[1] ?></td>
			<td><?php echo $result['fat'] ?></td>
			<td><?php echo $result['fdt'] ?></td>
			<td><?php echo $to[1] ?></td>
			<td><?php echo $result['tat'] ?></td>
			<td><?php echo $result['tdt'] ?></td>
			<td><?php echo $result['extra_day'] ?></td>
			<td><?php echo $result['dist'] ?></td>
			<td><?php echo $result['fair'] ?></td>
			<td>
				<a href="working.php">AC1</a>
				<a href="working.php">AC2</a>
				<a href="working.php">AC3</a>
				<a href="working.php">SL</a>
			</td>
		</tr>
		<?php }?>
	</table>
	<?php }else{?>
		<div align="center" style="margin-top: 80px">
			<h1 align="center">Sorry !! No Trains Available</h1>
		</div>
		<?php }?>

</div>
<?php $stmt->close();?>
>>>>>>> origin/master
