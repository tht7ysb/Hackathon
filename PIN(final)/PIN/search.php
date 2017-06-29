<?php 
	session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>

<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />

</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
	<div id="pageContent">

	<form action="search.php" method="post">
    
    <h2>Search for a product name here</h2><br />
    <input name="search_word" type="text" size="40"><br />
	
    <input type="submit" name="submit" value="Search">
	
  </form>
</div>  
  
<?php

if (isset($_POST["search_word"])) {	

  // create short variable names
  $search_word=trim($_POST['search_word']);
  $productList = "";

  if (!$search_word) {
     echo 'You have not entered search details.  Please try again.';
     exit;
  }

  if (!get_magic_quotes_gpc()){
	$search_word = addslashes($search_word);
  }
  
  include "connect_to_mysql.php"; 

  $query = mysqli_query($link,"SELECT * from products where product_name like '%$search_word%'");

  // count the number of records 
  $searchResult = mysqli_num_rows($query);
  
  echo "<p style='font-weight: bold;'>Number of \"".$search_word."\" found: ".$searchResult."</p>";

	if ($searchResult > 0) {

		$i = '0';
		$row_count = 0;
		$productList .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">';
		
		while($row = mysqli_fetch_array($query)){ 
			$id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["product_price"];
			
			if ($i == '0'){
				$productList .='
				<tr>
					<td  width="15%" valign="top"><a href="product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="inventory_Images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
					<td width="35%" valign="top">' . $product_name . '<br />
					$' . $price . '<br />
					<a href="product.php?id=' . $id . '">View Product Details</a></td>';
				
				$i = '1';
			}
			else{
				$productList .='
					<td width="15%" valign="top"><a href="product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="inventory_Images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
					<td width="35%" valign="top">' . $product_name . '<br />
					$' . $price . '<br />
					<a href="product.php?id=' . $id . '">View Product Details</a></td>';
				$i = '0';
			}
			$row_count++;
			if ($searchResult == $row_count){
						$productList .='</tr>';
					}	
		}
		
		$productList .='</table>';
	} 
	
	?><div align="center" id="mainWrapper">		
		<?php include_once("template_header.php");?>
	<div id="pageContent"><?php
	echo $productList;
	?></div></div><?php
}
	include_once("template_footer.php");
?>
</div>
</body>
</html>