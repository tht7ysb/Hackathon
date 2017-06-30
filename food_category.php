<?php 

session_start();
//echo $_SESSION["user_type"]; 



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Home Page</title>
<link rel="stylesheet" href="/~ortizj36/PIN/style/style.css" type="text/css" media="screen" />
</head>
<body>
 <?php include_once("template_header.php");?>
<div align="center" id="mainWrapper">
  
  <div id="pageContent">
  
	<a href="food_list.php?cid=1">
		<img src="images/Sandwiches.jpg" />
	</a>
		
	<a href="food_list.php?cid=2">
		<img src="images/GenericSalad.jpg"  />
	</a>
	
	<a href="food_list.php?cid=3">
		<img src="images/Soup.jpg"  />
	</a>
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>