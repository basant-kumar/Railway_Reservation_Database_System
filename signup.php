<?php
session_start();
	if(isset($_SESSION['user_name'])){
		header("Location:index.php");
	}
include_once('dbconnect.php');	

$error=false;
if(isset($_POST['signup'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$user_name=$_POST['username'];
	$passwd=$_POST['password'];
	$cpasswd=$_POST['cpassword'];
	$dob=$_POST['dob'];
	$email=$_POST['email'];
	$gender=$_POST['gender'];
	$mobile=$_POST['mobile'];
	if ($fname=="" || !preg_match("/^[a-zA-Z ]+$/",$fname)) {
        $error = true;
        $name_error = "Name must contain only alphabets and space";
    }
    if ($lname=="" || !preg_match("/^[a-zA-Z ]+$/",$lname)) {
        $error = true;
        $name_error = "Name must contain only alphabets and space";
    }
    if($email=="" || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please Enter Valid Email ID";
    }
    if($user_name=="" || strlen($user_name) < 6) {
        $error = true;
        $user_name_error = "Username must be minimum of 6 digits";
    }
    if($passwd=="" || strlen($passwd) < 6) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters";
    }
    if($cpasswd=="" || $passwd != $cpasswd) {
        $error = true;
        $cpassword_error = "Password and Confirm Password doesn't match";
    }
    if($mobile=="" || strlen($mobile) < 10) {
        $error = true;
        $mobile_error = "Invaild Mobile No";
    }
	
    if(!$error){
    	$query="insert into User_Profile(user_name,passwd,first_name,last_name,gender,email,mobile,dob) 
    			values('" .$user_name. "','" .$passwd. "','" .$fname. "','" .$lname. "','" .$gender. "','" .$email. "','" .$mobile ."','" .$dob.  "') ";
    	if(mysqli_query($conn,$query)){
    		$successmsg="Successfully Registered !<a href='login.php'>Click here to Login</a>";
    	}else{
    		$errormsg="Username already exists...";
			$errormsg2 = "GO BACK..!!!";
    	}
    }
	else $errormsg2 = "GO BACK..!!!";

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>SignUp Page</title>
</head>
<body style=" background-color: #f7f7f7;">
	<h1 align="center" style="color:red ">SignUp Page</h1>
	<form action="signup.php" method="POST">
	<div align="center" style="font-size: 20px;">
		<table>
			<tr>
				<td>First Name</td>
				<td><input type="text" name="fname" placeholder="First Name" >
					<span><?php if(isset($name_error)) echo $name_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input type="text" name="lname" placeholder="Last Name" ">
				<span><?php if(isset($name_error)) echo $name_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Username</td>
				<td><input type="text" name="username" placeholder="Username" ">
				<span><?php if(isset($user_name_error)) echo $user_name_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" placeholder="Password" >
				<span><?php if(isset($password_error)) echo $password_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Confirm-Password</td>
				<td><input type="password" name="cpassword" placeholder="Confirm-Password" >
				<span><?php if(isset($cpassword_error)) echo $cpassword_error;?></span>	
				</td>
			</tr>
			<tr>
				<td>Date of Birth</td>
				<td><input type="date" name="dob" placeholder="dd-mm-yyyy"></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="email" name="email" placeholder="E-mail" >
				<span><?php if(isset($email_error)) echo $email_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Mobile No</td>
				<td><input type="mobile" name="mobile" placeholder="Mobile No" >
				<span><?php if(isset($mobile_error)) echo $mobile_error;?></span>
				</td>
			</tr>
			<tr>
				<td>Gender</td>
				<td><select name="gender">
					    <option value="male">Male</option>
						<option value="female">Female</option>
						<option value="other">Other</option>
				   </select>
				</td>
			</tr>
			
		</table><br>
		<input  type="submit" name="signup" value="SignUp">
	</div>
	</form>
	<div align="center" style="font-size:20px">
		<p align="center">Already have Account? <a href="login.php">Login</a></p>
		<span ><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
	    <span ><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		<span ><?php if (isset($errormsg2)) { echo $errormsg2; } ?></span>
	</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>