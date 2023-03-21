<?php 
session_start();

require 'db_connection.php';

if(!empty($_GET["action"])) { 

	if($_GET["action"] == 'add') {
		
		if(!empty($_POST["quantity"])) {
			
			$pid = $_GET["pid"];
			$result = mysqli_query($db_connection,"SELECT * FROM product WHERE id='$pid'");
			
			while($product = mysqli_fetch_array($result)){
				$itemarray = array($product["id"]=> array('name'=>$product["product_name"], 'id'=>$product["id"], 'quantity'=>$_POST["quantity"], 'price'=>$product["product_price"], 'image'=>$product["product_image"]));
				if(!empty($_SESSION["cart_item"])) {
					if(in_array($product["id"],array_keys($_SESSION["cart_item"]))) {
						foreach($_SESSION["cart_item"] as $k => $v) {
							if($product["id"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemarray);
					}
				}  else {
					$_SESSION["cart_item"] = $itemarray;
				}
			}
		}
		header('Location: home.php');
		exit;
	}
	
	if($_GET["action"] == 'update') {
		
		if(!empty($_POST["quantity"])) {
			if(!empty($_SESSION["cart_item"])) {
				
			  foreach($_SESSION['cart_item'] as $k => $v) {
				if($_GET["id"] == $v['id']) {
					$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					break;
				}
			  }
			}
		}
		header('Location: cart_view.php');
		exit;
	}
	if($_GET["action"] == 'remove') {
		
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
				if($_GET["id"] == $v['id']) {
					unset($_SESSION["cart_item"][$k]);
				}
				if(empty($_SESSION["cart_item"])) {
					unset($_SESSION["cart_item"]);
				}
			}
		}
		header('Location: cart_view.php');
		exit;
	}
	
	
	if($_GET["action"] == 'empty') {
		unset($_SESSION["cart_item"]);
		header('Location: cart_view.php');
		exit;
	}	
	

}
?>