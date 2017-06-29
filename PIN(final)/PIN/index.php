<?php 

session_start();

$user_type = '';
if (isset($_SESSION["user_type"])) {
   $user_type = $_SESSION["user_type"];

	switch($user_type) {
		case "Customer";
			
			header("location: category.php"); 
			break;
		case "User";
			
			if (isset($_SESSION["customer_id"])) {
				header("location: category.php"); 
			}
			else{
				header("location: customerList.php"); 
			}
			break;		
		case "Admin";
			
			header("location: user_list.php"); 
			break;
		case "Owner";
			
			header("location: inventory_list.php"); 
			break;
	}
}




if (isset($_POST["username"]) && isset($_POST["password"])) {			// verify if username and password is populated

	$username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); // SQL Injection - will filter everything except numbers and letters
    $password = preg_replace('#[^A-Za-z0-9]#i', '', hash( 'sha256', $_POST["password"])); // 

    include "/home/ortizj36/public_html/PIN/connect_to_mysql.php";     //connection to the database
    $sql = mysqli_query($link,"SELECT user_id, u_type FROM user WHERE u_name='$username' AND u_password='$password' LIMIT 1"); // query the username
    
    $existCount = mysqli_num_rows($sql); // verify if account exist
    if ($existCount == 1) { 
	    while($row = mysqli_fetch_array($sql)){ 
            $id = $row["user_id"];
			$type = $row["u_type"];
		}		 		 
		$_SESSION["id"] = $id;
		$_SESSION["user_type"] = $type;
		$_SESSION["password"] = $password;
		 
		if ($_SESSION["user_type"]=="Customer"){   // If usertype is Customer then get Customer_ID
			$sql = mysqli_query($link,"SELECT `customer_id`, `C_LastName`, `C_FirstName` FROM `customer` WHERE user_id = '$id' LIMIT 1"); 
			$existCount = mysqli_num_rows($sql); 
			
			if ($existCount == 1) {
				while($row = mysqli_fetch_array($sql)){ 
				 
					$_SESSION["customer_id"] = $row["customer_id"];
					$_SESSION["customer_name"] = $row["C_FirstName"] . ' ' . $row["C_LastName"];
			 
				}
			}
		}
		header("location: /~ortizj36/PIN/index.php");
		exit();
		 
    } 
	else {
		
		echo " <p align='center'> <font color=red> User Name or Password is incorrect. Please try again";

	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log In </title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/~ortizj36/PIN/login/style.css" type="text/css" media="screen" />

</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header_login.php");?>
  <div id="pageLoginContent">
  
		<div class="lg-container">
		<form action="/~ortizj36/PIN/index.php" id="lg-form" name="lg-form" method="post">
			
			<div>
				<label for="username">Username:</label>
				<input type="text" name="username" required name="username" id="username" placeholder="username"/>
			</div>
			
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" required id="password" placeholder="password" />
			</div>
			
			<div>				
				<button type="submit" id="button">Login</button>
			</div>
			
		</form>
		<div id="message"></div>
	</div>
	 		
    <br />
	<br />
	<br />
  </div>

</div>
</body>
</html>