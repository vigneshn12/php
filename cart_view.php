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
</head>
<body>
	<div class="container">
		<h2>Shopping Cart</h2>
		<a id="btnEmpty" href="addtocart.php?action=empty" style="text-align: right;width: 100%;display: inline-block;">Empty Cart</a>
		<div id="shopping-cart">
			<?php
				if(isset($_SESSION["cart_item"])){
					$total_quantity = 0;
					$total_price = 0;
			?>
			<table class="cart" cellpadding="10" cellspacing="1" border='1'>
				<tbody>
					<tr>
						<th style="text-align:left;" width="15%">Image</th>
						<th style="text-align:left;">Product</th>
						<th style="text-align:right;" width="5%">Quantity</th>
						<th style="text-align:right;" width="10%">Unit Price</th>
						<th style="text-align:right;" width="10%">Price</th>
						<th style="text-align:center;" width="5%">Remove</th>
					</tr>
					
					<?php foreach ($_SESSION["cart_item"] as $k => $item){ $item_price = $item["quantity"] * $item["price"]; ?>
					<tr>
						<td><img src="<?php echo 'product_image/'.$item["image"]; ?>" class="cart-item-image" width="100" /></td>
						<td><?php echo $item["name"]; ?></td>
						<td style="text-align:right;">
							<form method='post' action='addtocart.php?action=update&id=<?php echo $item["id"]; ?>' style="border: none;">
							<input type="text" class="product-quantity" name="quantity" value="<?php echo $item["quantity"]; ?>" size="2" onChange="this.form.submit()" />
							</form>
						</td>
						<td style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
						<td style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
						<td style="text-align:center;"><a href="addtocart.php?action=remove&id=<?php echo $item["id"]; ?>" class="btnremove">remove</a></td>
					</tr>
				<?php
					$total_quantity += $item["quantity"];
					$total_price += ($item["price"]*$item["quantity"]);
				} ?>
					<tr>
						<td colspan="2" align="right">Total:</td>
						<td align="right"><?php echo $total_quantity; ?></td>
						<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		<?php } else {?>
				<div class="no-records" style="text-align: center;border: 1px solid;padding: 20px;margin: 20px 0;">Your Cart is Empty</div>
		<?php } ?>
		</div>
	</div>
</body>
</html>

