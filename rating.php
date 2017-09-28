

<?php 
session_start();

isset($_SESSION['fuser']) ? include "ini.inc" : header('location:login.php');

if ($_SERVER['REQUEST_METHOD']=="POST"){
		$id=$_POST['idBox'];
		$rate=$_POST['rate'];
		$user=$_SESSION['fuser'];
		
		$stmt=$con->prepare("SELECT * FROM items where item_ID = ? ");
		$stmt->EXECUTE(array($id));
		$item=$stmt->fetch();
		$ratenum=$item['ratesnum'] + 1;
		$totalrate=$item['totalrate']+$rate;
		$avrate=$totalrate/$ratenum;


		$stmt2=$con->prepare("update items set Rating=?,ratesnum=?,totalrate=?,ratedusers=CONCAT(ratedusers,',$user') where item_ID=?");
					$stmt2->EXECUTE(array($rate,$ratenum,$avrate,$id));
					$count=$stmt2->rowCount();
echo $ratenum;
}
	?>