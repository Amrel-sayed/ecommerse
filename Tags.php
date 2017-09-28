<?php 
session_start();

$tag=isset($_GET["Tag"]) ? $_GET["Tag"] : '';


$pagetitle="Home page ||". $tag;

include "ini.inc";

?>
<div class="container galary">


<h1 class='text-center text-success'><i class="fa fa-tag"></i><?php echo $tag; ?></h1>

	<div class="row">
<?php 
			$stmt4=$con->prepare("SELECT * from items WHERE Tag like '%$tag%' ORDER BY  item_ID DESC ");
			$stmt4->EXECUTE();
			$items4=$stmt4->fetchAll();


if(!empty($items4)){

foreach($items4 as $item){
	if ($item['Item_status']>0){
	echo "<div class='col-md-3 col-sm-6'>";
	echo "<a href='item_details.php?itemid=".$item['item_ID']."'>";
		echo "<div class='thumbnail items'>";

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
				echo "<h3 class='text-center text-danger'> ".$item['Price']." $</h3>";
				echo "<h2>".$item['Name']."</h2>";
				echo"<p>".$item['Description']."</P>";
				echo"<div class='hiddenp'>".$item['Description']."</div>";
				echo"<span>".$item['Add_Date']."</span>";
				echo "</div>";
					echo "</a>";
			echo "</div>";	
	echo "</div>";	
}else{
		echo "<div class='errormsg'>
			<p>there is Ads and not approved yes</p>
				</div>";}}
}else{
		echo "<div class='errormsg'>
			<p>there is No Ads posted in this Department</p>
				</div>";
}

?>
</div>

</div>


