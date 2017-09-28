<?php  
ob_start();
session_start();

$pagetitle="Home page";

include "ini.inc" ;

$stmt=$con->prepare("SELECT * FROM items where Item_status = 1 ORDER BY Item_ID DESC ");
$stmt->EXECUTE();
$items=$stmt->fetchALL(); ?>
<div class="container home">
<div class="row galary">

<?php if (!empty($items)){

					foreach($items as $item){
						echo "<div class='col-md-3 col-sm-6'>";
							echo "<a href='item_details.php?itemid=".$item['item_ID']."'>";
							echo "<div class='thumbnail items'>";

								// echo "<img class='img-responsive' src='layout/images/".$item['item_ID'].".jpg'alt='' />";
								echo "<span class='pricetag'>".$item['Price']." $</span>";			
								echo "<div class='imgcontainer'>";
									echo "<img class='img-responsive item_image' src='admin\uploads\items\\".$item['Image']."'alt='' />";
								echo "</div>";
									echo "<div class='row '>";
									echo "<div class='col-sm-8'>";

									echo '<div class="ratting jDisabled" data-average="'.$item['totalrate'].'" data-id="'.$item['item_ID'].'"></div>';
									echo "</div>";
									echo "<div class='col-sm-4'>";
										echo "<p class='ratnum'>( ".$item['ratesnum']." )</p>";		
									echo "</div>";
									echo "</div>";

								echo "<div class='caption'>";
									echo "<h3>".$item['Name']."</h3>";
									
									echo"<p>".$item['Description']."</P>";
									echo"<div class='hiddenp'>".$item['Description']."</div>";

									echo"<span>".$item['Add_Date']."</span>";
								echo "</div>";

							echo "</div>";	
							echo "</a>";
						echo "</div>";	
						echo "<div class='clear-fix'></div>";	
					}}else{
							echo "<div class='errormsg'>
										<p>there is no Ads posted from this User</p>
									</div>
							";
					}
					ob_end_flush();
?>
	</div>
	</div>

 

