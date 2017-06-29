<?php 

session_start();
if (!isset($_SESSION["User"])) {
	
    if(isset($_POST['insert'])){
     $message= $_POST['select_customer'];

    }
    if(isset($_POST['select_customer'])){
		$message=$_POST['select_customer'];
		$_SESSION["customer_id"] = $id;  
    }    
}

include "connect_to_mysql.php"; 

$customer_list = "";  // view customer list
$sql_string = "SELECT c.customer_id, c.user_id, c.C_LastName, c.C_FirstName, c.C_Address, c.C_City, c.C_State, c.C_Zip, c.C_Total_Purchased, u.U_Login_date FROM `customer` as c, `user` as u WHERE c.user_id = u.User_ID ORDER BY u.U_Login_date DESC";
$sql = mysqli_query($link,$sql_string);
$customerCount = mysqli_num_rows($sql); // count rows
if ($customerCount > 0) {
	$customer_list .= '<table class="inventory" id="customer_list" width="100%" border="0" cellspacing="0" cellpadding="6">
		<tr>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Last Name</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>First Name</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Address</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>City</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>State</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Zip</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Total	</strong></td>									
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong><a class="buttonsAdd" href="newCustomer.php" >Add</a></strong></td>
		</tr>';
	
	
	
		while($row = mysqli_fetch_array($sql)){ 
            $customer_id = $row["customer_id"];
			$C_LastName = $row["C_LastName"];
			$C_FirstName = $row["C_FirstName"];
			$C_Address = $row["C_Address"];
			$C_City = $row["C_City"];
			$C_State = $row["C_State"];
			$C_Zip = $row["C_Zip"];
			$C_Total_Purchased = $row["C_Total_Purchased"];
			$U_Login_date = $row["U_Login_date"];
			 							
			$customer_list .= 	'<tr>							
				<td>' . $C_LastName . '</td>
				<td>' . $C_FirstName . '</td>
				<td>' . $C_Address . '</td>
				<td>' . $C_City . '</td>
				<td>' . $C_State . '</td>
				<td >' . $C_Zip . '</td>
				<td style="float:center">' . '$ ' . $C_Total_Purchased .'</td>						
				<td></td>
			</tr>';								
		}
		$customer_list .= '</table>';
	} 
else {
	$customer_list = "You have no customer listed in your store yet";
}

if (isset($_GET['customerID'])) {
	$targetID = $_GET['customerID'];
	
    $sql = mysqli_query($link,"SELECT C_FirstName, C_LastName FROM customer WHERE customer_id='$targetID' LIMIT 1");
    $customerCount = mysqli_num_rows($sql); 
    if ($customerCount > 0) {
	    while($row = mysqli_fetch_array($sql)){ 
             
			$_SESSION["customer_id"] = $targetID;
			$_SESSION["customer_name"] = 'Customer - ' . $row["C_FirstName"] . ' ' . $row["C_LastName"];		 
			header("location: category.php"); 
			exit();
        }
    } 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customer List</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
	
<?php include_once("template_header.php");?>
 
	<div id="pageContent">
	<?php  echo $_SESSION["customer_id"]; echo $customer_list; ?>
		</div>
		<?php include_once("template_footer.php");?>
		</div>
</body>
</html>