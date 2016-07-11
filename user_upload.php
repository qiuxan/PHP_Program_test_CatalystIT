<?php 
class app{
	
	private $filename='', $file;
    private $user_data=array();
    
    public $link,$user_name,$pw,$host,$dbname;
	
	public $query_creat_table="CREATE TABLE `user_info`.`users` ( `number` INT NOT NULL AUTO_INCREMENT , `name` CHAR(11) NOT NULL , `surname` CHAR(11) NOT NULL , `email` CHAR(30) NOT NULL , PRIMARY KEY (`number`), UNIQUE (`email`)) ENGINE = InnoDB;";//set the query as a var for future change if needed
   
    
	public function db_connect_mysqli(){
		
		if($this->user_name==''||$this->pw==''||$this->host==''){
			echo " please enter all database information!\n";
		}
		else{
			$this->link=mysqli_connect( $this->host,  $this->user_name,  $this->pw, $this->dbname); //connect to the database
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
	    $query="SHOW TABLES LIKE 'users'";
	    $file = fopen($this->filename,'r');
	    fgetcsv($file);//get rid of the first row" name , surname, and email"
	
	    if($this->link){
		    
		    $result = $this->link ->query($query);
		    if($result->num_rows==0){
			    echo "Create a table before inserting data\n";
		    }
		    else{
			    
			    while ($data = fgetcsv($file)) { 
		
					$userdata_list[] = $data;
					$data[0]=ucfirst(strtolower($data[0]));
					$data[1]=ucfirst(strtolower($data[1]));
					$data[2]=strtolower($data[2]);
					$get_email=$data[2];
					if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $data[2])) {
						 
						 echo  'Wrong Email Format For User: '. $data[0].' '. $data[1]." whose email won't be saved!\n"; 
						 $get_email='';						 
						}
					$query="INSERT INTO `users` ( `name`, `surname`, `email`) VALUES ( '".$data[0]."', '".$data[1]."', '".$get_email."')";
					$this->link ->query($query);
					
					//echo $query;
			//print_r($data);
		}
			    
		    }		    
	    }
	    else{
		    echo "Link database before dry run\n";
	    }
	    
	    
	    
		
	    
    }
    
}	

$appctrl=new app;//creat an object
$appctrl->user_name='user_admin';
$appctrl->pw='11111';
$appctrl->host='localhost';
$appctrl->dbname='user_info';
$appctrl->set_file_name('users.csv');
$appctrl->db_connect_mysqli();
echo "Welcome to application. please enter command. Enter -help for command details \n";
while(1){
	
	
	$input= trim(fgets(STDIN, 1024));
	switch ($input) {
	   case '--file':
		    echo "Enter file name(Default file name is users.csv):  \n";
		    $get_file_name=trim(fgets(STDIN, 1024));
		    $appctrl->set_file_name($get_file_name);
		    //$file_name=$appctrl->set_file_name(trim(fgets(STDIN, 1024)));
		    //$file_name= trim(fgets(STDIN, 1024));
		    //
		    echo "File name is ".$get_file_name."\n";
			break;
			
		case '--create_table':
	   	 $appctrl->link->query($appctrl->query_creat_table);
	     echo "Table created! \n";
	     break;
	     
			 case '--dry_run':
	   		$appctrl->set_file();//save the data of the fiel into an array
	     	break;
	     	
		 case '-u':
	   		echo "MySQL Username is: ".$appctrl->user_name."\n Enter a new one:";
	   		$appctrl->user_name=trim(fgets(STDIN, 1024));
	     	break;
	    case '-p':
	   		echo "MySQL Password is ".$appctrl->pw."\n Enter a new one:";
	   		$appctrl->pw=trim(fgets(STDIN, 1024));	   		
	     	break;
	    case '-h':
	   		echo "MySQL Host is ".$appctrl->host."\n Enter a new one:";
	   		$appctrl->host=trim(fgets(STDIN, 1024));	
	     	break;
	    case '-db':
	   		echo "MySQL Database is ".$appctrl->dbname."\n Enter a new one:";
	   		$appctrl->dbname=trim(fgets(STDIN, 1024));	
	     	break;
	    case '-help':
	   		echo "--file: to enter the file name.\n--create_table: Build a table named users in MySQL database\n --dry_run: Insert data from the csv file\n -u: to change the user name of MySQL account\n -p: to change MySQL password\n -h: to change MySQL host\n -db: to change the database of MySQL\n --q: quit the application\n";
	     	break;
	   default:
	     echo "Please enter a right command.  -help for more information\n";
	}
	if ($input=='--q'){
		echo "Bye!\n";
		break;
		}
}
?>


