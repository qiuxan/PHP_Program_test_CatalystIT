<?php
	
$link = mysqli_connect( 'localhost',  'user',  'password', 'world'); //connect to the database

if (!$link) {
	
	printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error()); 
	exit; 
	
	}
	
	
$file = fopen('users.csv','r'); 

fgetcsv($file);//get rid of the first row" name , surname, and email"

while ($data = fgetcsv($file)) { 

	$userdata_list[] = $data;
	$data[0]=ucfirst(strtolower($data[0]));
	$data[1]=ucfirst(strtolower($data[1]));
	$data[2]=strtolower($data[2]);
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $data[2])) {
		 
		 echo  $data[0].' '. $data[1].' '.'Wrong Email Format!'; 
		 
		 }
	print_r($data);

 }
//array_shift($userdata_list);//delete the first item in the array which is "fname lname and email"
//print_r($userdata_list);
 
?>