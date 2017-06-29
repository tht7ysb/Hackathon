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
?>
	
<?php 
$c_id = $_SESSION['customer_id'];
$customer_list = "";
$transacation_list = "" ;

$sql_str = "SELECT t.tranID,t.TotalAmount,t.customerID FROM `transaction` as t  WHERE t.customerID  = $c_id  ORDER BY t.tranID DESC ";
$sql = mysqli_query($link,$sql_str);

$transactionCount = mysqli_num_rows($sql);

$sql_string = "SELECT c.C_Address ,c.C_City,c.C_State,c.C_Zip FROM `customer` as c WHERE c.customer_id = $c_id LIMIT 1";
$sql2 = mysqli_query($link,$sql_string);
$row2 = mysqli_fetch_array($sql2);

//$sql_string = "SELECT c.customer_id, c.user_id, c.C_LastName, c.C_FirstName, c.C_Address, c.C_City, c.C_State, c.C_Zip, c.C_Total_Purchased, U.U_Login_date FROM `customer` as c, `user` as u WHERE c.user_id = u.user_id ORDER BY U.U_Login_date DESC";
//$sql = mysql_query($sql_string);
$transactionCount = mysqli_num_rows($sql); // count rows
if ($transactionCount > 0) {
	$customer_list .= '<table class="inventory" id="customer_list" width="100%" border="0" cellspacing="0" cellpadding="6">
		<tr>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Adress</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>City</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>State</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Zip</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>transaction ID</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Total Amount</strong></td>
								
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong></strong></td>
		</tr>';
	
	
	
		while($row = mysqli_fetch_array($sql)){ 
            $customerID = $row["customerID"];
			$tranID = $row["tranID"];
			$TotalAmount = $row["TotalAmount"];
			$C_Address = $row2["C_Address"];
			$C_City = $row2["C_City"];
			$C_State = $row2["C_State"];
			$C_Zip = $row2["C_Zip"];


			
			
			 							
			$customer_list .= 	'<tr>
				<td>' . $C_Address . '</td>
				<td>' . $C_City . '</td>
				<td>' . $C_State . '</td>
				<td>' . $C_Zip . '</td>
				<td>' . $tranID . '</td>
				<td>' .'$'. number_format($TotalAmount,2) . '</td>

				
				
					
				<td><a href="detailed_transaction.php?tranID='.$tranID.'">View Details</a></td>
			</tr>';								
		}
		$customer_list .= '</table>';
	} 
else {
	$customer_list = "There are no previous transactions";
}
?>


<?php 

if (isset($_GET['tranID'])) {
	$targetID = $_GET['tranID'];
    $sql = mysqli_query($link,"SELECT tranID, FROM transaction WHERE tranID='$targetID' LIMIT 1");
    $customerCount = mysqli_num_rows($sql); 
    echo "here";
    if ($customerCount > 0) {
	    while($row = mysqli_fetch_array($sql)){ 
             
			$_SESSION["tranID"] = $targetID;
			$_SESSION["customer_name"] = 'Customer - ' . $row["C_FirstName"] . ' ' . $row["C_LastName"];		 
			header("location: detailed_transaction.php"); 
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
  
	<!-- <a href="newCustomer.php" style="float:right">Add Customer</a>  -->
	
	<div id="pageContent">
	<?php echo $customer_list; ?>
		</div>
		<?php include_once("template_footer.php");?>
		</div>
</body>
</html>