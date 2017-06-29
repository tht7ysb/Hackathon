<?php 

session_start();
//echo $_SESSION["user_type"]; 

if ($_SESSION["user_type"]=="User"){
	//echo $_SESSION["customer_name"]; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Home Page</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
</head>
<body>

<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  
  <div id="pageContent">
  
	<a href="/~ortizj36/PIN/product_list.php?pid=1">
		<img src="/~ortizj36/PIN/images/Jerseys.jpg" />
	</a>
		
	<a href="/~ortizj36/PIN/product_list.php?pid=2">
		<img src="/~ortizj36/PIN/images/Boots copy.jpg"  />
	</a>
	
	<a href="/~ortizj36/PIN/product_list.php?pid=3">
		<img src="/~ortizj36/PIN/images/Balls copy.jpg"  />
	</a>
	
	<a href="/~ortizj36/PIN/product_list.php?pid=4">
		<img src="/~ortizj36/PIN/images/GK.jpeg"  />
	</a>
	
	<a href="/~ortizj36/PIN/product_list.php?pid=5">
		<img src="/~ortizj36/PIN/images/Accessory.jpg"  />
	</a>
	
	
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>