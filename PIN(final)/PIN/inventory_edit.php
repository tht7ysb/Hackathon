<?php 
	session_start();
		ob_start();
	include "connect_to_mysql.php"; 






// Parse the form data and add inventory item to the system
if (isset($_POST['product_name'])) {
	
	$pid = mysqli_real_escape_string($link,$_POST['thisID']);
    $product_name = mysqli_real_escape_string($link,$_POST['product_name']);
	$price = mysqli_real_escape_string($link,$_POST['price']);

	$details = mysqli_real_escape_string($link,$_POST['details']);
	$in_inventory = mysqli_real_escape_string($link,$_POST['inventory']);
	
	// See if that product name is an identical match to another product in the system
	$update_string = "UPDATE products SET product_name='$product_name', product_price='$price', product_details='$details', in_inventory = '$in_inventory' WHERE id='$pid'";
	echo $update_string;
	$sql = mysqli_query($link,$update_string);
	if ($_FILES['fileField']['tmp_name'] != "") {
	    // Place image in the folder 
	    $newname = "$pid.jpg";
		
		
	    move_uploaded_file($_FILES['fileField']['tmp_name'], "/~ortizj36/PIN/inventory_Images/$newname");
	}
	header("location: inventory_list.php"); 
    exit();
}

// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_GET['pid'])) {
	$targetID = $_GET['pid'];
	//$sql_string = "SELECT * FROM products WHERE id='$targetID' LIMIT 1";
	$sql_string = "SELECT P.product_name, P.product_price, P.product_details,P.in_inventory, C.category_name FROM products AS P, category AS C WHERE P.category_ID = C.category_id AND id='$targetID' LIMIT 1";
	
    $sql = mysqli_query($link,$sql_string);
	
    $productCount = mysqli_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysqli_fetch_array($sql)){ 
             
			 $product_name = $row["product_name"];
			 $price = $row["product_price"];
			 $category = $row["category_name"];
			 $details = $row["product_details"];
			 $inventory = $row["in_inventory"];
			
			 
        }
    } else {
	    echo "Sorry dude that crap dont exist.";
		exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit - <?php echo $product_name; ?></title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/mmastore/style/styleCheckOut.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">

  <?php include_once("template_header.php");?>
  
  <div id="pageContent"><br />
    

   
    <a name="inventoryForm" id="inventoryForm"></a>
    <h3>Edit Inventory Item</h3>
    <form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
    <table width="90%" border="0" cellspacing="0" cellpadding="6">
      <tr>
        <td width="20%" align="right">Product Name</td>
        <td width="80%"><label>
          <input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>" />
        </label></td>
      </tr>
      <tr>
        <td align="right">Product Price</td>
		
        <td>
			<label>
          
				<input name="price" type="text" id="price" size="9" value="<?php echo $price; ?>" />
			</label>
		</td>
      </tr>
		
		<tr>
        <td align="right">Category</td>
		
        <td>
			<label>
          
				<input name="category" type="text" readonly id="Category" size="9" value="<?php echo $category; ?>" />
			</label>
		</td>
      </tr>
  
      <tr>
        <td align="right">Product Details</td>
        <td><label>
          <textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea>
        </label></td>
      </tr>
  
      <tr>
        <td align="right">Product Image</td>
        <td><label>
          <input type="file" name="fileField" id="fileField" />
        </label></td>
      </tr>     
      
      <td align="right">In inventory</td>
		
        <td>
			<label>
          
				<input name="inventory" type="text" id="inventory" size="9" value="<?php echo $inventory; ?>" />
			</label>
		</td>
      </tr>
 
      <tr>
        <td>&nbsp;</td>
        <td><label>
          <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
          <input type="submit" name="button" id="button" value="Update" />
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