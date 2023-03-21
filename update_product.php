<?php 
session_start();
require 'db_connection.php';
require 'product_edit.php';

if(isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])){
	$user_email = $_SESSION['user_email'];
	$get_user_data = mysqli_query($db_connection, "SELECT * FROM `users` WHERE user_email = '$user_email'");
	$userData =  mysqli_fetch_assoc($get_user_data);
} else {
	header('Location: logout.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Product Edit</title>
	<link rel="stylesheet" href="style.css" media="all" type="text/css">
</head>
<body>
	<?php
	if(isset($success_message)){
		echo '<div class="success_message">'.$success_message.'</div>'; 
	}
	if(isset($error_message)){
		echo '<div class="error_message">'.$error_message.'</div>'; 
	}
	?>
	<form action="" method="post" enctype="multipart/form-data">
		<h2>Product Edit</h2>
		<div class="container">
		
			<label for="productname"><b>Product</b></label>
			<input type="text" placeholder="Enter Product Name" id="productname" name="product_name" value="<?php echo $get_product['product_name'];?>" required>
			
			<label for="productprice"><b>Price</b></label>
			<input type="number" placeholder="Enter Product Name" id="productprice" name="product_price" value="<?php echo $get_product['product_price'];?>"  required>
			
			<label for="productimage"><b>Images</b></label>
			<input type="file" id="productimages" name="product_image" class="form-control">
			<img src="<?php echo 'product_image/'. $get_product['product_image'];?>" alt="<?php echo $get_product['product_name'];?>" width="200" /><br/>

			<label for="productimage"><b>Product detail Images</b></label><br/>
			<input type="file" id="productdetails_images" name="productdetails_images[]" class="form-control" multiple>
			<?php $product_details_image = explode(',', $get_product['productdetails_images']);?>
			<?php foreach($product_details_image as $rst){?>
				<img src="<?php echo 'product_image/'. $rst;?>" alt="<?php echo $rst;?>" width="150" />
			<?php } ?>

			<button type="submit">Submit</button>
			<a href="product_list.php" class="regbtnl">Back</a>
		</div>
	</form>
</body>
</html>