<?php 
	session_start(); 
	include "connect_to_mysql.php"; 
	if (isset($_SESSION["cart_array"])) {
		unset($_SESSION["cart_array"]);
		
	}

	//echo $_SESSION["customer_id"];
	
?>

<?php 

	if (isset($_POST['pid'])) {
		$pid = $_POST['pid'];
		$wasFound = false;
		$i = 0;

		if (!isset($_SESSION["copy_cart_array"]) || count($_SESSION["copy_cart_array"]) < 1) { 
	   
			$_SESSION["copy_cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
		} 
		else {

			foreach ($_SESSION["copy_cart_array"] as $each_item) { 
				$i++;
				while (list($key, $value) = each($each_item)) {
					if ($key == "item_id" && $value == $pid) {
						array_splice($_SESSION["copy_cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
						$wasFound = true;
					} 
				} 
			} 
			if ($wasFound == false) {
			   array_push($_SESSION["copy_cart_array"], array("item_id" => $pid, "quantity" => 1));
			}
		}
		header("location: cart.php"); 
		exit();
	}
?>
<?php 

if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") { // empty shopping cart
    unset($_SESSION["copy_cart_array"]);
}
?>


<?php

if (isset($_SESSION["customer_id"])) {
	$customer_id = $_SESSION["customer_id"];  			
		$sql_string = "SELECT C_Total_Purchased FROM customer WHERE customer_id = $customer_id LIMIT 1";				
		$sql = mysqli_query($link,$sql_string);
		$customerCount = mysqli_num_rows($sql); 
		  
		if ($customerCount == 1) { 
			while($row = mysqli_fetch_array($sql)){ 
				$total_Purchased = $row["C_Total_Purchased"];
				
				
			}
		}		
						
		    
}
?>
<?php 

	if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {   // calculate if product adjustments are made
		$item_to_adjust = $_POST['item_to_adjust'];
		$quantity = $_POST['quantity'];
		$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
		if ($quantity >= 100) { 
			$quantity = 99; 
		}
		if ($quantity < 1) { 
			$quantity = 1; 
		}
		if ($quantity == "") { 
			$quantity = 1; 
		}
		$i = 0;
		foreach ($_SESSION["copy_cart_array"] as $each_item) { 
		    $i++;
		    while (list($key, $value) = each($each_item)) {
				if ($key == "item_id" && $value == $item_to_adjust) {
					array_splice($_SESSION["copy_cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				} 
		    } 
		} 
	}
?>

<?php 

	if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {   // removal of products 

		$key_to_remove = $_POST['index_to_remove'];
		if (count($_SESSION["copy_cart_array"]) <= 1) {
			unset($_SESSION["copy_cart_array"]);
		} 
		else {
			unset($_SESSION["copy_cart_array"]["$key_to_remove"]);
			sort($_SESSION["copy_cart_array"]);
		}
	}
?>
<?php 

	$cartOutput = "";
	$cartTotal = "";
	$cartTotalToShow = "";
	
	$cartTotalToShowTable = '';
	$pp_checkout_btn = '';
	$product_id_array = '';
	$shippingAmountToShow = "";
	$totalAmount = "";
	$totalAmountToShow = "";
	$shoppingCartButton = "";
	$discount = '0';
	$_SESSION["copy_copy_cart_array"] = $_SESSION["copy_cart_array"];
	
	if (!isset($_SESSION["copy_cart_array"]) || count($_SESSION["copy_cart_array"]) < 1) {
		$cartOutput = '<img src="/~ortizj36/PIN/images/shoppingCart.jpg"  />';
		$shoppingCartButton = "";
	
	} 
	else {
		
		$shoppingCartButton = '<a class="buttons" href="/~ortizj36/PIN/checkOut.php"  style="float:right"><b>Checkout Now</b></a>';
		$i = 0; 
		$cartOutput .= "<h1>Thank You For Shopping with us!!";
		foreach ($_SESSION["copy_cart_array"] as $each_item) { 
			$item_id = $each_item['item_id'];
			$sql = mysqli_query($link,"SELECT * FROM products WHERE id='$item_id' LIMIT 1");
			while ($row = mysqli_fetch_array($sql)) {
				$product_name = $row["product_name"];
				$price = $row["product_price"];
				$details = $row["product_details"];
			}
			$pricetotal = $price * $each_item['quantity'];
			$cartTotal = $pricetotal + $cartTotal;
			setlocale(LC_MONETARY, "en_US");
			$x = $i + 1;
			$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
			<input type="hidden" name="amount_' . $x . '" value="' . $price . '">
			<input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';

			$product_id_array .= "$item_id-".$each_item['quantity'].","; 

			//$cartOutput .= "<a href='cart.php?cmd=emptycart'>Click Here to Empty Your Shopping Cart</a>";
			$cartOutput .= "<tr>";
			$cartOutput .= '<td><a href="/~ortizj36/PIN/product.php?id=' . $item_id . '">' . $product_name . '</a><br /><img src="/~ortizj36/PIN/inventory_Images/' . $item_id . '.jpg" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
			$cartOutput .= '<td>' . $details . '</td>';
			$cartOutput .= '<td>$' . number_format($price,2) . '</td>';
			$cartOutput .= '<td><form action="cart.php" method="post">
			 ' . $each_item['quantity'] . '
			
			<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
			</form></td>';

			$cartOutput .= '<td>' .'$'.number_format($pricetotal,2) . '</td>';
			
			$cartOutput .= '</tr>';
			$i++; 
		} 
		
		
		
		//$cartTotalToShow = "<div style='font-size:18px; margin-top:30px; margin-left:43%'> Sub Total : $ ".$cartTotal." </div>";
		
		/*
		echo $cartTotal;
		echo sprintf("%10.2n", $cartTotal);
		echo '$' . number_format($cartTotal, 2);
		$cartTotalToShow = sprintf("%10.2n", $cartTotal);
		echo $cartTotalToShow;
		exit;
		*/
		
		$_SESSION["cart_total"] = $cartTotal ;
	
		//calculate shipping
		$shippingAmount = "15.00";
		if ($cartTotal > "100.00") {
			$shippingAmount = "0.00";
		}
		
		
	
			$discount = $cartTotal * 0.1;
			
		
		
		
		
		
		//$shippingAmountToShow = "<div style='font-size:18px; margin-top:12px; margin-left:36%'>Shipping Amount : $ ".number_format($shippingAmount,2)." </div>";
		$totalAmount = $cartTotal + $shippingAmount - $discount;
		
		
		$cartTotalToShowTable.= '<table class="checkOut" border="0" style="float:right" >
									<tr>
										<td style="text-align:right">Sub Total:</td>
										<td>' . '$' . number_format($cartTotal, 2) . '</td>
										<td></td>
									</tr>
									<tr>
										<td style="text-align:right">Shipping Amount:</td>
										<td>' . '$' . number_format($shippingAmount, 2) . '</td>
										<td style="text-align:left; font-size:16px; color:#a89898;">&nbsp;&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:right">Discount:</td>
										<td>' . '$' . number_format($discount, 2) . '</td>
										<td style="text-align:left; font-size:16px; color:#a89898;">&nbsp;&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:right;">Total Amount:</td>
										<td>' . '$' . number_format($totalAmount, 2) . '</td>
										<td></td>
									</tr>
									<tr>
										
										
										<td></td>
										<td></td>
										
									</tr>
								</table>';
		
		//$totalAmount = sprintf("%10.2n", $totalAmount);
		
		
		$totalAmountToShow = "<div style='font-size:18px; margin-top:12px; margin-left:40%;'>Total Amount : $ ".$totalAmount."</div>";
		
		$_SESSION["totalAmount"] = $totalAmount;
		
		
		


	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Cart</title>

<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />

</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
	<div id="pageContent">
		<div style="text-align:left;">
		<table width="100%" border="1" cellspacing="0" cellpadding="6">
		<tr>
			<td width="18%" bgcolor="#aea08e" color="white" ><strong>Product</strong></td>
			<td width="45%" bgcolor="#aea08e"><strong>Product Description</strong></td>
			<td width="10%" bgcolor="#aea08e"><strong>Unit Price</strong></td>
			<td width="9%" bgcolor="#aea08e"><strong>Quantity</strong></td>
			<td width="9%" bgcolor="#aea08e"><strong>Total</strong></td>
			
		</tr>
	  
		<?php echo $cartOutput; ?>
			<tr>
				<td colspan="6" style="text-align:right">
					<?php echo $cartTotalToShowTable; ?>
					
				</td>
			</tr>
		</table>	
		
		<?php // echo $cartTotalToShow; ?>	
		<?php //echo $shippingAmountToShow; ?>
		<?php //echo $totalAmountToShow; ?>
		
 
  

 
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>

