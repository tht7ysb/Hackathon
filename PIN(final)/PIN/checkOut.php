<?php 

	session_start();
	include "connect_to_mysql.php"; 
	
	$customer_address = '';
	$customer_totalorder = '';
	$Customer_Total_Purchased = '';
	$Total_Purchased = '';
 
	if (isset($_SESSION["customer_id"])) {

      	$customer_id = $_SESSION["customer_id"]; 
		$sql_string = "SELECT * FROM customer WHERE customer_id = $customer_id LIMIT 1";				
		$sql = mysqli_query($link,$sql_string);
		$customerCount = mysqli_num_rows($sql); 
		  
		if ($customerCount == 1) { 
			while($row = mysqli_fetch_array($sql)){ 
				$firstName = $row["C_FirstName"];
				$lastName = $row["C_LastName"];
				$address = $row["C_Address"];
				$city = $row["C_City"];
				$state = $row["C_State"];
				$zip = $row["C_Zip"];
				$phone =$row["C_Phone_Number"];
				$_SESSION["Total_Purchased"] = '';
				$_SESSION["Total_Purchased"] = $row["C_Total_Purchased"];			 
			}		
			$customer_address .= "$firstName $lastName </br> $address </br> $city $state $zip";
			$customer_totalorder = $_SESSION["totalAmount"];
		}     
	}


	if(isset($_POST['update'])){
// 		echo $_SESSION["Total_Purchased"];
// 		echo '---';
		$Customer_Total_Purchased = $_SESSION["Total_Purchased"];
// 		echo $Customer_Total_Purchased;
// 		echo $customer_totalorder;
		$Total_Purchased = $customer_totalorder + $Customer_Total_Purchased;
		
		$sql_string = "UPDATE `customer` SET `C_Total_Purchased`=$Total_Purchased WHERE `customer_id` = $customer_id";
		$sql = mysqli_query($link,$sql_string);
        
        
		$total = $customer_totalorder;
		
		$i = 0;
		$sql_insert = "INSERT INTO transaction (TotalAmount,customerID) VALUES($total,$customer_id)";

		
		
		$sql = mysqli_query($link,$sql_insert);
		
    

		while(count($_SESSION['cart_array']) > $i){
			 $j = 0;

				$quan = ($_SESSION["copy_cart_array"][$i]["quantity"]);
				$pID = ($_SESSION["copy_cart_array"][$i]["item_id"]);
				$Cid = $_SESSION['id'];
				$sql_in = "INSERT INTO productbought (productID,quantity,transactionID) VALUES($pID,$quan,(SELECT MAX(tranID) FROM transaction))";
				$sql = mysqli_query($link,$sql_in);
				$sql_up = "UPDATE products SET in_inventory = in_inventory - $quan WHERE id =$pID"; 
				$sql = mysqli_query($link,$sql_up);
				
				$j++;

			
				$i++;

		}
        
		if ($customerCount > 0){
		   
			header("location: orderComplete.php"); 
			exit;
		}
		else{
			echo 'error';
		}
	}


	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory List</title>
<link rel="icon" href="images/icon.png"> 	
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style/styleCheckOut.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
		<div id="pageContent">			
			<ul style="float:right; margin-right:100px;"  class="form-style-1">
				<div class="form-style-2-heading">Shipping Address:</div>					
				<?php echo $customer_address; ?>
				&nbsp;
			</br>
			</br>

			</ul>
			<ul style="float:left; margin-left:10px;"  class="form-style-1">
				<div class="form-style-2-heading">Total Order:</div>
				<h3 style="float:center;">$<?php echo money_format($customer_totalorder,2); ?></h3>
			</ul>
						
			<form action="" method="post">
				
				<ul style="float:Center; margin-left:200px;" class="form-style-1">
				<div class="form-style-2-heading">Payment Method:</div>
					<li>
						<label>Select Card:</label>
						<select name="field4" class="field-select">
							<option value="Advertise">Visa</option>
							<option value="Partnership">Master Card</option>
							<option value="Partnership">Amex</option>
						</select>
					</li>
					<li>
						<label>Card Number:<span class="required">*</span></label>
						<input type="text" name="field3" class="field-long" pattern="[A-Za-z-]+" title="Alpha only" required />
					</li>
					<li>
						<label>Card Expiration:<span class="required">*</span></label>
						<select name='expireMM' id='expireMM'>
							<option value=''>Month</option>
							<option value='01'>Janaury</option>
							<option value='02'>February</option>
							<option value='03'>March</option>
							<option value='04'>April</option>
							<option value='05'>May</option>
							<option value='06'>June</option>
							<option value='07'>July</option>
							<option value='08'>August</option>
							<option value='09'>September</option>
							<option value='10'>October</option>
							<option value='11'>November</option>
							<option value='12'>December</option>
						</select> 
						<select name='expireYY' id='expireYY'>
							<option value=''>Year</option>
							<option value='10'>2017</option>
							<option value='11'>2018</option>
							<option value='12'>2019</option>
							<option value='12'>2020</option>
						</select> 
						</li>						
						<li>
							<input name="update" id="update" type="submit" value="Submit" />
						</li>
					</ul>
				</form>			
		</div>

	<?php include_once("template_footer.php");?>
	</div>
</body>
</html>