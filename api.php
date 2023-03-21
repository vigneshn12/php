<?php 
require 'db_connection.php';

if($_GET['get_product']){
	
	$headers = apache_request_headers();
	$authorization = $headers['Authorization'];;
	if($authorization !="kjgkgsdjhagdafha"){
	   http_response_code(404);
	   echo json_encode(array("error" => "Authentication error"));
	   exit;
	}
	$postdata = file_get_contents("php://input");
	$data = json_decode($postdata);
	$id = $data->id;
	$get_product = mysqli_query($db_connection, "SELECT * FROM `product` WHERE `id` = '$id'");
	$get_product =  mysqli_fetch_assoc($get_product);
	if(!empty($get_product)) {
		$get_product_s = array('name' => $get_product['product_name'], 'price' => $get_product['product_price']);
		http_response_code(200);
		echo json_encode($get_product_s, JSON_PRETTY_PRINT);
	} else {
		http_response_code(404);
		echo json_encode(array("Error" => "ID not vaild"));
		exit;
	}
}

if($_GET['fetch_product']){
	
	$data = json_encode(array('id' => '5'));
	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://localhost/task/core/api.php?get_product=yes',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_FOLLOWLOCATION => false,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  //CURLOPT_POSTFIELDS => json_encode($data),
		  CURLOPT_POSTFIELDS => $data,
		  CURLOPT_HTTPHEADER => array(
			'Authorization: kjgkgsdjhagdafha',
			'Content-Type: application/json'
		  ),
		));

		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($err){
			echo "Error #:" .$http_status.' - '. $err;
		} else {
			echo'<pre>'; print_r($response); echo'</pre>';
		}
		exit;
	
}

?>