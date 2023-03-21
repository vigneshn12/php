<?php
session_start();
require 'db_connection.php';

if(isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])){
	$user_email = $_SESSION['user_email'];
	$get_user_data = mysqli_query($db_connection, "SELECT * FROM `users` WHERE user_email = '$user_email'");
	$userData =  mysqli_fetch_assoc($get_user_data);
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$get_product = mysqli_query($db_connection, "SELECT * FROM `product` WHERE `id` = '$id'");
		$get_product =  mysqli_fetch_assoc($get_product);
		
		if (file_exists('product_image/'.$get_product['product_image'])) { unlink('product_image/'.$get_product['product_image']); }
		$product_details_image = explode(',', $get_product['productdetails_images']);
		foreach($product_details_image as $pdtimg){
			if (file_exists('product_image/'.$pdtimg)) {  unlink('product_image/'.$pdtimg); }
		}
		
		mysqli_query($db_connection, "DELETE FROM `product` WHERE `id` = '$id'");
		
		$success_message = "Product added successfully.";
		header('Location: product_list.php');
		exit;
		
	}
	
} else {
	header('Location: logout.php');
	exit;
}
	
?>