# php

create db "login_registration"

table :
-------
users
	user_id Primary	int(11)	AUTO_INCREMENT
	username varchar(255)	utf8_general_ci	
	user_email	varchar(255)	utf8_general_ci		
	user_password	varchar(255)	utf8_general_ci
	create_at	datetime	No	current_timestamp()	
	update_at	datetime	No	current_timestamp()		ON UPDATE CURRENT_TIMESTAMP()

product
	id Primary	int(11)	AUTO_INCREMENT
	product_name	varchar(255)	utf8_general_ci
	product_price	decimal(12,2)	
	product_image	varchar(255)	utf8_general_ci
	productdetails_images	varchar(255)	utf8_general_ci
	create_at	datetime	No	current_timestamp()	
	update_at	datetime	No	current_timestamp()		ON UPDATE CURRENT_TIMESTAMP()"
