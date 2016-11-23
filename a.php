<?php
session_start();
include 'dbconnect.php';

if(isset($_POST['submit'])){
	$pnr_no = $p_name = $p_age = $p_gen = $p_seat_no = $p_coach = $p_status = "";
	$pnr_no = $_POST['pnr_no'];
	$sql  = "select * from passenger where prn_no = ?";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param('i',$pnr_no);
	$stmt->execute();
	$stmt->bind_result($pnr_no,$p_name,$p_age,$p_gen,$p_seat_no,$p_coach,$p_status);
}
if(isset($_POST['submit2'])){
	$pnr_no = $p_name = $p_age = $p_gen = $p_seat_no = $p_coach = $p_status = "";
	$pnr_no = $_POST['pnr_no'];
	$sql  = "select * from passenger where prn_no = ?";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param('i',$pnr_no);
	$stmt->execute();
	$cnt = 0;
	$stmt->bind_result($pnr_no,$p_name,$p_age,$p_gen,$p_seat_no,$p_coach,$p_status);
	if(!empty($_POST['check_list'])){
	// Loop to store and display values of individual checked checkbox.
		foreach($_POST['check_list'] as $cnt){
			echo $cnt;
		}
	}
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Ticket Cancellation</title>
</head>
<body> 
<?php if(!isset($_POST['submit'])) {?>
<div align="center">
<form method="POST" action=cancel_ticket.php>
	<input type="text" name="pnr_no" placeholder="PNR No">
	<input type="submit" name="submit">
</form>
</div>
<?php } else {?>
<div align="center">
	<h4>Check the ticket to be cancelled"</h4>
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
				<td><input type="checkbox" name="check_list[]" value=<?php echo $counter; $counter=$counter+1;?>>
				</td>
				<td><?php echo $p_name; ?></td>\
				<td><?php echo $p_age; ?></td>
				<td><?php echo $p_gen; ?></td>
				<td><?php echo $p_seat_no; ?></td>
				<td><?php echo $p_coach; ?></td>
				<td><?php echo $p_status; ?></td>
			</tr>
			<?php }?>
		</table>
		<input type="hidden" name="pnr_no" value = <?php echo $pnr_no; ?> >
		<input type="submit" name="submit2">
	</form>
</div>

</body>
</html>