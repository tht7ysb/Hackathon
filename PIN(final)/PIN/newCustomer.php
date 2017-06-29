<?php 

	session_start();
	if (!isset($_SESSION["User"])) {
	
	}
	include "connect_to_mysql.php"; 





	
	ini_set('display_errors', '1');




	if (isset($_POST['userName'])) {
	
		$user_Name = mysqli_real_escape_string($link,$_POST['userName']);
		
		
		$sql_string = "SELECT User_ID FROM user WHERE U_Name='$user_Name'";
			
		
		$sqlUser = mysqli_query($link,$sql_string);
		
		$customerMatch = mysqli_num_rows($sqlUser);
			
		
		if ($customerMatch > 0) {
			echo 'Sorry you tried to place a duplicate User Name --' .$user_Name.'-- into the system, <a href="/~ortizj36/PIN/newCustomer.php">click here</a>';
			exit;
		}

		$user_name = mysqli_real_escape_string($link,$_POST['userName']);
		$password = mysqli_real_escape_string($link,hash( 'sha256',$_POST['password']));
	

		$sql_string = "INSERT INTO `user`(`U_Name`, `U_Password`, `U_Login_date`, `U_Type`) VALUES('$user_name','$password',now(),'Customer')";
	


		$sql = mysqli_query($link,$sql_string) or die (mysql_error());
		$user_id = mysqli_insert_id($link);

	
		$last_name = mysqli_real_escape_string($link,$_POST['lastName']);
		$first_name = mysqli_real_escape_string($link,$_POST['firstName']);
		$address = mysqli_real_escape_string($link,$_POST['address']);
		$city = mysqli_real_escape_string($link,$_POST['city']);
		$state = mysqli_real_escape_string($link,$_POST['state']);
		$zip = mysqli_real_escape_string($link,$_POST['zip']);
		$phone = mysqli_real_escape_string($link,$_POST['phone']);
	
		$sql = mysqli_query($link,"INSERT INTO customer (user_id, C_LastName, C_FirstName, C_Address, C_City, C_State, C_Zip, C_Total_Purchased,C_Phone_Number) 
	    VALUES('$user_id', '$last_name','$first_name','$address','$city','$state', '$zip','0','$phone')") or die (mysql_error());
	    $customer_id = mysqli_insert_id($link);
	
		header("location: customerList.php"); 
		exit();
	}
	else{
	//
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Customer</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/~ortizj36/PIN/style/styleCheckOut.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
  
  
	
	

	<div style="margin:auto; width: 70%;">
		<form action="/~ortizj36/PIN/newCustomer.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
			
				<ul style="float:left" class="form-style-1">
					
					<!-- <div class="form-style-2-heading">User Name and</div> -->
					
					
						<li>
												
							<label>Last Name:<span class="required">*</span></label>
							<input type="text" name="lastName" class="field-long" placeholder="Last" required />
						</li>
						<li>
							<label>First Name:<span class="required">*</span></label>
							<input type="text" name="firstName" class="field-long" placeholder="First" required/>
						
						</li>
						<li>
							<label>Address:<span class="required">*</span></label>
							<input type="text" name="address" class="field-long" placeholder="Address"  required/>
						</li>
						
						
				</ul>
				<ul style="float:left" class="form-style-1">
				
					<!-- <div class="form-style-2-heading">Shipping Address</div> -->
					<li>
							<label>City:<span class="required">*</span></label>
							<input type="text" name="city" class="field-long" placeholder="City" required/>
						</li>				
						<li>
							<label>State:<span class="required">*</span></label>
							<select name="state" required>
								<option value="">-- select --</option>
								<option value="NJ">New Jersey</option>
								<option value="NY">New York</option>
								<option value="PA">Pennsylvania</option>
								<option value="CT">Connecticut</option>
							</select>
						</li>
						
						<li>
							<label>Zip:<span class="required">*</span></label>
							<input type="text" name="zip" class="field-long" placeholder="Zip code" required />
						</li>
						<li>
							<label>Phone:<span class="required">*</span></label>
							<input type="text" name="phone" class="field-long" placeholder="Phone Number" required />
						</li>
				</ul>
	
	
		
				<ul style="float:left" class="form-style-1">
					<!-- <div class="form-style-2-heading">LogIn Informaion:</div> -->

					<li>
						<label>User Name:<span class="required">*</span></label>
						<input type="text" name="userName" class="field-long" required/>
					</li>
					<li>
						<label>Password:<span class="required">*</span></label>
						<input type="password" name="password" class="field-long" required/>
					</li>
									
					<li>
						<input type="submit" value="Add Customer"></input>
					</li>
				</ul>
				
				
		</form>
		</div>
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>