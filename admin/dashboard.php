<?php  
session_start();

$pagetitle="Dashboard";

(isset($_SESSION['user'])) ? include "ini.inc":header('location:index.php');

$lastmembers=lastitems("users","userID",5);
$lastitem=lastitems("items","item_ID",5);

?>
<div class="container dashboard ">
	<div class="statistics text-center">	
		<h1>Dashboard</h1>

		<div class="row">
			<div class="col-md-3">
				<div class="items st-mem">
					<a href="Members.php">
					<i class="fa fa-users pull-left"></i>
						<div class="pull-left">
							<p>Total Members</p>
							<span><?php Echo $count=countcol("userID","users"); ?></span>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="items st-pmem"><a href="Members.php">
					<a href="Members.php?do=manage&stat=reg">
					<i class="fa fa-user-plus pull-left" aria-hidden="true"></i>
						<div class="pull-left">
							<p>Pending Members</p>
							<span><?php Echo $count=checkitem("regstatus","users",0) ?></span>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="items st-items">
					<a href="items.php">
						<i class="fa fa-tags pull-left" aria-hidden="true"></i>
							<div class="pull-left">
								<p>Total Items</p>
								<span><?php Echo $counti=countcol("item_ID","items"); ?></span>
							</div>
					</a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="items st-com">
					<a href="items.php">
					<i class="fa fa-weixin pull-left" aria-hidden="true"></i>
						<div class="pull-left">
							<p>Total Comments</p>
							<span>3500</span>
						</div>
					</a>

				</div>
			</div>
		</div>
	</div>
	<div class="latest">	
		<div class="row">
			<div class="col-md-6 members">
				<div class="panel panel-default">
					  <div class="panel-heading"><i class="fa fa-users"></i>Latest Registered Users</div>
					  <i class='fa fa-minus pull-right fa-lg pglo'></i>
					  <div class="panel-body">
					  		<ul class="list-unstyled">
					  		<?php 
					  			foreach($lastmembers as $valu ){

					  				echo "<li> <p>". $valu['username']."</p>";
					  				echo "<div class='cont'>";
					  					echo "<a class='btn btn-success btn-xs' href='members.php?do=Edit&userID=".$valu['userID']."'><i class='fa fa-edit'></i>Edit</a>";
										 	if($valu['regstatus']==0){	
					 					echo "<a class='btn btn-info btn-xs' href='members.php?do=Activate&userID=".$valu['userID']."'><i class='fa fa-check'></i>Approve</a>";}
					  			echo "</div>";	
					  			echo"</li>";
					  		}
					  		?>
					  		</ul>
					  </div>
				</div>
			</div>
			<div class="col-md-6 items">
				<div class="panel panel-default">
					  <div class="panel-heading"><i class="fa fa-tag"></i>Latest Items</div>
					  <i class='fa fa-minus pull-right fa-lg pglo'></i>
					  <div class="panel-body">
						  	<ul class="list-unstyled">
						  		<?php 
						  			foreach($lastitem as $valu ){
				  			 				
					  				echo "<li> <p>". $valu['Name']."</p>";
					  				echo "<div class='cont'>";
					  					echo "<a class='btn btn-success btn-xs' href='items.php?do=Edit&itemID=".$valu['item_ID']."'><i class='fa fa-edit'></i>Edit</a>";
										 	if( $valu['Item_status']==0){	
					 					echo "<a class='btn btn-info btn-xs' href='items.php?do=Approve&itemID=".$valu['item_ID']."'><i class='fa fa-check'></i>Approve</a>";}
					 					echo "</div>";	
					  			 	echo "</li>";

						  			}
						  		?>

					 	 </ul>

					  </div>
				</div>
				</div>		
	<div class='clearfix'></div>
			<div class="col-md-6 comment">
				<div class="panel panel-default">
					  <div class="panel-heading"><i class="fa fa-tag"></i>Latest Comments</div>
					  <i class='fa fa-minus pull-right fa-lg pglo'></i>
					  <div class="panel-body">
						  	<ul class="list-unstyled">
						  		<?php 
						  		$stmt= $con->prepare("select comments.*,users.username from comments
						  							  inner join users on comments.User_id=users.userID ORDER BY Com_ID DESC limit 5 ");
						  		$stmt->EXECUTE();

						  		$lastcomment=$stmt->fetchALL();
						  			foreach($lastcomment as $valu ){
				  			 				
					  				echo "<li> <div class='combox'>";

						  				echo "<p class='com-n pull-left'>". $valu['username']."</p>";
						  				echo "<p class='com-c pull-left'>". $valu['Comment']."</p>";
						  				echo "<div class='clearfix'></div>";
					  				echo "</div> </li>";

	
						  			}
						  		?>

					 	 </ul>

					  </div>
				</div>
			</div>

		</div>
	</div>
</div>


