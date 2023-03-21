<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$get_product = mysqli_query($db_connection, "SELECT * FROM `product` WHERE `id` = '$id'");
		$get_product =  mysqli_fetch_assoc($get_product);
	}
	
	if(isset($_POST)){

		if(isset($_POST['product_name']) && isset($_POST['product_price'])){
			
			$error=array();
			$extension=array("jpeg","jpg","png","gif");
			
			if(!empty($_FILES["product_image"]["name"])){
				$file_name = $_FILES["product_image"]["name"];
				$file_tmp = $_FILES["product_image"]["tmp_name"];
				$ext = pathinfo($file_name,PATHINFO_EXTENSION);
				
				if(in_array($ext,$extension)) {
						$filename = basename($file_name,$ext);
						$newFileName = 'prod_'.rand(0,100).strtotime(date('Y-m-d H:i:s')).".".$ext;
						move_uploaded_file($file_tmp=$_FILES["product_image"]["tmp_name"],"product_image/".$newFileName);
						$product_image = $newFileName;
				} else {
					array_push($error,"$file_name, ");
					$error_message = $error;
				}
			} else {
				$product_image = $get_product['product_image'];
			}
			
			if(!empty($_FILES["productdetails_images"]["tmp_name"])){
				$product_detail_image = array();
				foreach($_FILES["productdetails_images"]["tmp_name"] as $key => $tmp_name) {
					$file_name_1 = $_FILES["productdetails_images"]["name"][$key];
					$file_tmp_1 = $_FILES["productdetails_images"]["tmp_name"][$key];
					$ext_1 = pathinfo($file_name_1,PATHINFO_EXTENSION);

					if(in_array($ext_1,$extension)) {
						$filename_n1 = basename($file_name_1,$ext_1);
						$newFileName_n1 = 'proddetails_'.rand(0,100).strtotime(date('Y-m-d H:i:s')).".".$ext_1;
						move_uploaded_file($file_tmp = $_FILES["productdetails_images"]["tmp_name"][$key],"product_image/".$newFileName_n1);
						$product_detail_image[] = $newFileName_n1;
					}
					else {
						array_push($error,"$file_name, ");
					}
				}
				$productdetails_images = implode(',', $product_detail_image);
			} else {
				$productdetails_images = $get_product['productdetails_images'];
			}
		
			$product_name = $_POST['product_name'];
			$product_price = $_POST['product_price'];
			
			if(!empty($_FILES["product_image"]["name"])){
				if (file_exists('product_image/'.$get_product['product_image'])) { unlink('product_image/'.$get_product['product_image']); }
			}
			if(!empty($_FILES["productdetails_images"]["tmp_name"])){
				$product_details_image = explode(',', $get_product['productdetails_images']);
				foreach($product_details_image as $pdtimg){
					if (file_exists('product_image/'.$pdtimg)) { unlink('product_image/'.$pdtimg); }
				}
			}
			
			$insert_user = mysqli_query($db_connection, "UPDATE `product` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_image` = '$product_image', `productdetails_images` = '$productdetails_images' WHERE id = $id");
			
			$get_product = mysqli_query($db_connection, "SELECT * FROM `product` WHERE `id` = '$id'");
			$get_product =  mysqli_fetch_assoc($get_product);

			if($insert_user === TRUE){
				$success_message = "Product added successfully.";
				header('Location: update_product.php?id='.$id);
				exit;
			} else {
				$error_message = "Oops! something wrong.";
			}
		
			
		}
	}
	

?>