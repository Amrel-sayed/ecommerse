<?php  
ob_start();
session_start();

$pagetitle="profile";

isset($_SESSION['fuser']) ? include "ini.inc" : header('location:login.php');

$stmt=$con->prepare("select * from users where userID=?");
$stmt->EXECUTE(array($_SESSION['ID']));
$userdata=$stmt->fetch();
?>
<div class="container profile">
	<div class="information item">
		<div class="panel panel-primary">
			<div class="panel-heading">My information</div>	
			<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					 
						<img class="addone userimage" src="<?php echo $userdata['image'] ;?>">
				</div>
				<div class="col-sm-8">
					<ul class="list-unstyled userdata">
				
							<li><span><i class="fa fa-user-circle-o fa-fw" aria-hidden="true"></i> Name</span>: <?php echo $userdata['username'];?></li>
						
							<li><span><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>E-Mail</span>:<?php echo$userdata['Email'];?></li>
						
							<li><span><i class="fa fa-user-secret fa-fw" aria-hidden="true"></i>Nickname</span>:<?php echo$userdata['Displayname'];?></li>
						
							<li><span><i class="fa fa-calendar fa-fw" aria-hidden="true"></i>Registration Day </span>:<?php echo$userdata['Day'];?></li>
						
							<li><span><i class="fa fa-tag fa-fw" aria-hidden="true"></i>Favourite Category </span>:<?php echo$userdata['Day'];?></li>
						
						</ul>
				</div>	
			</div>	
		</div>
	</div>
	<div class="information item">
		<div class="panel panel-primary">
			<div class="panel-heading">
					MY Ads  
				<a href="newitem.php" class="pull-right">+ Add New</a></div>	
			<div class="panel-body">
				
	

				<div class="row galary">
					<?php 
					$items=getitems("Member_id",$userdata['userID']);
					if (!empty($items)){

					foreach($items as $item){
						echo "<div class='col-md-3 col-sm-6'>";
							echo "<a href='item_details.php?itemid=".$item['item_ID']."'>";
							echo "<div class='thumbnail items'>";

								// echo "<img class='img-responsive' src='layout/images/".$item['item_ID'].".jpg'alt='' />";
								echo "<span class='pricetag'>".$item['Price']." $</span>";
									if ($item['Item_status'] < 1){
								echo "<span class='apprtag'> Not Approved </span>";}
								
								echo "<div class='imgcontainer'>";
									echo "<img class='img-responsive item_image' src='admin\uploads\items\\".$item['Image']."'alt='' />";
								echo "</div>";

								echo "<div class='caption'>";
									echo "<h3>".$item['Name']."</h3>";
									echo"<p>".$item['Description']."</P>";
									echo"<span>".$item['Add_Date']."</span>";
								echo "</div>";

							echo "</div>";	
							echo "</a>";
						echo "</div>";	
					}}else{
							echo "<div class='errormsg'>
										<p>there is no Ads posted from this User</p>
									</div>
							";
					}

					?>
				</div>

			</div>	
		</div>
	</div>
	<div class="information item">
		<div class="panel panel-primary">
			<div class="panel-heading">Latest Comments</div>	
			<div class="panel-body">
			<ul class="list-unstyled">
				<?php 
				// $stmt=$con->prepare("select comments.*,items.Name from comments
				// 		  			 inner join items on comments.Item_ID=items.item_ID where User_ID=? ORDER BY Com_ID DESC ");
				// $stmt=$con->prepare("select * from comments where User_ID=?");
				$stmt2=$con->prepare("SELECT comments.*,items.Name,items.Image from comments
									  inner join items on comments.Item_ID=items.item_ID where User_ID=? AND Comm_Status=1 ORDER BY Com_ID DESC ");
				$stmt2->EXECUTE(array($userdata['userID']));
				$usercomment=$stmt2->fetchAll(); 
			
		if(!empty($usercomment)){
					  	foreach($usercomment as $comment){?>
				  		
					  		<div class="row">
					  			<a href='item_details.php?itemid=<?php echo $comment["Item_ID"] ?>'>	
									<div class="text-center col-sm-offset-1 col-sm-2">
										<div class="itemimage">
												<img src="admin\uploads\items\<?php echo $comment['Image'];?>">
										</div>
										<h4><?php echo $comment['Name'];?></h4>
									</div>
								</a>
								<div class="col-sm-9">
									<div class="text-con">
										<p><?php echo $comment['Comment']; ?></P>
									</div>
								</div>
							</div>
						<hr>			  		

							
		<?php }}else{
				echo "<div class='errormsg'>
							<p>there is no Comments posted by this User</p>
						</div>
				";}
						
	ob_end_flush();							?>
			</ul>
			</div>	
		</div>
	</div>

</div>