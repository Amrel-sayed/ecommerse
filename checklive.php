<?php

include "admin/connect.inc";
if (isset($_POST['username'])){	 
	$data=filter_var($_POST['user'],FILTER_SANITIZE_STRING); 
$stmt=$con->prepare("select userID,username,password,Displayname,regstatus,image from users where username=?");
$stmt->EXECUTE(array($data));
			$data=$stmt->fetch();
			$count=$stmt->rowCount();// rowcount will retune the serach result with counts 

		if ($count>0){

		echo "<p class='text-danger'><i class='fa fa-times'></i>this username already used</p>";
	    }elseif ($count == 0){
			echo "<p class='text-success'><i class='fa fa-check'></i>valid user name </p>";
	  		} 

}
// ==================================================================================================================================

if (isset($_POST['mail'])){	

 $data=filter_var($_POST['mail'],FILTER_SANITIZE_EMAIL); 
 $stmt=$con->prepare("select userID,username,password,Displayname,regstatus,image from users where Email=?");

			// $password=$_POST['password'];
			// $hashedpass=sha1($password);
			// echo $username .' '. $hashedpass;

			//check if the user exist in database 
			$stmt->EXECUTE(array($data));
			$data=$stmt->fetch();
			$count=$stmt->rowCount();// rowcount will retune the serach result with counts 

		if ($count>0){

		echo "<p class='text-danger'><i class='fa fa-times'></i>this Email already used</p>";
	    }elseif ($count == 0){
			echo "<p class='text-success'><i class='fa fa-check'></i>valid Email </p>";
	  		} }
// ==================================================================================================================================
	  	
		
			  	if (isset($_POST['itemn'],$_POST['user'],$_POST['num'])){
			  		$num=$_POST['num'];
	  			
	  			$stmt=$con->prepare("INSERT INTO item_log (item_ID,User_ID,numofitems,day) VALUES (?,?,?,now())");
	  			$stmt->EXECUTE(array($_POST['itemn'],$_POST['user'],$_POST['num']));

				  $stmt5=$con->prepare("SELECT * from item_log where User_ID=? ");
		          $stmt5->EXECUTE(array($_POST['user']));
		          $data5=$stmt5->fetchAll();
		          $cartnum=$stmt5->rowCount();
			  	  echo $cartnum;
			}
// ==================================================================================================================================
			if (isset($_POST['remain'])){
				$rem=$_POST['remain'];
				$stmt2=$con->prepare("UPDATE items set total_amount = total_amount - $rem where item_ID=?");
	  			$stmt2->EXECUTE(array($_POST['itemn']));

	  			$stmt5=$con->prepare("SELECT  total_amount from items where item_ID=? ");
		        $stmt5->EXECUTE(array($_POST['itemn']));
		        $total=$stmt5->fetch();
		        echo $total['total_amount'];
		    }
// ==================================================================================================================================
			if (isset($_POST['dropuser'],$_POST['dropitem'])){
				$duser=$_POST['dropuser'];
				$ditem=$_POST['dropitem'];
				$rem=$_POST['dropnum'];

				$stmt2=$con->prepare("DELETE from item_log where item_ID=? and User_ID=?");
	  			$stmt2->EXECUTE(array($ditem,$duser));

				  $stmt5=$con->prepare("SELECT * from item_log where User_ID=? ");
		          $stmt5->EXECUTE(array($duser));
		          $data5=$stmt5->fetchAll();
		          $cartnum=$stmt5->rowCount();
			  	  echo $cartnum;
	  			$stmt3=$con->prepare("UPDATE items set total_amount = total_amount + $rem where item_ID=?");
	  			$stmt3->EXECUTE(array($ditem));
		    }

	?>