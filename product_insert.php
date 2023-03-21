<?php
	if(isset($_POST)){

		if(isset($_POST['product_name']) && isset($_POST['product_price'])){
			
			$error=array();
			$extension=array("jpeg","jpg","png","gif");
						
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
				} else {
					array_push($error,"$file_name, ");
				}
			}
			$productdetails_images = implode(',', $product_detail_image);
			$product_name = $_POST['product_name'];
			$product_price = $_POST['product_price'];
			
			$insert_user = mysqli_query($db_connection, "INSERT INTO `product` (product_name, product_price, product_image, productdetails_images) VALUES ('$product_name', '$product_price', '$product_image', '$productdetails_images')");
			
			$get_lstid = mysqli_query($db_connection, "SELECT * FROM `product` ORDER BY `id` DESC");
			$get_lstid =  mysqli_fetch_assoc($get_lstid);
			$id = $get_lstid['id'];

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