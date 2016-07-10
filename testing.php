<?php 
class app{
	
	private $filename='', $file;
    private $user_data=array();
    
    public $link,$user_name,$pw,$host,$dbname='user_info';
	public $query_creat_table="CREATE TABLE `user_info`.`users` ( `number` INT NOT NULL AUTO_INCREMENT , `name` CHAR(11) NOT NULL , `surname` CHAR(11) NOT NULL , `email` CHAR(30) NOT NULL , PRIMARY KEY (`number`), UNIQUE (`email`)) ENGINE = InnoDB;";//set the query as a var for future change if needed
   
    
	public function db_connect_mysqli(){
		
		if($this->user_name==''||$this->pw==''||$this->host==''){
			echo " please enter all database information!\n";
		}
		else{
			$this->link=mysqli_connect( $this->host,  $this->user_name,  $this->pw, 'user_info'); //connect to the database
			if (!$this->link) {
		
				printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error()); 
				exit; 
			}
		}
		//$this->link->query($this->query_creat_table);
	}
	
	
	
	
	
	
	
	
	
	
	
	
    public function print_file_name(){
	    echo 'file name is '.$this->filename;
    }//testing
    
    public function set_file_name($input_data){
	    $this->filename=$input_data;
    }
    public function set_file(){
	    
	    $file = fopen($this->filename,'r');
	    fgetcsv($file);//get rid of the first row" name , surname, and email"

		while ($data = fgetcsv($file)) { 
		
			$userdata_list[] = $data;
			$data[0]=ucfirst(strtolower($data[0]));
			$data[1]=ucfirst(strtolower($data[1]));
			$data[2]=strtolower($data[2]);
			
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $data[2])) {
				 
				 echo  'Wrong Email Format For User: '. $data[0].' '. $data[1]; 
				 
				 }
			//print_r($data);
		}
	    
    }
    
}	



echo "enter something";

$input= trim(fgets(STDIN, 1024));
//echo 'input is'.$input;
//$appctrl->set_file_name($input);
$appctrl=new app;//creat an object
$appctrl->set_file_name($input);
$appctrl->print_file_name();
$appctrl->set_file();//save the data of the fiel into an array

//echo "$appctrl->query_creat_table";
$appctrl->user_name='user_admin';
$appctrl->pw='11111';
$appctrl->host='localhost';
$appctrl->db_connect_mysqli();
$appctrl->link->query($appctrl->query_creat_table);


