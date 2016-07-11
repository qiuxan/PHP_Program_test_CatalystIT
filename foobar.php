
<?php
	
	for($i=1;$i<101;$i++){
		//$temp=$i;
		
		if($i%3==0&&$i%5!=0){
			$temp='foo';	
		}
		else if($i%5==0&&$i%3!=0){
			$temp='bar';
		}
		else if($i%5==0&&$i%3==0){
			$temp='foobar';
		}
		else{
			$temp=$i;
		}
		$data=$data.$temp.", ";
}

 
$data = substr($data,0,strlen($data)-2); 
echo $data; 

 
?>