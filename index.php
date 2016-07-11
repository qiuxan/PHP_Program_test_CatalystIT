<?php
	
$link = mysqli_connect( 'localhost',  'user_admin',  '11111', 'users'); //connect to the database


if (!$link) {
	
	printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error()); 
	exit; 
	
	}
	
	$table='users';
	$query="SHOW TABLES LIKE 'users'";
	
	//echo $query;
		$result = $link ->query($query);
		echo $result->num_rows;

 
?>