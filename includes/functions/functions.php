<?php 

// function to return the page title as it's ganged from page to page and header is fixed configured 

	function gettitle(){

		global $pagetitle;

	if (isset($pagetitle)){

		echo $pagetitle;
		
	}else{echo "Default";}	

						}
	/* 
	**function to rebort redirected massage notification
	**version 1.0
	**accept parameters 
	**
	*/

	function msg_report($msg,$type='danger', $url = null , $sec=3){

		if ($url === null){

			$url="index.php";
			$link ="Home page";
			
		}else{

			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
				$url=$_SERVER['HTTP_REFERER'];
				$link ="previous page";
			
					}else{  $url='index.php';
							$link ="Home page";}}
		echo "<div class='container'>";
		if (!empty($msg)){
		echo "<div class='alert alert-$type'>$msg</div>";}

		echo "<div class='alert alert-info'>you will be directed to $link after $sec</div>";
		echo "</div>";
		header("refresh:$sec;url=$url");}

		/*
		**version 1.0
		**function to find items in database
		**accept parameters 
		*/
	function checkitem($select,$from,$where){

		global $con;

		$stmt1=$con->prepare("SELECT $select FROM $from WHERE $select=?");
		$stmt1->EXECUTE(array($where));
		return $stmt1->rowCount();
	}

	/*
	**version 1.0
	**function to return the number of counts of crtain column in Data base 
	**accept parameters 
	*/
	function countcol($col_nam,$DBname){
		global $con;
		$stmt=$con->prepare(" SELECT COUNT($col_nam) from $DBname ");
		$stmt->EXECUTE();
		return $stmt->fetchColumn();
		}

	/*
	**function to return the last added in data base  
	**version 1.0
	**accept parameters 
	*/
	function lastitems($from,$orderby,$Limit){
		
		global $con;
		if (isset($limit)){
		$stmt=$con->prepare(" SELECT * from $from ORDER BY $orderby DESC limit $Limit ");}
		else{
			$stmt=$con->prepare(" SELECT * from $from ORDER BY $orderby DESC");
		}
		$stmt->EXECUTE();
		return $stmt->fetchall();

		}
	/*
	**function to return all selected items from items table   
	**version 1.0
	**accept parameters :
					$selection : is the coloumn that we will filter on it .
					$id: is the ID that we will filter on it in the selected coloumn.
	*/
		function getitems($selection,$id){

			global $con;
			$stmt=$con->prepare("SELECT * from items WHERE $selection=? ORDER BY  item_ID DESC ");
			$stmt->EXECUTE(array($id));
			$items1=$stmt->fetchAll();
			return $items1;

		}

?>