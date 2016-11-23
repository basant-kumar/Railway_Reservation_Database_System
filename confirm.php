<?php
session_start();
include 'dbconnect.php';
		$uname = $_SESSION['user_name'];
		$ffrom=$_SESSION['from'];
		preg_match('#\((.*?)\)#', $ffrom, $from);
		$tto=$_SESSION['to'];
		preg_match('#\((.*?)\)#', $tto, $to);

		$train_name = $_SESSION['train_name'];
		$train_type =$_SESSION['train_type'] ;
		$fat = 	$_SESSION['fat'] ;
		$fdt = 	$_SESSION['fdt'] ;
		$tat = 	$_SESSION['tat'] ;
		$tdt = 	$_SESSION['tdt'] ;
		$dist = 	$_SESSION['dist'] ;
		$tn = 	$_SESSION['tn'] ;
		$cl = 	$_SESSION['cl'];
		$fair = 	$_SESSION['f'] ;
		$date_of_journey =	$_SESSION['d'] ;
		$bs  = $_SESSION['bs'];
		$bs = $bs+1;
		$ts  = $_SESSION['ts'];
		$s_date = $_SESSION['s_date'];

		$error = "";
		$pnr = "";
		$wait_no = 0;
		$status ="";
		$bss = "";
		$bss1 = $bss2 = $bss3 = $bss4 = $bss5 = $bss6 ="";
		$status1 = $status2 = $status3 = $status4 = $status5 = $status6 = "";
		$count = 0;
		$flag = 0;
		$pppp = "";
		$t_fair = 0;
		$seat_no = 0;

		if(isset($_POST['submit']) || isset($_POST['submit2'])){
			
			if($_POST['name1'] =="" || $_POST['age1'] =="" || $_POST['gender1'] == ""){
					$error = "Enter atleast one passenger details ";

			}
			else{
				include "dbconnect.php";
				if(isset($_POST['submit2'])) {
					$flag = 1;
					
					$sql = "insert into tickets (doj,total_fair,train_no,t_class,t_from,t_to,User_name)
						VALUES (?,?,?,?,?,?,?)";
					$stmt = $conn->prepare($sql);
					$t_fair = $fair*$_POST['count'];
					$stmt->bind_param("siissss",$date_of_journey,$t_fair,$tn,$cl,$from[1],$to[1],$uname);
					$stmt->execute();
					$stmt->close();

					$sql = "select pnr_no from tickets where User_name = ? and doj = ? and t_from = ? and t_to = ?";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param("ssss",$uname,$date_of_journey,$from[1],$to[1]);
					$stmt->execute();
					$stmt->bind_result($pnr);
					$stmt->fetch();
					$stmt->close();
					$_SESSION['pnr_no'] = $pnr;
				}
				

				
				if($bs>$ts){

					$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param('iss',$tn,$s_date,$cl);
					$stmt->execute();
					$stmt->bind_result($seat_no);
					if($stmt->fetch()){
						$bss = $seat_no;
						$status = "Confirm";
						$stmt->close();
						if(isset($_POST['submit2'])){
							if($cl == "AC1"){
								$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('is',$tn,$s_date);
								$stmt->execute();
							}
							if($cl == "AC2"){
								$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('is',$tn,$s_date);
								$stmt->execute();
							}
							if($cl == "AC3"){
								$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('is',$tn,$s_date);
								$stmt->execute();
							}
							if($cl == "Sleeper"){
								$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('is',$tn,$s_date);
								$stmt->execute();
							}

							$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
							$stmt->execute();
						}
					}
					else{
						$wait_no = $bs-$ts;
						$bss = "";
						$status = "Waiting(".$wait_no.")";
					}
					$status1 = $status;
					$bss1 = $bss;
				}
				else{
					$status = "Confirm";
					$bss = $bs;
					$status1 = $status;
					$bss1 = $bss;
				}
				if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name1'],$_POST['age1'],$_POST['gender1'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
				}

					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					$stmt->close();

				$bs = $bs+1;
				$count = $count+1;

				$pppp = $pppp." <tr>";
				$pppp = $pppp." <td>".$_POST['name1']."</td>";
				$pppp = $pppp." <td>".$_POST['age1']."</td>";
				$pppp = $pppp." <td>".$_POST['gender1']."</td>";
				$pppp = $pppp." </tr>";


				if($_POST['name2'] !="" && $_POST['age2'] !="" && $_POST['gender2'] != ""){
					if($bs>$ts){
						$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('iss',$tn,$s_date,$cl);
						$stmt->execute();
						$stmt->bind_result($seat_no);
						if($stmt->fetch()){
							$bss = $seat_no;
							$status = "Confirm";
							$stmt->close();
							if(isset($_POST['submit2'])){
								if($cl == "AC1"){
									$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC2"){
									$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC3"){
									$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "Sleeper"){
									$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}

									$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
									$stmt->execute();
							}
						}
						else{
							$wait_no = $bs-$ts;
							$bss = "";
							$status = "Waiting(".$wait_no.")";
						}
						$status2 = $status;
						$bss2 = $bss;
					}
					else{
						$status = "Confirm";
						$bss = $bs;
						$status2 = $status;
						$bss2 = $bss;
					}
					if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name2'],$_POST['age2'],$_POST['gender2'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
					}
					
					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					$stmt->close();
					$bs = $bs+1;
					$count = $count+1;
					$pppp = $pppp." <tr>";
					$pppp = $pppp." <td>".$_POST['name2']."</td>";
					$pppp = $pppp." <td>".$_POST['age2']."</td>";
					$pppp = $pppp." <td>".$_POST['gender2']."</td>";
					$pppp = $pppp." </tr>";

				}
				if($_POST['name3'] !="" && $_POST['age3'] !="" && $_POST['gender3'] != ""){
					if($bs>$ts){
						$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('iss',$tn,$s_date,$cl);
						$stmt->execute();
						$stmt->bind_result($seat_no);
						if($stmt->fetch()){
							$bss = $seat_no;
							$status = "Confirm";
							$stmt->close();

							if(isset($_POST['submit2'])){
								if($cl == "AC1"){
									$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC2"){
									$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC3"){
									$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "Sleeper"){
									$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}

									$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
									$stmt->execute();
							}
						}
						else{
							$wait_no = $bs-$ts;
							$bss = "";
							$status = "Waiting(".$wait_no.")";
						}
						$status3 = $status;
						$bss3 = $bss;
					}
					else{
						$status = "Confirm";
						$bss = $bs;
						$status3 = $status;
						$bss3 = $bss;
					}
					if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name3'],$_POST['age3'],$_POST['gender3'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
					}

					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}

					$stmt->close();
					$bs = $bs+1;
					$count = $count+1;
					$pppp = $pppp." <tr>";
					$pppp = $pppp." <td>".$_POST['name3']."</td>";
					$pppp = $pppp." <td>".$_POST['age3']."</td>";
					$pppp = $pppp." <td>".$_POST['gender3']."</td>";
					$pppp = $pppp." </tr>";
				}
				if($_POST['name4'] !="" && $_POST['age4'] !="" && $_POST['gender4'] != ""){
					if($bs>$ts){
						$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('iss',$tn,$s_date,$cl);
						$stmt->execute();
						$stmt->bind_result($seat_no);
						if($stmt->fetch()){
							$bss = $seat_no;
							$status = "Confirm";
							$stmt->close();

							if(isset($_POST['submit2'])){
								if($cl == "AC1"){
									$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC2"){
									$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC3"){
									$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "Sleeper"){
									$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}

									$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
									$stmt->execute();
							}
						}
						else{
							$wait_no = $bs-$ts;
							$bss = "";
							$status = "Waiting(".$wait_no.")";
						}
						$status4 = $status;
						$bss4 = $bss;
					}
					else{
						$status = "Confirm";
						$bss = $bs;
						$status4 = $status;
						$bss4 = $bss;
					}
					if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name4'],$_POST['age4'],$_POST['gender4'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
					}


					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					$stmt->close();
					$bs = $bs+1;
					$count = $count+1;
					$pppp = $pppp." <tr>";
					$pppp = $pppp." <td>".$_POST['name4']."</td>";
					$pppp = $pppp." <td>".$_POST['age4']."</td>";
					$pppp = $pppp." <td>".$_POST['gender4']."</td>";
					$pppp = $pppp." </tr>";
				}
				if($_POST['name5'] !="" && $_POST['age5'] !="" && $_POST['gender5'] != ""){
					if($bs>$ts){
						$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('iss',$tn,$s_date,$cl);
						$stmt->execute();
						$stmt->bind_result($seat_no);
						if($stmt->fetch()){
							$bss = $seat_no;
							$status = "Confirm";
							$stmt->close();

							if(isset($_POST['submit2'])){
								if($cl == "AC1"){
									$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC2"){
									$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC3"){
									$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "Sleeper"){
									$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}

									$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
									$stmt->execute();
							}
						}
						else{
							$wait_no = $bs-$ts;
							$bss = "";
							$status = "Waiting(".$wait_no.")";
						}
						$status5 = $status;
						$bss5 = $bss;
					}
					else{
						$status = "Confirm";
						$bss = $bs;
						$status5 = $status;
						$bss5 = $bss;
					}
					if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name5'],$_POST['age5'],$_POST['gender5'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
					}


					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					$stmt->close();
					$bs = $bs+1;
					$count = $count+1;
					$pppp = $pppp." <tr>";
					$pppp = $pppp." <td>".$_POST['name5']."</td>";
					$pppp = $pppp." <td>".$_POST['age5']."</td>";
					$pppp = $pppp." <td>".$_POST['gender5']."</td>";
					$pppp = $pppp." </tr>";
				}
				if($_POST['name6'] !="" && $_POST['age6'] !="" && $_POST['gender6'] != ""){
					if($bs>$ts){
						$sql = "select seat_no from cancel_tickets where train_no= ? and c_doj = ? and coach = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('iss',$tn,$s_date,$cl);
						$stmt->execute();
						$stmt->bind_result($seat_no);
						if($stmt->fetch()){
							$bss = $seat_no;
							$status = "Confirm";
							$stmt->close();

							if(isset($_POST['submit2'])){
								if($cl == "AC1"){
									$sql = "update status set bs_ac1 = bs_ac1 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC2"){
									$sql = "update status set bs_ac2 = bs_ac2 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "AC3"){
									$sql = "update status set bs_ac3 = bs_ac3 - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}
								if($cl == "Sleeper"){
									$sql = "update status set bs_sl = bs_sl - 1 where train_no = ? and a_date = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param('is',$tn,$s_date);
									$stmt->execute();
								}

									$sql = "delete from cancel_tickets where train_no = ? and c_doj = ? and coach = ? and seat_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("issi", $tn,$s_date,$cl,$seat_no);
									$stmt->execute();
							}
						}
						else{
							$wait_no = $bs-$ts;
							$bss = "";
							$status = "Waiting(".$wait_no.")";
						}
						$status6 = $status;
						$bss6 = $bss;
					}
					else{
						$status = "Confirm";
						$bss = $bs;
						$status6 = $status;
						$bss6 = $bss;
					}
					if(isset($_POST['submit2'])){
						$sql = "insert into passenger values(?,?,?,?,?,?,?,?,?)";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('isisisiss',$pnr,$_POST['name6'],$_POST['age6'],$_POST['gender6'],$bss,$cl,$tn,$s_date,$status);
						$stmt->execute();
					}

					if($cl == "AC1"){
						$sql = "select bs_ac1 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC2"){
						$sql = "select bs_ac2 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "AC3"){
						$sql = "select bs_ac3 from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					if($cl == "Sleeper"){
						$sql = "select bs_sl from status where train_no = ? and a_date = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('is',$tn,$s_date);
						$stmt->execute();
						$stmt->bind_result($bs);
						$stmt->fetch();
					}
					$stmt->close();
					$bs = $bs+1;
					$count = $count+1;
					$pppp = $pppp." <tr>";
					$pppp = $pppp." <td>".$_POST['name5']."</td>";
					$pppp = $pppp." <td>".$_POST['age5']."</td>";
					$pppp = $pppp." <td>".$_POST['gender5']."</td>";
					$pppp = $pppp." </tr>";
				}
				if($flag == 1){
					//$_SESSION['pnr_no'] = $pnr_no;
					//echo "<script type='text/javascript'>alert('Transaction Successful');</script>";
					header('Location:transaction_successful.php');
				}
				$t_fair = $fair*$count;
			}
			
		}
		
		
?>



<!DOCTYPE html>
<html>
<head>
	<title>Confimation Page</title>
</head>
<link rel="stylesheet" type="text/css" href="css/index.css" ></link>
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


<div>
<table align="center"  align="center" style="margin-top: 10px;border-collapse: collapse;">
	<form action=confirm.php method="POST">
		<tr>
			<td> <input type="hidden" name="name1" value=<?php echo $_POST['name1']?>> </td>
			<td> <input type="hidden" name="age1" value=<?php echo $_POST['age1']?>> </td>
			<td> <input type="hidden" name="gender1" value=<?php echo $_POST['gender1']?>> </td>
		</tr>
		<tr>
			<td> <input type="hidden" name="name2" value=<?php echo $_POST['name2']?>> </td>
			<td> <input type="hidden" name="age2" value=<?php echo $_POST['age2']?>> </td>
			<td> <input type="hidden" name="gender2" value=<?php echo $_POST['gender2']?>> </td>
		</tr>
		<tr>
			<td> <input type="hidden" name="name3" value=<?php echo $_POST['name3']?>> </td>
			<td> <input type="hidden" name="age3" value=<?php echo $_POST['age3']?>> </td>
			<td> <input type="hidden" name="gender3" value=<?php echo $_POST['gender3']?>> </td>
		</tr>
		<tr>
			<td> <input type="hidden" name="name4" value=<?php echo $_POST['name4']?>> </td>
			<td> <input type="hidden" name="age4" value=<?php echo $_POST['age4']?>> </td>
			<td> <input type="hidden" name="gender4" value=<?php echo $_POST['gender4']?>> </td>
		</tr>
		<tr>
			<td> <input type="hidden" name="name5" value=<?php echo $_POST['name5']?>> </td>
			<td> <input type="hidden" name="age5" value=<?php echo $_POST['age5']?>> </td>
			<td> <input type="hidden" name="gender5" value=<?php echo $_POST['gender5']?>> </td>
		</tr>
		<tr>
			<td> <input type="hidden" name="name6" value=<?php echo $_POST['name6']?>> </td>
			<td> <input type="hidden" name="age6" value=<?php echo $_POST['age6']?>> </td>
			<td> <input type="hidden" name="gender6" value=<?php echo $_POST['gender6']?>> </td>
		</tr>
		<input type="hidden" name="count" value=<?php echo $count; ?> >
		
	</table>
	<?php if(!$error) {?>
	<p align="center">Total Fair: <?php echo $t_fair; ?> </p>
	<table align="center">
		<tr align="left">
			<th> Name</th>
			<th> Age </th>
			<th> Gender </th>
		</tr>
		<?php echo $pppp; ?>
	</table>
	<p align="center"><input type="submit" name="submit2" value="Click here to pay"></p>
	<?php } else echo $error; ?>
	</form>
</div>

</body>
</html>