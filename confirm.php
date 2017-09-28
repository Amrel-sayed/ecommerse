

<?php 
ob_start();
session_start();
include "ini.inc";

if (isset($_GET['user']) && isset($_GET['code'])){
		$user=str_replace("_"," ",$_GET['user']);
		$stmt=$con->prepare("SELECT * FROM users where username= ? ");
		$stmt->EXECUTE(array($user));
		$users=$stmt->fetch();

		if($users['code']==$_GET['code']){


			$_SESSION['fuser']=$users['username']; // this command will start session to be saved with session name 
			$_SESSION['ID']=$users['userID']; // this command will start session to be saved with session name 
			$_SESSION['Dname']=$users['Displayname']; // this command will start session to be saved with session name 
			$_SESSION['img']=$users['image'];

				$stmt2=$con->prepare("update users set regstatus=1 where userID=?");
				$stmt2->EXECUTE(array($users['userID']));
				$count=$stmt2->rowCount();
				
				echo "done greate ";
					header("refresh:3;url=index.php");
		}else{
		echo "error ";

		}
		


}
	ob_end_flush();
	?>