<?php  
ob_start();
session_start();

$pagetitle="login";

include "ini.inc";
include "google.inc";

if (isset($_SESSION['fuser'])) {
	header('location:index.php');
	exit();}


// to confirm that user is coming from POST REquest
if ($_SERVER['REQUEST_METHOD']=="POST"){

// ==================================================================================================================================

	if (isset($_POST['signin'])){
			$username=filter_var($_POST['user'],FILTER_SANITIZE_STRING);
			$password=$_POST['password'];
			$hashedpass=sha1($password);
			// echo $username .' '. $hashedpass;

			//check if the user exist in database 
			$stmt=$con->prepare("select userID,username,password,Displayname,regstatus,image from users where username=? AND password=? ");
			$stmt->EXECUTE(array($username,$hashedpass));
			$data=$stmt->fetch();
			$count=$stmt->rowCount();// rowcount will retune the serach result with counts 

		if ($count>0 && $data['regstatus']=="1"){

			$_SESSION['fuser']=$username; // this command will start session to be saved with session name 
			$_SESSION['ID']=$data['userID']; // this command will start session to be saved with session name 
			$_SESSION['Dname']=$data['Displayname']; // this command will start session to be saved with session name 
			$_SESSION['img']=$data['image'];
		  	header('location:index.php');
	    }elseif ($count>0 && $data['regstatus']!=="1"){

		  		echo "<div class='error'>";

		  			echo"<h3>sorry you can't use this account as it's not activated yet </h3>";
		  			echo"<h3>could could you please contact site Admin for more details  </h3>";
		  			echo"<a href='index.php'><img class='ilogo' src='layout\images\EC_Logo.png' alt='' /></a>";

		  		echo "</div>";
	  		} 
// ==================================================================================================================================
	}else{ 
			$loginerror=array();

			$username=filter_var($_POST['username'],FILTER_SANITIZE_STRING);

			if (strlen($username) < 5){$loginerror['usern']="Too shor username ";}		


			if (isset($_POST['password'])&&isset($_POST['password2'])){
					$password1=sha1($_POST['password']);
					$password2=sha1($_POST['password2']);
					if($password1!== $password2){
							$loginerror['Passmat']="both Passwords not matched";
					}else{	$hashedpass=sha1($password1);	}
				}

			$mail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

			if (filter_var($mail,FILTER_VALIDATE_EMAIL) != true){ $loginerror['email']="Please Enter Avalid Email";	}	

			$Dname=filter_var($_POST['Dname'],FILTER_SANITIZE_STRING);

			if (empty($loginerror)){

					if(checkitem("username","users",$username)>0){

						$loginerror['usernExist']="this user Already exist";

					}else{ 
						$rand=rand(4444, 99999999);
					$stmt=$con->prepare("INSERT INTO users (username,Email,Displayname,password,Day,code) VALUES (?,?,?,?,now(),?)");
					$stmt->EXECUTE(array($username,$mail,$Dname,$hashedpass,$rand));
					$subject="E-Commerce confimation mail";
					$usern=str_replace(" ","_",$username);
					$message="
							Welcome to my site,

							Dear $username, You have been registered on our site.

							Please visit http://localhost/ecommerse/confirm.php?user=$usern&code=$rand to view your upvotes

							Regards.
					";
					mail($mail,$subject,$message,"from: amr.m.elsaid@gmai.com");
					echo "<div class='errormsg'>
										<p>Congrat your account has been created.please check your mail and verify it </p>
									</div>";
					// header("refresh:3;url=login.php?logst=signin");
					// header('location:login.php?logst=signin');
				}
			}
	
			// echo $username .' '. $hashedpass;
//===================================================================================================================================



//===================================================================================================================================


		
	     }
}


$log= isset($_GET['logst']) ? $_GET['logst'] : 'signin'; 	

if ($log=='signin'){

	echo '<form class="login" action="'. $_SERVER['PHP_SELF']. '" method="post">'; ?>

	<h1 class= "text-center tlogo"><img class='ilogo' src='layout\images\EC_Logo.png' alt='' />ommer<span>c</span>e </h1>
<div class="frame">
	<h2 > Sign in </h2>
	<div class="input-group input-group-lg">
		  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
		  <input type="text" class="form-control" name="user" placeholder="Type your user name here" autocomplete="off" aria-describedby="basic-addon1">
	</div>

	<!-- <input class= "form-control" type="text" name="user" placeholder="Type your user name here" autocomplete="off"/> -->
		<div class="input-group input-group-lg">
		  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock fa-fw" aria-hidden="true"></i></span>
		  <input class= "form-control" type="password" name="password" placeholder="Type your password" autocomplete="new-password" aria-describedby="basic-addon1">
	</div>
	<!-- <input class= "btn btn-success btn-block" type="submit" value="login"/> -->
	<button class= "btn btn-block btn-sign" name="signin" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i><span>Sign in</span></button>
		<a href=""></a>
	<hr>
	<a class= "btn btn-default btn-block" href="?logst=signup"><span>Sign Up for New Account </span></a>
	<hr>
<?php 

if (isset($authUrl)){ 
	//show login url
	
	echo '<a class="btn btn-google btn-block" href="' . $authUrl . '"><i class="fa fa-google-plus" ></i> Sign in with Google </a>';

	
} else {
	
	$user = $service->userinfo->get(); //get user info 
	
	// connect to database
	// $mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
 //    if ($mysqli->connect_error) {
 //        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
 //    }
	
	// //check if user exist in database using COUNT
	// $result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
	// $user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
			$stmt1=$con->prepare("select * from users where social_id=? ");
			$stmt1->EXECUTE(array($user["id"]));
			$data1=$stmt1->fetch();
			$count=$stmt1->rowCount();// rowcount will retune the serach result with counts 
			
			
	// //show user picture
	// echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
	// echo "++++++++++++++++++++++++++++++".$user_count."<br>";
	if($count>0) //if user already exist change greeting text to "Welcome Back"
    {
        echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'&&logout=1">Log Out</a>]';
        $_SESSION['fuser']=$data1['username']; // this command will start session to be saved with session name 
			$_SESSION['ID']=$data1['userID']; // this command will start session to be saved with session name 
			$_SESSION['Dname']=$data1['Displayname']; // this command will start session to be saved with session name 
			$_SESSION['img']=$data1['image'];
			header('location:index.php');

    }
	else //else greeting text "Thanks for registering"
	{ 
        echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		$stmt=$con->prepare("INSERT INTO users (username,Email,Displayname,Day,social,social_id,image) VALUES (?,?,?,now(),?,?,?)");
		$stmt->EXECUTE(array($user["name"],$user["email"],$user["name"],$user["link"],$user["id"],$user["picture"]));
		header('http://localhost/ecommerse/login.php?logst=signup');
	
    }
	

}
?>
</div>
</form>

<?php

}else{ 

echo '<form class="login" action="login.php?logst=signup" method="post">';


	// echo '<form class="login" action="'. $_SERVER['PHP_SELF']. '" method="post">';?>
	<h1 class= "text-center tlogo"><img class='ilogo' src='layout\images\EC_Logo.png' alt='' />ommer<span>c</span>e </h1>
	<div class="frame">
		<h2 >Create account</h2>
		<div class="inputforms">
		<div class="input-group input-group-lg">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
			  <input class="form-control name"
			  		
			  		 data-type="username"
			  		 type="text"
			  		 pattern=".{4,}"
			  		 title="Username name must be between 4 & 8 Char"  
			  		 name="username"
			  		 placeholder="Type your username here" 
			  		 autocomplete="off" required>
					</div>
			   <span  id="username"></span>
		
		</div>
		
		<div class="inputforms">
		<div class="input-group input-group-lg">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope-o" aria-hidden="true"></i></i></span>
			  <input type="email" 
			  		 class="form-control name" 
			  		  data-type="mail"
			  		 
			  		 pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
			  		 title="Please enter Avalid Email" 
			  		 name="email" 
			  		 placeholder="Type your Email" 
			  		 autocomplete="off" required>
			   </div>
			   <span  id="mail"></span>
		</div>
		<div class="inputforms">
			<div class="input-group input-group-lg">
		 	 <span class="input-group-addon" id="basic-addon1"><i class="fa fa-unlock fa-fw" aria-hidden="true"></i></span>
			  <input class= "form-control password"
			   		 class="name"
			   		
			   		 type="password" 
			   		 pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
			   		 name="password" 
			   		 placeholder="type Complex Password" 
			   		 autocomplete="new-password" required>
			 <i class="fa fa-eye showpass fa-lg" aria-hidden="true"></i>
			</div>
			<span id="mail"></span>
			 <span class="examble">EX: Upper,Lower,Number,SpecialChar and min 8 Chars</span>
		</div>
	


	<!-- <input class= "form-control" type="text" name="user" placeholder="Type your user name here" autocomplete="off"/> -->
		<div class="inputforms">
			<div class="input-group input-group-lg">
		  	<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-secret" aria-hidden="true"></i></span>
		  	<input class= "form-control" 
		  		 type="password" 
		  		 minlength="4" 
		  		 name="password2" 
		  		 placeholder="Retype your password " 
		  		 autocomplete="new-password" required>
		
				</div>
		</div>
		<div class="inputforms">
			<div class="input-group input-group-lg">
				  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
				  <input type="text" 
				  		 class="form-control" 
				  		 name="Dname" 
				  		 placeholder="Type your Nickname" 
				  		 autocomplete="off" required>
			</div>
		</div>
	<!-- <input class= "btn btn-success btn-block" type="submit" value="login"/> -->
	<button class= "btn btn-block btn-success" name="signup" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i><span>Sign UP</span></button>
	<hr>
	<a class= "btn btn-default btn-block" href="?logst=signin"><span>Sign IN With My Account </span></a>
	<hr>
	<?php 


//Display user info or display login url as per the info we have.

if (isset($authUrl)){ 
	//show login url
	
	echo '<a class="btn btn-google btn-block" href="' . $authUrl . '"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign UP with Google </a>';

	
} else {
	
	$user = $service->userinfo->get(); //get user info 
	
	// connect to database
	// $mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
 //    if ($mysqli->connect_error) {
 //        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
 //    }
	
	// //check if user exist in database using COUNT
	// $result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
	// $user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
			$stmt1=$con->prepare("select * from users where social_id=? ");
			$stmt1->EXECUTE(array($user["id"]));
			$data1=$stmt1->fetch();
			$count=$stmt1->rowCount();// rowcount will retune the serach result with counts 
			
			$_SESSION['fuser']=$data1['username']; // this command will start session to be saved with session name 
			$_SESSION['ID']=$data1['userID']; // this command will start session to be saved with session name 
			$_SESSION['Dname']=$data1['Displayname']; // this command will start session to be saved with session name 
			$_SESSION['img']=$data1['image'];
			header('location:index.php');
	// //show user picture
	// echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
	// echo "++++++++++++++++++++++++++++++".$user_count."<br>";
	if($count>0) //if user already exist change greeting text to "Welcome Back"
    {
        echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'&&logout=1">Log Out</a>]';

    }
	else //else greeting text "Thanks for registering"
	{ 
        echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		$stmt=$con->prepare("INSERT INTO users (username,Email,Displayname,Day,social,social_id,image) VALUES (?,?,?,now(),?,?,?)");
		$stmt->EXECUTE(array($user["name"],$user["email"],$user["name"],$user["link"],$user["id"],$user["picture"]));
		header('http://localhost/ecommerse/login.php?logst=signup');
		// $statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		// $statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
		// $statement->execute();
		// echo $mysqli->error;
    }
	
	// //print user details
	// echo '<pre>';
	// print_r($user);
	// echo '</pre>';
}
echo '</div>';

	if (!empty($loginerror)){
		echo "<hr>";
		foreach ($loginerror as $error){
			echo "<div class='errormsg'>
										<p>$error</p>
									</div>";
		}
	}


	?>
	</div>
</form>
<?php

	}
		ob_end_flush();
?>