<?php 
 session_start();

 $pagetitle="Items";

 isset($_SESSION['user']) ? include"ini.inc" :header("location:index.php");
 
 echo "<div class='items container'>";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage'; // check if the request is come from GET with certain key (do )

// what we will do if the reques is $_GET request 

if ($do=='manage'){// manage page to show all added members

	// if(isset($_GET['stat']) && $_GET['stat']=="reg"){

	// $stmt=$con->prepare("select * from users where regstatus!=1 "); }
	// else{
	$stmt=$con->prepare("SELECT items.*,users.username,categories.name as category_name from items
						 inner join users on items.Member_id=users.userID	 
						 inner join categories on items.Cat_ID=Categories.ID ORDER BY item_ID ASC ");
	// }
	$stmt->EXECUTE();
	$data=$stmt->fetchAll(); ?>

<div class="container">
	<h1 class="text-center"> Welcome to Manage Items </h1>
	<table class="table table-bordered text-center table-responsive">
		 <thead class="thead-inverse" >
		 	<tr>
				<th class="text-center">Item ID</th>
				<th class="text-center">Image</th>
				<th class="text-center">Item Name</th>
				<th class="text-center">Description</th>
				<th class="text-center">Price</th>
				<th class="text-center">Registration Date</th>
				<th class="text-center">Category_name</th>
				<th class="text-center">User Name </th>
				<th class="text-center">Control</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php
			foreach($data as $val){ 
					echo "<tr>";
					 	echo "<td>".$val['item_ID']."</td>";
					 	echo "<td><img class='miniimg'  src='uploads\items\\".$val["Image"]."' alt='' /></td>";
					 	echo "<td>".$val['Name']."</td>";
					 	echo "<td>".$val['Description'] ."</td>";
					 	echo "<td>".$val['Price']  ."</td>";
					 	echo "<td>".$val['Add_Date']."</td>";
					 	echo "<td>".$val['category_name']."</td>";
					 	echo "<td>".$val['username']."</td>";
					 	echo "<td>";
					 	echo "<a class='btn btn-success btn-xs' href='?do=Edit&itemID=".$val['item_ID']."'><i class='fa fa-edit'></i>Edit</a>";
					 		echo"<a class='btn btn-danger confirm btn-xs' href='?do=Delete&itemID=".$val['item_ID']."'><i class='fa fa-close'></i>Delete</a>";
					 	if($val['Item_status']==0){	
					 	echo "<a class='btn btn-info btn-xs' href='?do=Approve&itemID=".$val['item_ID']."'><i class='fa fa-check'></i>Approve</a>";}

					 		}

						echo "</td>";
					echo "</tr>"?>

		</tbody>
	</table>
		<a href="?do=Add" class="btn btn-info"><i class="fa fa-plus-square-o" aria-hidden="true"></i>New item </a> 
</div>

<?php


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='Edit') {

		if(isset($_GET['itemID'])&&is_numeric($_GET['itemID'])){

		$ID=intval($_GET['itemID']);

	}else{

		$ID=0;
		}

	$stmt=$con->prepare("SELECT * FROM items where item_ID=$ID");
	$stmt->EXECUTE();
	$data=$stmt->fetch();
	// echo "<pre>";
	// print_r($data);
	// 	echo "</pre>";
	$count=$stmt->rowCount();
	if($count==1){?>

	<div class="contain">
		 <div class="form-group">
			  	    <div class="col-sm-offset-4 col-sm-6">
				      <h1 class="text-center text-success">Edit Item Details </h1>
				  	</div>
			  </div> 
	<form class="form-horizontal" action="?do=update" method="POST" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-8"> 
		
	   <div class="form-group">
	   		<label class="col-sm-offset-1 col-sm-3 control-label">item Name</label>
		    <div class="col-sm-8">
		      <input class="form-control"  type="hidden" name="id" value="<?php echo $data['item_ID'];?>">
		      <input class="form-control"  type="text" name="name" placeholder="Item Name" autocomplete="off" value="<?php echo $data['Name'];?>" required="required">
		  	</div>
	   </div>
	   <div class="form-group">
		    <label class="col-sm-offset-1 col-sm-3 control-label">Description</label>
		    <div class="col-sm-8">
		      <input class="form-control" type="text" name="description"  placeholder="Item Description" value="<?php echo $data['Description'];?>" required="required" >
		    </div>
	   </div>
	  <div class="form-group">
	    <label class="col-sm-offset-1 col-sm-3 control-label">Price</label>
	    <div class="col-sm-8">
	      <input class="form-control" type="text" name="price"  placeholder="Type Item Price" value="<?php echo $data['Price'];?>" required="required"> 
	    </div>
	  </div> 
	  <div class="form-group">
	    <label class="col-sm-offset-1 col-sm-3 control-label">country of made </label>
	    <div class="col-sm-8">
	      <input class="form-control" type="text" name="country"  value="<?php echo $data['Country_made'];?>" placeholder="Type Item Price" > 
	    </div>
	  </div>
	    <div class="form-group">
	    <label class="col-sm-offset-1 col-sm-3 control-label">Tags</label>
	    <div class="col-sm-8">
	      <input class="form-control tags" type="text" name="tags"  value="<?php echo $data['Tag'];?>" placeholder="Type Item Price" > 
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-1 col-sm-3 control-label">Item Status</label>
	    <div class="col-sm-2">
				<select name="status">
					
					<option value="0" >....</option>
					<option value="New" <?php if($data['Status']=='New'){echo"selected";} ?> >New</option>
					<option value="like new" <?php if($data['Status']=='like new'){echo"selected";} ?>  >Like New</option>
					<option value="old" <?php if($data['Status']=='old'){echo"selected";} ?> >Old</option>
					<option value="Very old" <?php if($data['Status']=='Very old'){echo"selected";} ?>  >Very Old</option>

				</select>
		</div>
		 <label class=" col-sm-3 control-label">select related Member</label>
	     <div class="col-sm-2">
				<select name="members">
					<option value="0">....</option>
					<?php 
					$stmt=$con->prepare("select * from users");
					$stmt->EXECUTE();
					$user=$stmt->fetchALL();
					foreach($user as $val){
						if ($data['Member_id']===$val['userID']){
						echo "<option value=".$val["userID"]." selected>".$val["username"]."</option>";}else{
						echo "<option value=".$val["userID"].">".$val["username"]."</option>";
						}
						}
					
					?>
				</select>
		 </div>
	  </div>
	  	  <div class="form-group">
	      <label class=" col-sm-offset-1 col-sm-3 control-label">select related category</label>
	      <div class="col-sm-2">
				<select name="category">
					<option value="0">....</option>
					<?php 
					$stmt=$con->prepare("select * from categories");
					$stmt->EXECUTE();
					$cat=$stmt->fetchALL();
					foreach($cat as $val){
						if ($data['Cat_id']===$val['ID']){
						echo "<option value=".$val["ID"]." selected>".$val["Name"]."</option>";}else{
						echo "<option value=".$val["ID"].">".$val["Name"]."</option>";}
					}
					
					?>
				</select>
		 </div>
	  	</div>
	   </div>
	  	<div class="col-sm-4">
						<div class='thumbnail live items'>
							
								 <input id="uploads" type="file"  name="image" placeholder="Item Name" autocomplete="off"> 
								 <img class='addone img-responsive'  src='uploads\items\<?php echo $data["Image"] ;?>' alt='' />
									
						</div>
		</div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-4 col-sm-6">
	      <button class="btn btn-success" type="submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Save</button>
	    </div>
	  </div>
	</form>
  
	<?php

	$stmt2=$con->prepare("select comments.*,users.username  from comments
						 inner join users on comments.User_id=users.userID WHERE Item_ID=$ID");
	$stmt2->EXECUTE();
	$data2=$stmt2->fetchAll();
		if (!empty($data2)){
	 ?>
	 <div class="itemcomments">	  
	   
		<h2 class=" text-success">Show Item [<?php echo $data['Name'];?>] Comments </h2>
		<table class="table table-bordered text-center table-responsive">
			 <thead class="thead-inverse" >
			 	<tr>
					<th class="text-center">comment ID</th>
					<th class="text-center">Comment</th>
					<th class="text-center">user Name </th>
					<th class="text-center">Added date Date</th>
					<th class="text-center">Control</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<?php
				foreach($data2 as $val){ 
						echo "<tr>";
						 	echo "<td>".$val['Com_ID']."</td>";
						 	echo "<td>".$val['Comment']."</td>";
						  	echo "<td>".$val['username']  ."</td>";
						 	echo "<td>".$val['Com_Date']."</td>";
						 	echo "<td>";
						 	echo "<a class='btn btn-success btn-xs' href='comments.php?do=Edit&ComID=".$val['Com_ID']."'><i class='fa fa-edit'></i>Edit</a>";
						 		echo"<a class='btn btn-danger confirm btn-xs' href='comments.php?do=Delete&ComID=".$val['Com_ID']."'><i class='fa fa-close'></i>Delete</a>";
						 	if($val['Comm_status']==0){	
						 	echo "<a class='btn btn-info btn-xs' href='comments.php?do=Approve&ComID=".$val['Com_ID']."'><i class='fa fa-check'></i>Approve</a>";}

						 		}

							echo "</td>";
						echo "</tr>"?>
			</tbody>
		</table>	
	</div>

	<?php
}else{
	echo "<div class='itemcomments'>";
	echo "<h2 class='text-success text-center'>There is no comments for Item [".$data['Name']."] </h2> " ;
	echo "</div>";
}

}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='update') {

		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Edit Item Data </h1>";
				if($_SERVER['REQUEST_METHOD']=='POST'){
					 
					 	// image Data 
	
					$imagename=$_FILES['image']['name'];
					$imagetemp=$_FILES['image']['tmp_name'];
					$imagesize=$_FILES['image']['size'];
					$imageEXE = array("jpg","jpeg","png","gif");
					$end= explode ('.' , $imagename);
					$imagetype = strtolower( end ($end));



					$ID=$_POST['id'];
					$name=$_POST['name'];
					$desc=$_POST['description'];
					$pri=$_POST['price'];
					$country=$_POST['country'];
					$status=$_POST['status'];
					$mem=$_POST['members'];
					$cat=$_POST['category'];
					$tag=str_replace(' ','', filter_var($_POST['tags'],FILTER_SANITIZE_STRING) );

					if (!empty($imagename)){
					$imagerandname=rand(0,1000000).'_'.$imagename;
					move_uploaded_file($imagetemp,"uploads\items\\".$imagerandname);

					$stmt=$con->prepare("update items set Name=?,Description=?,Price=?,Country_made=?,Status=?,Cat_id=?,Member_id=?,Tag=?,Image=? where item_ID=?");
					$stmt->EXECUTE(array($name,$desc,$pri,$country,$status,$cat,$mem,$tag,$imagerandname,$ID));
					}else{

						$stmt=$con->prepare("update items set Name=?,Description=?,Price=?,Country_made=?,Status=?,Cat_id=?,Member_id=?,Tag=? where item_ID=?");
						$stmt->EXECUTE(array($name,$desc,$pri,$country,$status,$cat,$mem,$tag,$ID));
					}
					
					$count=$stmt->rowCount();
					$msg= " <strong>  $count Record </strong> updtaed ";
					msg_report($msg,'success',5); 
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
		      <h1 class="text-center text-success">Add New Item </h1>
		  	</div>
	  </div> 
	   <div class="form-group">
	   		<label class="col-sm-offset-2 col-sm-2 control-label">item Name</label>
		    <div class="col-sm-6">
		      <input class="form-control"  type="text" name="Name" placeholder="Item Name" autocomplete="off" required="required">
		  	</div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Description</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="Description"  placeholder="Item Description" required="required" >
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Price</label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="Price"  placeholder="Type Item Price" required="required"> 
	    </div>
	  </div> 
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">country of made </label>
	    <div class="col-sm-6">
	      <input class="form-control" type="text" name="country"  placeholder="Type Item Price" > 
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="col-sm-offset-2 col-sm-2 control-label">Item Status</label>
	    <div class="col-sm-2">
				<select name="status">
					<option value="0">....</option>
					<option value="New">New</option>
					<option value="like new">Like New</option>
					<option value="old">Old</option>
					<option value="Very old">Very Old</option>
				</select>
		</div>
		 <label class=" col-sm-2 control-label">select related Member</label>
	     <div class="col-sm-2">
				<select name="members">
					<option value="0">....</option>
					<?php 
					$stmt=$con->prepare("select * from users");
					$stmt->EXECUTE();
					$data=$stmt->fetchALL();
					foreach($data as $val){
						echo "<option value=".$val["userID"].">".$val["username"]."</option>";
					}
					
					?>
				</select>
		 </div>
	  </div>
	  	  <div class="form-group">
	      <label class=" col-sm-offset-2 col-sm-2 control-label">select related category</label>
	      <div class="col-sm-2">
				<select name="category">
					<option value="0">....</option>
					<?php 
					$stmt=$con->prepare("select * from categories ");
					$stmt->EXECUTE();
					$data=$stmt->fetchALL();
					foreach($data as $val){
						echo "<option value=".$val["ID"].">".$val["Name"]."</option>";
					}
					
					?>
				</select>
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
				echo "<h1 class='text-center text-success'>Insert New Item </h1>";
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
		//get data od user from form 
			
			$name=$_POST['Name'];
			$Desc=$_POST['Description'];
			$price=$_POST['Price'];
			$country=$_POST['country'];
			$status=$_POST['status'];
			$mem=$_POST['members'];
			$cat=$_POST['category'];
		
			$fault= array();
		
			if (empty($name)) { $fault[]="Name filed can't be<strong>  empty</strong> ";}
			if (empty($Desc)) { $fault[]="Description filed can't be <strong> empty</strong> ";}
			if (empty($price)) { $fault[]="Price  filed can't be <strong>less than 6 char</strong> ";}
			if (empty($country)) { $fault[]="Country filed can't be <strong>Empty</strong> ";}
			if ($status== "0") { $fault[]="Status filed can't be <strong>Empty</strong> ";}
			if ($mem== "0") { $fault[]="member ID  filed can't be <strong>Empty</strong> ";}
			if ($cat== "0") { $fault[]="Status filed can't be <strong>Empty</strong> ";}
		
		if (empty($fault)){

				$check=checkitem("Name","items",$name);
				if ($check== 1 ){
					$msg="This Itme $name already exist";
					msg_report($msg,'danger','back',5);

				}else{

				$stmt=$con->prepare("INSERT INTO items(Name,Description,Price,Country_made, Status,Member_id,Cat_id,Add_Date) VALUES (?,?,?,?,?,?,?,now())");
				$stmt->EXECUTE(array($name,$Desc,$price,$country,$status,$mem,$cat)); 
				$count=$stmt->rowCount();
				$msg= " <strong>  $count Record </strong> Added ";
				msg_report($msg,'success','back',5);
			
		
				}
			//end from validation 
			
			}else{
				 		foreach ($fault as $error) {
				echo "<div class='alert alert-danger'>$error</div>";}
				$msg="";
				msg_report($msg,'danger','back',5);
		
			}
		}else{
			$msg="you can't log from here";
			msg_report($msg,5);}

			echo "</div>";

		
//++++++++++++++++++++++++++++++++++++++++++++++++++(Delete Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Delete') {

	if(isset($_GET['itemID'])&&is_numeric($_GET['itemID'])){
		

		$ID=intval($_GET['itemID']);
	}else{

		$ID=0;
	}

		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Delete Member Data </h1>";
	$count=checkitem("item_ID","items",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){
		$stmt=$con->prepare("DELETE from items where item_ID=? LIMIT 1");
		$stmt->EXECUTE(array($ID));

		$msg= " <strong>  $count Record </strong> Deleted ";
				// msg_report($msg,'success','back',0);
				header('location:items.php');
	}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);
	}
	echo "</div>";
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++( Activate Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}elseif ($do=='Approve') {
	if(isset($_GET['itemID'])&&is_numeric($_GET['itemID'])){
		
		$ID=intval($_GET['itemID']);
	}else{

		$ID=0;
	}
		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Approve on Item </h1>";

	$count=checkitem("item_ID","items",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){

				$stmt=$con->prepare("update items set Item_status=1 where item_ID=? LIMIT 1");
				$stmt->EXECUTE(array($ID));
				$count=$stmt->rowCount();
				// $msg= " <strong>  $count Record </strong> Activated";
				// msg_report($msg,'success','back',0);	
					if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				}else{  $url='items.php';}

			header("location:$url");
			
			}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);}

}else{ $msg="wrong bage inserted";
		msg_report($msg,'danger','back',5);
}
echo " </div> ";
?>
