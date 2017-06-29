<?php 
session_start();
include "connect_to_mysql.php"; 

$pid = $_GET['pid'];
$product_list = "";
$sql = mysqli_query($link,"SELECT * FROM products WHERE category_id = " . $pid . " ORDER BY product_name ASC");
$productCount = mysqli_num_rows($sql); // count the number of records 
if ($productCount > 0) {

	$i = '0';
	$row_count = 0;
	$product_list .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">';
	while($row = mysqli_fetch_array($sql)){ 
            $id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["product_price"];
			
			if ($i == '0'){
				$product_list .='
				<tr>
					<td  width="15%" valign="top"><a href="/~ortizj36/PIN/product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="/~ortizj36/PIN/inventory_Images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
					<td width="35%" valign="top">' . $product_name . '<br />
					$' . $price . '<br />
					<a href="/~ortizj36/PIN/product.php?id=' . $id . '">View Product Details</a></td>';
				
				$i = '1';
				
				
			}
			else{
				$product_list .='
					<td width="15%" valign="top"><a href="/~ortizj36/PIN/product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="/~ortizj36/PIN/inventory_Images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
					<td width="35%" valign="top">' . $product_name . '<br />
					$' . $price . '<br />
					<a href="/~ortizj36/PIN/product.php?id=' . $id . '">View Product Details</a></td>';
				$i = '0';
			}
			$row_count++;
			if ($productCount == $row_count){
						$product_list .='</tr>';
					}
			
    }
	$product_list .='</table>';
	
	
} 
else {
	//$product_list = "You have no products listed in your store yet";
	$product_list = '<img src="/~ortizj36/PIN/images/products.jpg"  />';
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Product List</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
</head>

<body>

	<div align="center" id="mainWrapper">
		<?php include_once("template_header.php");?>
		<div id="pageContent">
		
			<?php echo $product_list; ?>
		</div>
		
		<?php include_once("template_footer.php");?>
	</div>
   
  
	
</div>
</body>
</html>