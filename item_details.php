<?php  
ob_start();
session_start();

$pagetitle="Item Details";

include "ini.inc" ;

	if(isset($_GET['itemid'])&&is_numeric($_GET['itemid'])){

		$ID=intval($_GET['itemid']);

	}else{

		header('location:index.php');		}

		//get data of items from form 
			// image Data 
			
			$stmt=$con->prepare("select items.*,users.username,categories.name as category_name from items
						 inner join users on items.Member_id=users.userID	 
						 inner join categories on items.Cat_ID=Categories.ID where item_ID = $ID ");
	// }
						$stmt->EXECUTE();
						$data=$stmt->fetch();
				if($stmt->rowCount()>0)	{	
					$ratedusers=explode(',', $data['ratedusers']);
					$tags=explode(',', $data['Tag']);
	// ====================================== QUERY TO KNOW IF USER ALREADY BOUGHT THIS ITEM BEFORE OR NOT =============================

					$stmt1=$con->prepare("SELECT * from item_log where User_ID=? AND item_ID=? AND buy_status=0");
		            $stmt1->EXECUTE(array($_SESSION['ID'],$ID));
		            $cartnum1=$stmt1->rowCount();
		           
?>
				<div class="container itemdetails">
							  	    		
					<h1 class="text-center text-success"><?php Echo $data['Name'];?> </h1>
					     			
	
						<div class="row ">
							<div class="col-sm-3">
									 <img class='item_image img-responsive img-thumbnail center-block' src='admin\uploads\items\<?php Echo $data['Image']; ?>' alt='' />
									<p> Remaining [<span class="text-success" id="totalamount"><?php echo $data['total_amount'];?></span>] Item</p>

									<span class="nav-cart-icon nav-sprite"></span>
									<?php
									if (isset($_SESSION['ID'] ) ){
										echo '<div class="cart">';
										if ( $data['total_amount'] >0 ){

									echo '<a class="btn btn-sm cart-btn" 
											data-item="'. $data['item_ID'].'" 
											data-user="'. $_SESSION['ID'] ;
										

											if ($cartnum1 == 0){
												echo '"data-check="0"';
											}else{
												echo '"data-check="1" 
												href="selecteditems.php"';
											}
											echo '>
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											Add to Cart</a>';
											$i=0;
											echo "<select id='selected' class='chosen' style='width:60px;'>";
											
											while ( $i<= $data['total_amount'] ) {
											
													echo '<option value="'.$i.'">'.$i.'</option>';
													
												   $i++;

											}


											echo ' </select>  </div>';
											}else{
												echo " <span class='text-danger'> Out of stock <span>";
											}
											
										}?> 
							</div>
							<div class="col-sm-9">					
								<h2><?php Echo $data['Name']; ?> </h2>
								<p><?php Echo $data['Description']; ?></P>
											<ul class="list-unstyled details">
												<li><span><i class="fa fa-calendar"></i>Regestiration Dates </span>: <?php Echo $data['Add_Date']; ?></li>
												<li><span><i class="fa fa-money"></i>Price</span>: <?php Echo $data['Price']; ?> $</li>
												<li><span><i class="fa fa-newspaper-o"></i>made in</span>: <?php Echo $data['Country_made']; ?></li>
												<li><span><i class="fa fa-tag"></i>Category</span>: <a href="Departments.php?catid=<?php echo $data['Cat_id'];?>&catname= <?php Echo $data['category_name']; ?>"><?php Echo $data['category_name']; ?></a></li>
												<li><span><i class="fa fa-user" ></i>Added By</span>: <?php Echo $data['username']; ?></li>
												<?php 
													
													if(!isset($_SESSION['fuser'])||in_array($_SESSION['fuser'],$ratedusers)){
												?>
												<li><span><i class="fa fa-star-o" ></i>Rate It</span>: <div class="ratting jDisabled" data-average="<?php Echo $data['totalrate']; ?>" data-id="<?php echo $ID;?>"></div></li>
												<?php 
												}else{?>

												<li><span><i class="fa fa-star-o" ></i>Rate It</span>: <div class="ratting " data-average="<?php Echo $data['totalrate']; ?>" data-id="<?php echo $ID;?>"></div></li>
													<?php  } ?>
												<li><span>Tags</span>:  
												<?php if (!empty($data['Tag'])){
													$tags=explode(',', $data['Tag']);
													echo "<ul class='taglist'>";

													foreach ($tags as $tag) { 	
														if (!empty($tag)){
														echo "<li><a href='Tags.php?Tag=".$tag."'>".$tag."</a></li>"; }
													}

													echo "</ul>";
												}?>

												</li>

													
											</ul>
									</div>
				 			</div>
						<hr>
						<div class="row">
							<div class="col-sm-offset-3 col-sm-9">
								<p>add Commment here </P>
							<?php 
							if (!isset($_SESSION['ID'])){

								echo "<div class='errormsg'>
											kindly <a href='login.php'>sign IN/UP</a> to be able to add your commnet here
									  </div>";
								
									
	 								}else{?>

									<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']."?itemid=".$_GET['itemid']; ?>" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<textarea class="form-control" name="comment"> </textarea>
									</div>
									  <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-pencil-square-o"></i> Submit</button>
									</form>
								
							<?php
								
									if ($_SERVER['REQUEST_METHOD']=="POST"){
									$comm=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
									if(!empty($comm)){
									$stmt=$con->prepare("INSERT INTO comments (Comment,Item_ID,User_ID,Com_Date) VALUES (?,?,?,now())");
									$stmt->EXECUTE(array($comm,$data['item_ID'],$_SESSION['ID'])); 
									}else{
										echo "<div class='errormsg'>
												comment can't be empty 
											  </div>
											 
											  ";

									}
									}
								}

							?>
							</div>
								</div>
						
							<hr>
						
							<?php 
									$stmt2=$con->prepare("SELECT comments.*,users.username from comments
														 inner join users on comments.User_id=users.userID where Item_ID=? AND Comm_Status=1 ORDER BY Com_ID DESC ");
							// $stmt=$con->prepare("select * from comments");
									$stmt2->EXECUTE(array($ID));
									$data2=$stmt2->fetchAll();
							if ($stmt2->rowCount()>0) {

									foreach ($data2 as $comment) {	?>
							<div class="row">
								<div class="text-center col-sm-offset-1 col-sm-2">
									<div class="userimage">
											<img src="admin\uploads\users\Koala.jpg">
									</div>
									<h4><?php echo $comment['username'];?></h4>
								</div>
								<div class="col-sm-9">
									<div class="text-con">
										<p><?php echo $comment['Comment']; ?></P>
									</div>
								</div>
							</div>
							<hr>


<?php	} 
			}else{

echo "<div class='errormsg'>
			there is no comments on this items   
		</div>";

					}
echo "</div> </div>";


}else{
echo "<div class='errormsg'>
			there is no item with this ID 
		</div>";

}		
ob_end_flush();
			?>
			</div>