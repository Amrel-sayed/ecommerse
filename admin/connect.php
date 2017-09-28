<?php 


	$dsn="mysql:host=localhost;dbname=amrshop";
	$user='root';
	$pass="";
	$options=array(   // this one of PDO options to send data with Arabic format to Data base 
		PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8', 
		);
	
try{

	$con=new PDO($dsn,$user,$pass,$options);
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	echo "you are connected now ";


}catch(PDOEXCEPTION $e){
Echo "failed to login".$e->getMessage();
}



?>