<?php 
	session_start();
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
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
