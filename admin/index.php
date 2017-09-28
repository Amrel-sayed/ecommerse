
<?php  

session_start();

$noNavbar='';
$pagetitle="login";

include "ini.inc";

if (isset($_SESSION['user'])) {
	header('location:dashboard.php');
	exit();
}





// to confirm that user is coming from POST REquest
if ($_SERVER['REQUEST_METHOD']=="POST"){

	$username=$_POST['user'];
	$password=$_POST['password'];
	$hashedpass=sha1($password);
	// echo $username .' '. $hashedpass;

	//check if the user exist in database 
	$stmt=$con->prepare("select userID,username,password,Displayname from users where username=? AND password=? and groupID=1 LIMIT 1");
	$stmt->EXECUTE(array($username,$hashedpass));
	$data=$stmt->fetch();
	$count=$stmt->rowCount();// rowcount will retune the serach result with counts 
	if ($count>0){

		$_SESSION['user']=$username; // this command will start session to be saved with session name 
		$_SESSION['ID']=$data['userID']; // this command will start session to be saved with session name 
		$_SESSION['Dname']=$data['Displayname']; // this command will start session to be saved with session name 
		
	  	header('location:dashboard.php');
	}
}



?>
	


<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<h1 class= "text-center text-success"> Admin Login</h1>

	<div class="input-group input-group-lg">
		  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
		  <input type="text" class="form-control" name="user" placeholder="Type your user name here" autocomplete="off" aria-describedby="basic-addon1">
	</div>

	<!-- <input class= "form-control" type="text" name="user" placeholder="Type your user name here" autocomplete="off"/> -->
		<div class="input-group input-group-lg">
		  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock fa-fw" aria-hidden="true"></i></span>
		  <input class= "form-control"type="password" name="password" placeholder="Type your password" autocomplete="new-password" aria-describedby="basic-addon1">
	</div>
	<!-- <input class= "btn btn-success btn-block" type="submit" value="login"/> -->
	<button class= "btn btn-success btn-block" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i><span>  Login </span></button>
</form>



 

