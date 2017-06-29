<?php
	
	$homeMenu = "";
	$menu = "";
	$shoppingCartMenu = "";
	$adminmenu = ""; 
	$adminUser = "";

	
$customer_name	='';
	
if (isset($_SESSION["user_type"])) {	
	
	$user_type = $_SESSION["user_type"];
		
	if (isset($_SESSION["customer_name"])) {		
		$customer_name = $_SESSION["customer_name"]; 
	}
	
	if ($user_type=="Customer"){
		//$menu = '<li><a href="/mmastore/customerList.php">Customer List</a></li>';
		$homeMenu = '<li> <a href="/~ortizj36/PIN/index.php">Home</a> </li>';
		$searchMenu = '<li> <a href="/~ortizj36/PIN/search.php">Search</a> </li>';
		$pastTransactionsMenu = '<li> <a href="/~ortizj36/PIN/pastTransactions.php">Past Transactions</a> </li>';
		$shoppingCartMenu = '<li><a href="/~ortizj36/PIN/cart.php" align="right" >Your Shopping Cart</a></li>';
		
		}
	elseif ($user_type=="User"){
	
		$menu .= '<li><a href="/~ortizj36/PIN/customerList.php">Customer List</a></li>';
		$menu .= '<li><a href="/~ortizj36/PIN/transactionList.php">Transaction List</a></li>';
	
//		$customer_name = $_SESSION["customer_name"]; 
		}
	elseif ($user_type=="Admin"){
		//$menu .= '<li><a href="/mmastore/admin/index.php">Admin</a></li>';
		$adminmenu .= '<li><a href="/~ortizj36/PIN/user_list.php" align="right" >Admin</a></li>';
		}
	elseif ($user_type=="Owner"){
		//$menu .= '<li><a href="/mmastore/admin/index.php">Admin</a></li>';
		$adminmenu .= '<li><a href="/~ortizj36/PIN/inventory_list.php" align="right" >Inventory List</a></li>';
		}
}			
	


?>
<div id="pageHeader">
	<img src="/~ortizj36/PIN/images/Header2.jpg"  />
</div>
<div id="pageMenu">


		<div class="menu">			
			<ul>
				
				<?php echo $homeMenu; ?>
				
				<?php echo $menu; ?>
				
				<?php echo $searchMenu; ?>
				
				<?php echo $shoppingCartMenu; ?>
				
				<?php echo $pastTransactionsMenu; ?>
				
				<?php echo $adminmenu ?>
				
				<li>
					<a href="/~ortizj36/PIN/logoff.php" align="right" >Logout</a>
					
				</li>
								
				
				<li >
					<div><?php echo $customer_name; ?></div>
				</li>
			</ul>
			
		</div>
		
		<div>
			
		</div>
</div>

