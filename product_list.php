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
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Product List</title>
	<link rel="stylesheet" href="style.css" media="all" type="text/css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Product List</h2>
                        <a href="create_product.php" class="btn btn-success pull-right" style="float: right;"><i class="fa fa-plus"></i> Add Product</a>
                    </div>
					<?php $get_product = mysqli_query($db_connection, "SELECT * FROM `product`");?>
					
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Price</th>
									<th>Thumbnail</th>
									<th>Details img</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php if(!empty($get_product->num_rows > 0)) { ?>
								<?php foreach($get_product as $res) {?>
								<tr>
									<td><?=$res['id'];?></td>
									<td><?=$res['product_name'];?></td>
									<td><?=$res['product_price'];?></td>
									<td><img src="product_image/<?=$res['product_image'];?>" width="100px" /></td>
									<td>
										<?php $product_details_image = explode(',', $res['productdetails_images']);?>
										<?php foreach($product_details_image as $rst){?>
											<img src="product_image/<?=$rst;?>" width="100px" />
										<?php } ?>
									</td>
									<td>
										<a href="<?php echo 'update_product.php?id='. $res['id']?>" class="mr-3">Edit</a>
										<a href="<?php echo 'product_delete.php?id='. $res['id']?>" class="mr-3">Delete</a>
									</td>
								</tr>
								<?php } ?>
							<?php } else {?>
								<tr>
									<td class="alert alert-danger text-center" colspan="6"><em>No records found.</em></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					
                </div>
            </div>        
        </div>
    </div>
</body>
</html>