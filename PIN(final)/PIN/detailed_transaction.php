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

$customer_list = "";  // view customer list
$transacation_list = "" ;

$transaction_ID = $_GET["tranID"];

$sql_str = "SELECT b.productID, b.quantity, b.transactionID FROM `productbought` as b WHERE `transactionID` = $transaction_ID";
$sql = mysqli_query($link,$sql_str);

$transactionCount = mysqli_num_rows($sql);


//$sql_string = "SELECT c.customer_id, c.user_id, c.C_LastName, c.C_FirstName, c.C_Address, c.C_City, c.C_State, c.C_Zip, c.C_Total_Purchased, U.U_Login_date FROM `customer` as c, `user` as u WHERE c.user_id = u.user_id ORDER BY U.U_Login_date DESC";
//$sql = mysql_query($sql_string);
$transactionCount = mysqli_num_rows($sql); // count rows
if ($transactionCount > 0) {
	$customer_list .= '<table class="inventory" id="customer_list" width="100%" border="0" cellspacing="0" cellpadding="6">
		<tr>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Product Name</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Unit Price</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>Quantity</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong>All Together</strong></td>
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong></strong></td>		
			<td width=auto bgcolor="#1f1f1f"><font color="white"><strong></strong></td>			
			
		</tr>';
	
	
	
		while($row = mysqli_fetch_array($sql)){ 



            $productID = $row["productID"];


            $sql_string = "SELECT p.product_price,p.product_name FROM products as p WHERE id = $productID ";
            $sql_2 = mysqli_query($link,$sql_string);
            $tran_row = mysqli_fetch_array($sql_2);
            $productName = $tran_row["product_name"];
            $productPrice = $tran_row["product_price"];



			$quantity = $row["quantity"];
			$TotalForItem = $quantity*$productPrice;
			
			 							
			$customer_list .= 	'<tr>							
				<td>' .$productName . '</td>
				<td>' .'$'.$productPrice . '</td>
				<td>' . $quantity . '</td>
				<td>' . '$'.number_format($TotalForItem,2) . '</td>
				
				
				
					
				
			</tr>';								
		}

		

		$sql_string = "SELECT t.TotalAmount FROM transaction as t WHERE tranID = $transaction_ID";
		$sql_2 = mysqli_query($link,$sql_string);
		$tran_row = mysqli_fetch_array($sql_2);
		$Total_Amount =$tran_row["TotalAmount"];

		$shippingAmount = "15.00";
		if ($Total_Amount > "100.00") {
			$shippingAmount = "0.00";
		}
		$subTotal = ($Total_Amount-$shippingAmount) / 0.9;

		$discount = $subTotal*.1;

		$customer_list .= 	'<tr>							
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>' .'Sub Total'. '</td>
				<td>' .'$'.number_format($subTotal,2). '</td>	
			</tr>';
		$customer_list .= 	'<tr>							
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>' .'Shipping Amount'. '</td>
				<td>' .'$'.number_format($shippingAmount,2). '</td>	
			</tr>';	
		$customer_list .= 	'<tr>							
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>' .'Discount'. '</td>
				<td>' .'$'.number_format($discount,2). '</td>	
			</tr>';	
		$customer_list .= 	'<tr>							
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>' .'Total'. '</td>
				<td>' .'$'.number_format($Total_Amount,2). '</td>	
			</tr>';	



		$customer_list .= '</table>';
	} 
else {
	$customer_list = "You have no customer listed in your store yet";
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