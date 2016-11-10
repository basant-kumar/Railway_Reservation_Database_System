<?php
session_start();
if(isset($_SESSION['user_name'])!=""){
	header('Location:index.php');
}
include_once('dbconnect.php');
$v='';
$error_message="";
if(isset($_POST['Login'])) {

	$usr = $_POST['username'];
	$passwd = $_POST['password'];
	$sql = "select count(*),first_name from User_Profile where user_name = ? and passwd = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss", $usr, $passwd);
	$result = $stmt->execute();
	$stmt->bind_result($count,$name);
	$stmt->fetch();
	$stmt->close();
	if($count == 1){
		$_SESSION['user_name']=$name;
		//echo $name;
		header("location:index.php");
		
	}
	else{
		$error_message="Please enter correct username or password";
		
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
</head>
<body style=" background-color: #f7f7f7;">
	<h1 align="center" style="color:red ">Login Page</h1>
	<div align="center" style="font-size:20px">
		<form action="login.php" method = "post">
		<pre><b>UserName:</b><input type="text" name="username" placeholder="Username"><br></pre>
		<pre><b>Password:</b><input type="password" name="password" placeholder="Password"><br></pre>
			<input  type="submit" name="Login" value="Login">
			<!--button  formaction="signup.php">SignUp</button-->
		</form>
		<p>New User? <a href="signup.php">SignUp</a></p>
	</div>
	<p align="center" style="font-size: 20px"><span style="color: red"><?php echo $error_message; ?></span></p>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>