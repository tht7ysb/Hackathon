<?php 
	session_start();
	include "connect_to_mysql.php"; 
    ob_start();



	$category_list = "";

	$category_list .= '<tr>
						<td align="right">Category</td>
						<td><select name="category" id=category">
						<option value=""></option>';

	$sql = mysqli_query($link,"SELECT `category_id`, `category_name` FROM `category`");
	 
	$categoryCount = mysqli_num_rows($sql); 
	if ($categoryCount > 0) {
		while($row = mysqli_fetch_array($sql)){ 
            $category_id = $row["category_id"];
			$category_name = $row["category_name"]; 
			$category_list .= '<option value="'.$category_id.'">'.$category_name.'</option>';
		}
		$category_list .= '</select></td></tr>';
	} 
	



	if (isset($_GET['deleteid'])) {   // delete product
		$id_to_delete = $_GET['deleteid'];
		$sql = mysqli_query($link,"DELETE FROM products WHERE id='$id_to_delete' LIMIT 1") or die (mysqli_error());
		$pictodelete = ("../inventory_Images/$id_to_delete.jpg");
		if (file_exists($pictodelete)) {
       		unlink($pictodelete);
		}
		header("location: inventory_list.php"); 
		exit();
	}


	if (isset($_POST['product_name'])) {
	
		$product_name = mysqli_real_escape_string($link,$_POST['product_name']);
		$price = mysqli_real_escape_string($link,$_POST['price']);
		$category = mysqli_real_escape_string($link,$_POST['category']);
		$category_id = mysqli_real_escape_string($link,$_POST['category']);
		$details = mysqli_real_escape_string($link,$_POST['details']);
		$in_inventory = mysqli_real_escape_string($link,$_POST['inventory']);
		echo "$in_inventory";
		
		$sql = mysqli_query($link,"SELECT id FROM products WHERE product_name='$product_name' LIMIT 1");
		$productMatch = mysqli_num_rows($sql); 
		if ($productMatch > 0) {
			echo 'Sorry you tried to place a duplicate "Product Name" into the system, please try again <a href="/~ortizj36/PIN/inventory_list.php">click here</a>';
			exit();
		}

		$sql = mysqli_query($link,"INSERT INTO products (product_name, product_price, product_details, category, category_id, date_added,in_inventory) 
	    VALUES('$product_name','$price','$details','$category','$category_id',now(),'$in_inventory')") or die (mysqli_error($link));
	    $pid = mysqli_insert_id($link);

		$newname = "$pid.jpg"; // load image
		move_uploaded_file( $_FILES['fileField']['tmp_name'], "/~ortizj36/PIN/inventory_Images/$newname");
		header("location: inventory_list.php"); 
		exit();
	}






	$product_list = "";
	$sql = mysqli_query($link,"SELECT * FROM products ORDER BY product_name ASC");
	$productCount = mysqli_num_rows($sql); 
	if ($productCount > 0) {
		$product_list .= '<table class="inventory" width="100%" border="0" cellspacing="0" cellpadding="6">';
		while($row = mysqli_fetch_array($sql)){ 
            $id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["product_price"];
			$count = $row["in_inventory"];
			$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			$product_list .= 
			'<tr>
				<td width="17%" valign="top"><a href="/~ortizj36/PIN/Inventory.php?id=' . $id . '"><img style="border:#666 1px solid;" src="/~ortizj36/PIN/inventory_Images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
				<td width="83%" valign="top">' . $product_name . '<br />
				$' . $price . '<br />
				In Invenotry : ' . $count . '<br />
				<a href="/~ortizj36/PIN/Inventory.php?id=' . $id . '">View Product Details</a></td>
				<td>
					<a class="buttons" href="/~ortizj36/PIN/inventory_edit.php?pid='.$id.'">edit</a> 
				</td>
				<td>
					<a class="buttons" href="/~ortizj36/PIN/inventory_list.php?deleteid='.$id.'">delete</a>
				</td>
			</tr>';
			
		}
		$product_list .= '</table>';
	} 
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory List</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/~ortizj36/PIN/style/styleCheckOut.css" type="text/css" media="screen" />

</head>
<body>
	<div align="center" id="mainWrapper">
	<?php include_once("template_header.php");?>
	<div id="pageContent"><br />
		<div align="right" style="margin-right:32px;"><a  class="buttonsRed" href="/~ortizj36/PIN/inventory_list.php#inventoryForm">+ Add New Product</a></div>
		<div align="left" style="margin-left:24px;">
			<h2>Product Inventory </h2>
			<?php echo $product_list; ?>
		</div>
		
		<a name="inventoryForm" id="inventoryForm"></a>
		
		<img src="/~ortizj36/PIN/images/inventoryForm.jpg">
		
		</br>
		
		
		
		<form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
		<tr>
			<td width="20%" align="right">Product Name</td>
			<td width="80%"><label>
			<input name="product_name" type="text" id="product_name" size="64"  title="" required  />
			</label></td>
		</tr>
		<tr>
			<td align="right">Product Price $</td>
			<td><label>
			<input name="price" type="text" id="price" size="12" pattern="[0-9]+" title="Numbers only" required  />
			</label></td>
		</tr>

		<?php echo $category_list; ?>
	    
		<tr>
			<td align="right">Product Details</td>
			<td><label>
			<textarea name="details" id="details" cols="64" rows="5" pattern="[A-Za-z0-9]+" title="" required  ></textarea>
			</label></td>
		</tr>
		<tr>
			<td align="right">Inventory Count</td>
			<td><label>
			<input name="inventory" type="text" id="inventory" size="12" pattern="[0-9]+" title="Numbers only" required  />
			</label></td>
		</tr>
		<tr>
			<td align="right">Product Image</td>
			<td><label>
			<input type="file" name="fileField" id="fileField" />
			</label></td>
		</tr>      
		<tr>
			<td>&nbsp;</td>
			<td><label>
			<input type="submit" name="button" id="button" value="Add Product" />
			</label></td>
		</tr>
		</table>
    </form>
    <br />
	<br />
	</div>
		<?php include_once("template_footer.php");?>
	</div>
</body>
</html>