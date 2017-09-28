<?php 
 session_start();

 $pagetitle="Comments";

 isset($_SESSION['user']) ? include"ini.inc" :header("location:index.php");
 
 echo "<div class='items container'>";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage'; // check if the request is come from GET with certain key (do )

// what we will do if the reques is $_GET request 

if ($do=='manage'){// manage page to show all added members

	$stmt=$con->prepare("select comments.*,users.username,items.Name as item_name from comments
						 inner join users on comments.User_id=users.userID	 
						 inner join items on comments.Item_ID=items.item_ID");
// $stmt=$con->prepare("select * from comments");
	$stmt->EXECUTE();
	$data=$stmt->fetchAll(); ?>

<div class="container">
	<h1 class="text-center"> Welcome to Manage Comments </h1>
	<table class="table table-bordered text-center table-responsive">
		 <thead class="thead-inverse" >
		 	<tr>
				<th class="text-center">comment ID</th>
				<th class="text-center">Comment</th>
				<th class="text-center">Item Name </th>
				<th class="text-center">user Name </th>
				<th class="text-center">Added date Date</th>
				<th class="text-center">Control</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php
			foreach($data as $val){ 
					echo "<tr>";
					 	echo "<td>".$val['Com_ID']."</td>";
					 	echo "<td>".$val['Comment']."</td>";
					 	echo "<td>".$val['item_name'] ."</td>";
					 	echo "<td>".$val['username']  ."</td>";
					 	echo "<td>".$val['Com_Date']."</td>";
					 	echo "<td>";
					 	echo "<a class='btn btn-success btn-xs' href='?do=Edit&ComID=".$val['Com_ID']."'><i class='fa fa-edit'></i>Edit</a>";
					 		echo"<a class='btn btn-danger confirm btn-xs' href='?do=Delete&ComID=".$val['Com_ID']."'><i class='fa fa-close'></i>Delete</a>";
					 	if($val['Comm_status']==0){	
					 	echo "<a class='btn btn-info btn-xs' href='?do=Approve&ComID=".$val['Com_ID']."'><i class='fa fa-check'></i>Approve</a>";}

					 		}

						echo "</td>";
					echo "</tr>"?>

		</tbody>
	</table>
		
</div>

<?php


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='Edit') {

		if(isset($_GET['ComID'])&&is_numeric($_GET['ComID'])){

		$ID=intval($_GET['ComID']);

	}else{

		$ID=0;
		}

	$stmt=$con->prepare("SELECT * FROM Comments where Com_ID=$ID");
	$stmt->EXECUTE();
	$data=$stmt->fetch();
	// echo "<pre>";
	// print_r($data);
	// 	echo "</pre>";
	$count=$stmt->rowCount();
	if($count==1){ ?>

	<div class="contain">
	
	<form class="form-horizontal" action="?do=update" method="post">
	  <div class="form-group">
	  	    <div class="col-sm-offset-3 col-sm-7">
		      <h1 class="text-center text-success">Edit Comments Details </h1>
		  	</div>
	  </div> 

	  	   <div class="form-group">
		   		<label class="col-sm-offset-2 col-sm-2 control-label">user Comment</label>
			    <div class="col-sm-6">
			      <input class="form-control"  type="hidden" name="id" value="<?php echo $data['Com_ID'];?>">
			      <textarea class="form-control" name="comment"><?php echo $data['Comment']?></textarea>
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
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}elseif ($do=='update') {

		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Edit Comment Data </h1>";
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$ID=$_POST['id'];
					$coms=$_POST['comment'];

					$stmt=$con->prepare("update comments set Comment=? where Com_ID=?");
					$stmt->EXECUTE(array($coms,$ID));
					$count=$stmt->rowCount();

					$msg= " <strong>  $count Record </strong> updtaed ";
					msg_report($msg,'success',5); 
					}else{
						$msg="you can't log from here";
						msg_report($msg,'danger','back',5);}
						
		echo "</div>";

//++++++++++++++++++++++++++++++++++++++++++++++++++(Delete Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

}elseif ($do=='Delete') {

	if(isset($_GET['ComID'])&&is_numeric($_GET['ComID'])){
		

		$ID=intval($_GET['ComID']);
	}else{

		$ID=0;
	}

		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Delete Member Data </h1>";
	$count=checkitem("Com_ID","comments",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){
		$stmt=$con->prepare("DELETE from Comments where Com_ID=? LIMIT 1");
		$stmt->EXECUTE(array($ID));

		$msg= " <strong>  $count Record </strong> Deleted ";
				// msg_report($msg,'success','back',0);
				header('location:Comments.php');
	}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);
	}
	echo "</div>";
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++( Activate Page )+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}elseif ($do=='Approve') {
	if(isset($_GET['ComID'])&&is_numeric($_GET['ComID'])){
		
		$ID=intval($_GET['ComID']);
	}else{

		$ID=0;
	}
		echo "<div class='container'>";
		echo "<h1 class='text-center text-success'>Approve on Item </h1>";

	$count=checkitem("Com_ID","comments",$ID);
					
// rowcount will retune the serach result with counts 
	if ($count>0){

				$stmt=$con->prepare("update comments set Comm_status=1 where Com_ID=? LIMIT 1");
				$stmt->EXECUTE(array($ID));
				$count=$stmt->rowCount();
				// $msg= " <strong>  $count Record </strong> Activated";
				// msg_report($msg,'success','back',0);	
					if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				}else{  $url='Comments.php';}

			header("location:$url");
			
			}else{
					$msg="this user $ID Does not exist";
					msg_report($msg,'danger','back',5);}

}else{ $msg="wrong bage inserted";
		msg_report($msg,'danger','back',5);
}
echo " </div> ";
?>
