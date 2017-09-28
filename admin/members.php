<?php 

session_start();

$pagetitle="members";

isset($_SESSION['user']) ? include "ini.inc" : header('location:index.php');

echo "<div class='members container'>";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage'; // check if the request is come from GET with certain key (do )
// what we will do if the reques is $_GET request 

if ($do=='manage'){// manage page to show all added members

if(isset($_GET['stat']) && $_GET['stat']=="reg"){

	$stmt=$con->prepare("select * from users where regstatus!=1 "); }
	else{
	$stmt=$con->prepare("select * from users ");
	}
	$stmt->EXECUTE();
	$data=$stmt->fetchAll(); ?>

<div class="container">
	<h1 class="text-center"> Welcome to Manage Members </h1>
	<table class="table table-bordered text-center table-responsive">
		 <thead class="thead-inverse" >
		 	<tr>
				<th class="text-center">User ID</th>
				<th class="text-center">User Name</th>
				<th class="text-center">Email</th>
				<th class="text-center">Displayed Name</th>
				<th class="text-center">GroupID</th>
				<th class="text-center">Registration Date</th>
				<th class="text-center">Control</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php
			foreach($data as $mem){
					echo "<tr>";
					 	echo "<td>".$mem['userID']."</td>";
					 	echo "<td>".$mem['username']."</td>";
					 	echo "<td>".$mem['Email'] ."</td>";
					 	echo "<td>".$mem['Displayname']  ."</td>";
						 if($mem['groupID']==1){echo'<td>Admin</td>';}else{echo'<td>Member</td>';};
					 	echo "<td>".$mem['Day']."</td>";
					 	echo "<td>";
					 	echo "<a class='btn btn-success' href='?do=Edit&userID=".$mem['userID']."'><i class='fa fa-edit'></i>Edit</a>";
					 	echo "<a class='btn btn-danger confirm' href='?do=Delete&userID=".$mem['userID']."'><i class='fa fa-close'></i>Delete</a>";
					 			if($mem['regstatus']==0){	
					 			echo "<a class='btn btn-info' href='?do=Activate&userID=".$mem['userID']."'><i class='fa fa-check'></i>Activate</a>";}

						echo "</td>";
					echo "</tr>";

			}
				
			 ?>
		</tbody>
	</table>
	<a class="btn btn-info" href="members.php?do=Add">+ Add New Member </a>
</div>


<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Add') { ?>

<div class="contain">
	<h1 class="text-center text-success">Add New Member </h1>
	<form class="form-horizontal" action="?do=insert" method="post">
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">User Name</label>
	    <div class="col-sm-6">
	      <input class="form-control"  type="text" name="username"placeholder="username" autocomplete="off" required="required">
	      <input type="hidden" name='admin' value="0">
	     </div>
	      <div class="col-sm-1">
	      	<input class="form-check-input" type="checkbox" name='admin' value="1" > 
	        <label>Admin</label>
		</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Password</label>
	    <div class="col-sm-6">
	      <input class="form-control password" type="password" name="password"  placeholder="password" autocomplete="new-password" required="required" >
	    </div>
	     <div class="col-sm-1">
	    	<i class="fa fa-eye showpass fa-lg" aria-hidden="true"></i>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Email</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="email" name="email"  placeholder="Email" required="required"> 
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Display Name</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="full"  placeholder="Display Name" required="required">
	    </div>
	  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-4 col-sm-6">
	      <button class="btn btn-block btn-success" type="submit"><i class="fa fa-save fa-lg"></i> Save</button>
	    </div>
	  </div>
	</form>
</div>
<?php 

//++++++++++++++++++++++++++++++++++++++++++++++++++++++(insert bage)++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='insert') {	
			echo "<div class='container'>";
				echo "<h1 class='text-center text-success'>Insert Member Data </h1>";
		if($_SERVER['REQUEST_METHOD']=='POST'){
		//get data od user from form 
			
			$user=$_POST['username'];
			$email=$_POST['email'];
			$name=$_POST['full'];
			$pass=$_POST['password'];
			$group=$_POST['admin'];
			$hpass=sha1($pass);// start form validation 
			$fault= array();
			
			if (strlen($user)<5) { $fault[]="the user filed can't be  less than <strong> 5 char </strong> ";}
			if (strlen($user)>20) { $fault[]="the user filed can't be more than <strong> 20 char</strong> ";}
			if (empty($email)) { $fault[]="the email filed can't be<strong>  empty</strong> ";}
			if (empty($name)) { $fault[]="the full name filed can't be <strong> empty</strong> ";}
			if (empty($pass)) { $fault[]="the password filed can't be <strong>less than 6 char</strong> ";}
		if (empty($fault)){

				$check=checkitem("username","users",$user);
				if ($check== 1 ){
					$msg="this user $user already exist";
					msg_report($msg,'danger','back',5);

				}else{

				$stmt=$con->prepare("INSERT INTO users(username,password,Email,Displayname, groupID,regstatus,Day) VALUES (?,?,?,?,?,?,now())");
				$stmt->EXECUTE(array($user,$hpass,$email,$name,$group,1)); 
				$count=$stmt->rowCount();
				$msg= " <strong>  $count Record </strong> Added ";
				msg_report($msg,'success','back',5);
			
		
				}
			//end from validation 
			
			}else{
						foreach ($fault as $error) {
				$msg= "<div class='alert alert-danger'>$error</div>";
			msg_report($msg,'danger','back',5);}
			}
		}else{
			$msg="you can't log from here";
			error_report($msg,5);}

			echo "</div>";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='Edit') {

	if(isset($_GET['userID'])&&is_numeric($_GET['userID'])){

		$ID=intval($_GET['userID']);

	}else{

		$ID=0;
		}

	$stmt=$con->prepare("select * from users where userID=? LIMIT 1");
	$stmt->EXECUTE(array($ID));
	$data=$stmt->fetch();
	$count=$stmt->rowCount();// rowcount will retune the serach result with counts 
	if ($count>0){     ?>

<div class="contain">
	<h1 class="text-center text-success">Edit Member Data </h1>
	<form class="form-horizontal" action="?do=update" method="post">
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">User Name</label>
	    <div class="col-sm-6">
	      <input class="form-control"  type="hidden" name="id" value="<?php echo $data['userID']?>">
	      <input class="form-control"  type="text" name="username" placeholder="username" autocomplete="off"  value="<?php echo $data['username']?>"required="required">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Password</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="hidden" name="oldpass"  value="<?php echo $data['password']?>" >
	      <input class="form-control" type="password" name="newpass" placeholder="password" autocomplete="new-password" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Email</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="email" name="email"  placeholder="Email" value="<?php echo $data['Email']?>" required="required">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Display Name</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="full"  placeholder="Display Name" value="<?php echo $data['Displayname']?>" required="required">
	    </div>
	  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-4 col-sm-6">
	      <button class="btn btn-block btn-success" type="submit"><i class="fa fa-save fa-lg"></i> Save</button>
	    </div>
	  </div>
	</form>
</div>

<?php  }else{ $msg="there is no such ID ";

				msg_report($msg,'danger','back',5);}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='update') {	
				echo "<div class='container'>";
				echo "<h1 class='text-center text-success'>Edit Member Data </h1>";
		if($_SERVER['REQUEST_METHOD']=='POST'){
		//get data od user from form 

			$user=$_POST['username'];
			$id=$_POST['id'];
			$email=$_POST['email'];
			$name=$_POST['full'];
			//check if there is new password added or nor not 
			empty($_POST['newpass'])? $pass=$_POST['oldpass']:$pass=sha1($_POST['newpass']);
			// start form validation 
			$fault= array();
			
			if (strlen($user)<5) { $fault[]="the user filed can't be  less than <strong> 5 char </strong> ";}
			if (strlen($user)>20) { $fault[]="the user filed can't be more than <strong> 20 char</strong> ";}
			if (empty($email)) { $fault[]="the email filed can't be<strong>  empty</strong> ";}
			if (empty($name)) { $fault[]="the full name filed can't be <strong> empty</strong> ";}

		if (empty($fault)){

				$stmt=$con->prepare("update users set username=?,Email=?,Displayname=?,password=? where userID=? LIMIT 1");
				$stmt->EXECUTE(array($user,$email,$name,$pass,$id));
				$count=$stmt->rowCount();
				$msg= " <strong>  $count Record </strong> Updated ";
				msg_report($msg,'success','back',5);
				if($_SESSION['ID']==$id){

				$_SESSION['Dname']=$name; }
		

			//end from validation 
			
			}else{
						foreach ($fault as $error) {
				echo '<div class="alert alert-danger">'.$error."</div>";}
			}
		}else{
			$msg="you can't log from here";
				msg_report($msg,'danger','back',5);
		}
		echo "</div>";

//++++++++++++++++++++++++++++++++++++++++++++++++++(Delete Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Delete') {

	if(isset($_GET['userID'])&&is_numeric($_GET['userID'])){
		echo "<div class='container'>";
	
		echo "<h1 class='text-center text-success'>Delete Member Data </h1>";

		$ID=intval($_GET['userID']);
	}else{

		$ID=0;
	}

	$count=checkitem("userID","users",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){
		$stmt=$con->prepare("DELETE from users where userID=? LIMIT 1");
		$stmt->EXECUTE(array($ID));

		$msg= " <strong>  $count Record </strong> Deleted ";
				// msg_report($msg,'success','back',0);
				header('location:members.php');
	}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);
	}
	echo "</div>";
	//++++++++++++++++++++++++++++++++++++++++++++++++++( Activate Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='Activate') {
	if(isset($_GET['userID'])&&is_numeric($_GET['userID'])){
		echo "<div class='container'>";
	
		echo "<h1 class='text-center text-success'>Activate Member Data </h1>";

		$ID=intval($_GET['userID']);
	}else{

		$ID=0;
	}

	$count=checkitem("userID","users",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){

				$stmt=$con->prepare("update users set regstatus=1 where userID=? LIMIT 1");
				$stmt->EXECUTE(array($ID));
				$count=$stmt->rowCount();
				// $msg= " <strong>  $count Record </strong> Activated";
				// msg_report($msg,'success','back',0);	
				if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				}else{  $url='members.php';}

				header("location:$url");
			
			}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);}

}else{ $msg="wrong bage inserted";
		msg_report($msg,'danger','back',5);
}
echo " </div> ";
?>