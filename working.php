<?php
 include_once 'dbconnect.php';

$stmt = $conn->query('call p1()');
		//$stmt->execute();
		//$stmt->bind_result($stn_code,$stn_name);
		while($result=$stmt->fetch_assoc()){
			echo $result['User_name'].'<br>';
			echo $result['passwd'].'<br>';
			echo $result['first_name'].'<br>';
		}
		$stmt->close();
?>