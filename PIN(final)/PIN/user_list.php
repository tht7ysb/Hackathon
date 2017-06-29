<?php 
    ob_start();
	session_start();
	include "connect_to_mysql.php"; 



	if (isset($_GET['deleteid'])) {   // delete user
		$id_to_delete = $_GET['deleteid'];
		$sql = mysqli_query($link,"DELETE FROM user WHERE User_ID='$id_to_delete' LIMIT 1") or die (mysql_error());
		
		header("location: user_list.php"); 
		exit();
	}


	if (isset($_POST['user_name'])) {
	
		$user_name = mysqli_real_escape_string($link,$_POST['user_name']);
		$user_password = mysqli_real_escape_string($link,hash( 'sha256',$_POST['user_password']));
		$user_type = mysqli_real_escape_string($link,$_POST['user_type']);
		
		$sql_string = "SELECT user_id FROM user WHERE U_Name='$user_name' LIMIT 1";
		echo $sql_string;
		$sql = mysqli_query($link,$sql_string);
		$userMatch = mysqli_num_rows($sql); 
		if ($userMatch > 0) {
			echo 'Sorry you tried to place a duplicate "User Name" into the system, <a href="user_list.php">click here</a>';
			exit();
		}

		$sql = mysqli_query($link,"INSERT INTO user (U_Name, U_Password, U_Login_date, U_Type) 
	    VALUES('$user_name','$user_password',now(),'$user_type')") or die (mysql_error());
	    $pid = mysqli_insert_id($link);
		
		header("location: user_list.php"); 
		exit();
	}

	$user_list = "";
	
	$user_list .= '<table class="admin" width="100%" border="0"  >
					<tr>
						<th width=auto>User Name</th>
						<th width=auto>Login Date</th>
						<th width=auto>User Type</th>
						<th width=auto></th>					
						';
					
					
			
	
	$sql = mysqli_query($link,"SELECT `User_ID`, `U_Name`, `U_Password`, `U_Login_date`, `U_Type` FROM `user` WHERE U_Type IN ('Admin','User') ORDER BY U_Login_date DESC ");
	$userCount = mysqli_num_rows($sql); 
	if ($userCount > 0) {
		while($row = mysqli_fetch_array($sql)){ 
            $user_id = $row["User_ID"];
			$user_name = $row["U_Name"];
			$user_logedInDate = $row["U_Login_date"];
			$user_type = $row["U_Type"];
			//$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			
			$user_list .= '
					
			<tr>
				
				<td width="50%" valign="top">' . $user_name . '</td>
				<td style="text-align:center;"> ' . $user_logedInDate  . '</td>
				<td style="text-align:center;"> ' . $user_type .' </td>
				<td style="text-align:center;">
					<a href="user_list.php?deleteid='.$user_id.'">delete</a>
				</td>
			</tr>';
			
		}
		$user_list .= '</table>';
	} 
	else {
		$user_list = "You have no user listed in your store yet";
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User List</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/~ortizj36/PIN/style/styleCheckOut.css" type="text/css" media="screen" />

</head>
<body>
	<div align="center" id="mainWrapper">
	
	<?php include_once("template_header.php");?>
	
	<div id="pageContent">
	

		
		<form action="/~ortizj36/PIN/user_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
			<div>
				<div style="width:68%; float:left; border:1px solid black;">
					<!-- <div class="form-style-2-heading">User's List:</div> -->
					<?php echo $user_list; ?>
				</div>
				
				<!-- <div class="form-style-2-heading">Add New Account:</div> -->
				
				<div style="width:30%; float:right; " >
					<ul style="float:right; margin-right:50px; padding:0px;" class="form-style-1">
						
						<li>
							<label>User Type:</label>
							<select name="user_type" class="field-select">
								<option value="Admin">Administrator</option>
								<option value="User">Employee</option>
							</select>
						</li>
						<li>
							<label>User Name:<span class="required">*</span></label>
							<input type="text" name="user_name" class="field-long" />
						</li>
						<li>
							<label>Password:<span class="required">*</span></label>
							<input type="text" name="user_password" class="field-long" />
						</li>
						<li>
							
							<input type="submit" name="button" id="button" value="Add User" />
						</li>
								
					</ul>
				</div>
			</div>
		</form>
 
		</div>
		<?php include_once("template_footer.php");?>
	</div>
	
</body>
</html>