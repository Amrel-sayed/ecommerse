<?php 
ob_start();
 session_start();

 $pagetitle="Categories";

 isset($_SESSION['user']) ? include"ini.inc" :header("location:index.php");
 
 echo "<div class='Categories container'>";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage'; // check if the request is come from GET with certain key (do )

// what we will do if the reques is $_GET request 

if ($do=='manage'){// manage page to show all added members

	
	$sort="ASC";

	if(isset($_GET['sort'])&& ($_GET['sort']=="ASC"||$_GET['sort']=="DESC")){

			$sort=$_GET['sort'];
	}

	$stmt=$con->prepare("SELECT * from categories where Parent=0 ORDER BY Ordering $sort ");
	$stmt->EXECUTE();
	$data=$stmt->fetchAll();
 ?>
<div class="container manage">
	<h1 class="text-center">  Welcome to Categories Section </h1>
	<div class="panel panel-default">
		<div class="panel-heading">
	
					<h2 class="pull-left"> <i class='fa fa-plus-square-o glo'></i> Manage categorie</h2>
			
						<div class="ored-op pull-right" >
							<h4>Ordering:
							<a class="glyphicon glyphicon-menu-up" href="?sort=ASC"></a>
							<a class="glyphicon glyphicon-menu-down" href="?sort=DESC"></a>
							</h4>
						</div>
				<div class="clearfix"></div>
		</div>
	
		<div class="panel-body">
		<?php
			foreach($data as $val){
						echo "<div class='cat'>";
						 	echo "<h3 class='togglenext'>".$val['Name']."</h3>";
						 	echo "<div class='cat_com toggleme'>";
								 	echo "<p>".$val['Description'] ."</p>";
								 	 if($val['Visibility']==1){ echo"<span class='text-danger lead'>Hidden section </span>";}
								 	 if($val['Allow_comment']==1){echo"<span class='text-success lead'> Comment Disabled</span>";}
								 	 if($val['Allow_Ads']==1){echo"<span class='text-info lead'> Ads Disabled </span>";
								 	}
								$stmt2=$con->prepare("SELECT * from categories where Parent=? ");
								$stmt2->EXECUTE(array($val['ID']));
								$data2=$stmt2->fetchAll();
								
							if($stmt2->rowCount()>0){

								echo "<h4>Sub-Category</h4>";
								foreach($data2 as $val2){
								echo "<div class='sub-cat'>";

										echo "<h5><a href='?do=Edit&ID=".$val2['ID']."'>".$val2['Name']."</a></h5>";
										echo "<span class='del'><a href='?do=Delete&ID=".$val['ID']."'>Delete</a></span>";
						 			echo "</div>";			
								 		// 	echo "<p>".$val2['Description'] ."</p>";
								 	 // if($val2['Visibility']==1){ echo"<span class='text-danger lead'>Hidden section </span>";}
								 	 // if($val2['Allow_comment']==1){echo"<span class='text-success lead'> Comment Disabled</span>";}
								 	 // if($val2['Allow_Ads']==1){echo"<span class='text-info lead'> Ads Disabled </span>";}
								}}
					
							echo "</div>";
							echo "<div class='hidden_btn'>";
								 	echo "<a class='btn btn-xs btn-info' href='?do=Edit&ID=".$val['ID']."'><i class='fa fa-edit'></i>Edit</a>
							 			 <a class='btn btn-danger btn-xs confirm' href='?do=Delete&ID=".$val['ID']."'><i class='fa fa-close'></i>Delete</a>";
							echo "</div>";
						 echo "</div>";
					echo "<hr>";
								}?>
		</div>
	

		</div>

		<a href="?do=Add" class="btn btn-info"><i class="fa fa-plus-square-o" aria-hidden="true"></i>New Catiegory </a>
</div>
<?php
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='Edit') {

	
	if(isset($_GET['ID'])&&is_numeric($_GET['ID'])){

		$ID=intval($_GET['ID']);

	}else{

		$ID=0;
		}
	$stmt=$con->prepare("SELECT * FROM categories where ID=$ID");
	$stmt->EXECUTE();
	$data=$stmt->fetch();
	// echo "<pre>";
	// print_r($data);
	// 	echo "</pre>";
	$count=$stmt->rowCount();
	if($count==1){
	?>

 <div class="contain">
	
	<form class="form-horizontal" action="?do=update" method="post">
	  <div class="form-group">
	  	    <div class="col-sm-offset-3 col-sm-7">
		      <h1 class="text-center text-success">Edit Category Details</h1>
		  	</div>
	  </div> 
	   <div class="form-group">
	   		<label class="col-sm-offset-2 col-sm-2 control-label">Category Name</label>
		    <div class="col-sm-6">
		   	  <input class="form-control"  type="hidden" name="id" value="<?php echo $data['ID']?>" >
		      <input class="form-control"  type="text" name="name" autocomplete="off" value="<?php echo $data['Name']?>" required="required">
		  	</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Description</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="description"  value="<?php echo $data['Description']?>"  >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">ordering</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="number" name="ordering" value="<?php echo $data['Ordering']?>"   placeholder="type Category order" > 
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">parent</label>
	    <div class="col-sm-6">
	
	 	 <select name="parent">
					<option value="0">None</option>
					<?php 
					$stmt=$con->prepare("select * from categories where Parent=0");
					$stmt->EXECUTE();
					$ct=$stmt->fetchALL();

					foreach($ct as $val){
						if ($data['Parent']===$val['ID']){
							echo "<option value=".$val["ID"]." selected>".$val["Name"]."</option>";
						}else{
						echo "<option value=".$val["ID"].">".$val["Name"]."</option>";}
						}
					
					?>
				</select>
			</div>
		</div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Visibility</label>
	    <div class="col-sm-2">
	      <div>
	      <input id="vis-yes" type="radio" name="Visibility" value="0" <?php if($data['Visibility']==0){ echo 'checked';}?> >
	      <label for="vis-yes">yes</label>
	      </div>
	     <div>
	      <input id="vis-no" type="radio" name="Visibility" value="1" <?php if($data['Visibility']==1){ echo 'checked';}?> >
	      <label for="vis-no">No</label>
	      </div>
	    </div>
	  </div>
	  <div class="form-group">
		    <label class="col-sm-offset-2 col-sm-2 control-label">Allow Comments</label>
		    <div class="col-sm-2">
		      <div>
		      <input id="com-yes" type="radio" name="allowcomm" value="0" <?php if($data['Allow_comment']==0){ echo 'checked';}?>>
		      <label for="com-yes">yes</label>
		      </div>
		     <div>
		      <input id="com-no" type="radio" name="allowcomm" value="1" <?php if($data['Allow_comment']==1){ echo 'checked';}?>>
		      <label for="com-no">No</label>
		      </div>
		    </div>
		  </div>
		   <div class="form-group">
		    <label class="col-sm-offset-2 col-sm-2 control-label">Allow Ads</label>
		    <div class="col-sm-2">
		      <div>
		      <input id="adv-yes" type="radio" name="allowads" value="0" <?php if($data['Allow_Ads']==0){ echo 'checked';}?>>
		      <label for="adv-yes">yes</label>
		      </div>
		     <div>
		      <input id="adv-no" type="radio" name="allowads" value="1"  <?php if($data['Allow_Ads']==1){ echo 'checked';}?>>
		      <label for="adv-no">No</label>
		      </div>
		    </div>
		  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-4 col-sm-6">
	      <button class="btn btn-success" type="submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Save</button>
	    </div>
	  </div>
	</form>
</div>
<?php 

	}else{
		$msg="there is no such ID ";

				msg_report($msg,'danger','back',5);
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='update') {	

		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Edit Category Data </h1>";
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$ID=$_POST['id'];
					$name=$_POST['name'];
					$desc=$_POST['description'];
					$ord=$_POST['ordering'];
					$vis=$_POST['Visibility'];
					$com=$_POST['allowcomm'];
					$ads=$_POST['allowads'];
					$check=checkitem("Name","categories",$name)	;
				    $stmt=$con->prepare("update categories set Name=?,Description=?,Ordering=?,Visibility=?,Allow_comment=?,Allow_Ads=? where ID=?");
						$stmt->EXECUTE(array($name,$desc,$ord,$vis,$com,$ads,$ID));
						$count=$stmt->rowCount();
							$msg= " <strong>  $count Record </strong> updtaed ";
							msg_report($msg,'success','back',5); 
					}else{
						$msg="you can't log from here";
						msg_report($msg,'danger','back',5);}
						
		echo "</div>";
					
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Add') { ?>

<div class="contain">
	
	<form class="form-horizontal" action="?do=insert" method="post">
	  <div class="form-group">
	  	    <div class="col-sm-offset-4 col-sm-6">
		      <h1 class="text-center text-success">Add New Category </h1>
		  	</div>
	  </div> 
	   <div class="form-group">
	   		<label class="col-sm-offset-2 col-sm-2 control-label">Category Name</label>
		    <div class="col-sm-6">
		      <input class="form-control"  type="text" name="name" placeholder="Category Name" autocomplete="off" required="required">
		  	</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Description</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="description"  placeholder="Category Description" required="required" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">ordering</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="number" name="ordering"  placeholder="type Category order" > 
	    </div>
	  </div>
	<div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">parent</label>
	    <div class="col-sm-6">

	 	 <select name="parent">
					<option value="0" selected> None</option>
					<?php 
					$stmt=$con->prepare("select * from categories where Parent=0");
					$stmt->EXECUTE();
					$ct=$stmt->fetchALL();
					foreach($ct as $val){
						echo "<option value=".$val["ID"].">".$val["Name"]."</option>";
						}
					
					?>
				</select>
			</div>
			</div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Visibility</label>
	    <div class="col-sm-2">
	      <div>
	      <input id="vis-yes" type="radio" name="Visibility" value="0" checked >
	      <label for="vis-yes">yes</label>
	      </div>
	     <div>
	      <input id="vis-no" type="radio" name="Visibility" value="1" >
	      <label for="vis-no">No</label>
	      </div>
	    </div>
	  </div>
  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Allow Comments</label>
	    <div class="col-sm-2">
	      <div>
	      <input id="com-yes" type="radio" name="allowcomm" value="0" checked >
	      <label for="com-yes">yes</label>
	      </div>
	     <div>
	      <input id="com-no" type="radio" name="allowcomm" value="1" >
	      <label for="com-no">No</label>
	      </div>
	    </div>
	  </div>
	   <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Allow Ads</label>
	    <div class="col-sm-2">
	      <div>
		      <input id="adv-yes" type="radio" name="allowads" value="0" checked >
		      <label for="adv-yes">yes</label>
		  </div>
	      <div>
		      <input id="adv-no" type="radio" name="allowads" value="1" >
		      <label for="adv-no">No</label>
		      </div>
	      </div>
	  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-4 col-sm-6">
	      <button class="btn btn-success" type="submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Save</button>
	    </div>
	  </div>
	</form>
</div>
<?php 

//++++++++++++++++++++++++++++++++++++++++++++++++++++++(insert bage)++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='insert') {

		echo "<div class='container'>";
				echo "<h1 class='text-center text-success'>Insert New Category </h1>";
	
		if($_SERVER['REQUEST_METHOD']=='POST'){
		//get data od user from form 
			$name=$_POST['name'];
			$desc=$_POST['description'];
			$oreder=$_POST['ordering'];
			$vis=$_POST['Visibility'];
			$comm=$_POST['allowcomm'];
			$ads=$_POST['allowads'];
			$par=$_POST['parent'];
		
			$check=checkitem("Name","categories",$name);

				if ($check== 1 ){
					$msg="this Category $name already exist";
					msg_report($msg,'danger','back',5);

				}else{
				$stmt=$con->prepare("INSERT INTO categories (Name,Description,Ordering,Visibility,Allow_comment,Allow_Ads,Parent,Day) VALUES (?,?,?,?,?,?,?,now())");
				$stmt->EXECUTE(array($name,$desc,$oreder,$vis,$comm,$ads,$par)); 
				$count=$stmt->rowCount();
				$msg= " <strong>  $count Record </strong> Added ";
				msg_report($msg,'success','back',5); }
			//end from validation 
			}else{
			$msg="you Can't brows this page Direct";
			msg_report($msg,'danger','back',5);}

			echo "</div>";
			
//++++++++++++++++++++++++++++++++++++++++++++++++++(Delete Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Delete') {

	if(isset($_GET['ID'])&&is_numeric($_GET['ID'])){

		$ID=intval($_GET['ID']);

	}else{

		$ID=0;
		}
	$found=checkitem("ID","categories",$ID);
	if($found==1){
	$stmt=$con->prepare("DELETE FROM categories where ID=$ID");
	$stmt->EXECUTE();
	$count=$stmt->rowCount();
	if($count==1){

		header('location:categories.php');
	}


	}else{
		$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++( Activate Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}else{ $msg="wrong bage inserted";
		msg_report($msg,'danger','back',5);
}
echo " </div> ";
ob_end_flush();
?>
