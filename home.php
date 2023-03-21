<?php
	session_start();
	require 'db_connection.php';
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
<html lang="">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css" media="all" type="text/css">
	<title>Home</title>
<style>
a, a:visited{
color: #0000EE;
}
a:hover{
color: #EE0000;
}

.productrow { display: flex;flex-wrap: wrap; }
.productrow .product-item { width: 24%; padding: 1%; }
.productrow .product-item .product-image img{ height: 220px;object-fit: none;width: 100%; }
.productrow .product-item .product-title{font-weight: 800;text-align: center;}
.productrow .product-item .product-price{font-weight: 600;text-align: center;}
.productrow .product-item input[type=text]{width: auto;padding: 5px;margin: 10px;}
.productrow .product-item .cart-action{text-align: center;}
.cartct {background: #ddd;width: 20px;display: inline-block;border-radius: 50%;text-align: center;vertical-align: super;margin-left: -6px;}
</style>
</head>

<body>
	<div class="container">
		<div class="logot" style="text-align: right;"><a href="logout.php">Logout</a></div>
		<h2>Products</h2>
		
		<div id="shopping-cart">
			<div class="txt-heading">Cart <span class="cartct"><?php if(isset($_SESSION["cart_item"])){  echo '<a href="cart_view.php">'.count($_SESSION["cart_item"]).'</a>'; } else { echo '0'; } ?></span></div>
		</div>
		
		<div class="productrow" style="">
			<?php $get_product = mysqli_query($db_connection, "SELECT * FROM `product`"); 
				if(!empty($get_product->num_rows > 0)) { 
					foreach($get_product as $res) {?>
						<div class="product-item">
							<form method="post" action="addtocart.php?action=add&pid=<?php echo $res["id"]; ?>">
								<div class="product-image"><img src="<?php echo 'product_image/'.$res["product_image"]; ?>"></div>
								<div class="product-tile-footer">
									<div class="product-title"><?php echo $res["product_name"]; ?></div>
									<div class="product-price"><?php echo "$".$res["product_price"]; ?></div>
									<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" />
									<input type="submit" value="Add to Cart" class="btn" /></div>
								</div>
							</form>
						</div>
				<?php }  } else { ?>
					<p class="text-center">No product found</p>
				<?php }  ?>
			
		</div>
	</div>
</body>
</html>