
<?php  
ob_start();
session_start();
$pagetitle="Selected Items";

isset($_SESSION['fuser']) ? include "ini.inc" : header('location:login.php');
 
 if(isset($_SESSION['ID'])){

 	
 	$stmt=$con->prepare("SELECT item_log.*,items.Name as Item_name,items.Image,items.Price  from item_log
						 inner join items on item_log.item_ID=items.item_ID	where User_ID=? and  buy_status=0");
	$stmt->EXECUTE(array($_SESSION['ID']));
	$data5=$stmt->fetchAll();
 // 	$stmt5=$con->prepare("SELECT * from item_log where User_ID=? ");
	//  $stmt5->EXECUTE(array($_POST['user']));
	//  $data5=$stmt5->fetchAll()

?>
	<div class="container">
	<h1 class="text-center"> Welcome to Manage Items </h1>
	<table class="table table-bordered text-center table-responsive">
		 <thead class="thead-inverse" >
		 	<tr>
				<th class="text-center">Image</th>
				<th class="text-center">Item Name</th>
				<th class="text-center">Price</th>
				<th class="text-center">number of items </th>
				<th class="text-center">Selection Date</th>
				<th class="text-center">Control</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php
			foreach($data5 as $val){ 
					echo "<tr>";
					 	
					 	echo "<td><img class='miniimg'  src='admin\uploads\items\\".$val["Image"]."' alt='' /></td>";
					 	echo "<td>".$val['Item_name']."</td>";
					 	echo "<td>".$val['Price']  ."</td>";
					 	echo "<td>".$val['numofitems']."</td>";
					 	echo "<td>".$val['day']."</td>";
					  	echo "<td>";
					 	
					 	echo "<a class='btn btn-info btn-xs' href='?do=Approve&itemID=".$val['item_ID']."'><i class='fa fa-check'></i>Buy it</a>";
					 	echo "<a class='btn btn-danger btn-xs btn-drop'
					 				href='selecteditems.php'
					 			 data-item='".$val['item_ID']."'
					 			 data-user='". $_SESSION['ID'] ."'
					 			  data-num='".$val['numofitems']."'><i class='fa fa-times'></i>Drop it</a>";}

					 

						echo "</td>";
					echo "</tr>";}?>

		</tbody>
	</table>
		
</div>


	<?php  


 ?>


