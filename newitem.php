<?php  
ob_start();
session_start();

$pagetitle="New Item";

isset($_SESSION['fuser']) ? include "ini.inc" : header('location:login.php');

?>


<div class="container newitem">
		<div class="form-group">
				  	    		
					     			 <h1 class="text-center text-success">Add New Item </h1>
					     			 <?php 	
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
		//get data of items from form 
			// image Data 
			
			$imagename=$_FILES['image']['name'];
			$imagetemp=$_FILES['image']['tmp_name'];
			$imagesize=$_FILES['image']['size'];
			$imageEXE = array("jpg","jpeg","png","gif");
			$end= explode ('.' , $imagename);
			$imagetype = strtolower( end ($end));

			// the rest item form data 	
			
			$name=filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
			$Desc=filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
			$price=filter_var($_POST['Price'],FILTER_SANITIZE_NUMBER_INT);
			$amount=filter_var($_POST['amount'],FILTER_SANITIZE_NUMBER_INT);
			$country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
			$status=filter_var($_POST['status'],FILTER_SANITIZE_STRING);
			$mem=$_SESSION['ID'];
			$cat=filter_var($_POST['category'],FILTER_SANITIZE_STRING);
			$tag=str_replace(' ','', filter_var($_POST['tags'],FILTER_SANITIZE_STRING) );
		
			$fault= array();
		
			if (empty($name)) { $fault[]="Name filed can't be<strong>  empty</strong> ";}
			if (empty($Desc)) { $fault[]="Description filed can't be <strong> empty</strong> ";}
			if (empty($price)) { $fault[]="Price  filed can't be <strong>less than 6 char</strong> ";}
			if (empty($country)) { $fault[]="Country filed can't be <strong>Empty</strong> ";}
			if ($status== "0") { $fault[]="Status filed can't be <strong>Empty</strong> ";}
			if ($mem== "0") { $fault[]="member ID  filed can't be <strong>Empty</strong> ";}
			if ($cat== "0") { $fault[]="Status filed can't be <strong>Empty</strong> ";}
			if (!empty($imagename)&&!in_array($imagetype,$imageEXE)){$fault[]="This Image EXET. <strong>Not Allowed</strong> ";		}
		if ($imagesize> 4194304 ){$fault[]="This Image size must be less than 4 Mega ";		}
		
		if (empty($fault)){

				$check=checkitem("Name","items",$name);
				if ($check== 1 ){
					$msg="This Itme $name already exist";
					msg_report($msg,'danger','back',5);

				}else{
					if (!empty($imagename)){
					$imagerandname=rand(0,1000000).'_'.$imagename;
					move_uploaded_file($imagetemp,"admin\uploads\items\\".$imagerandname);
				}else{
					$imagerandname="addphoto.jpg";
				}

				$stmt=$con->prepare("INSERT INTO items(Name,Description,Price,Country_made, Status,Member_id,Cat_id,Add_Date,image,Tag,total_amount) VALUES (?,?,?,?,?,?,?,now(),?,?,?)");
				$stmt->EXECUTE(array($name,$Desc,$price,$country,$status,$mem,$cat,$imagerandname,$tag,$amount)); 
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
		}?>
					  	
	  <div class="panel panel-primary">
				<div class="panel-heading">Items information</div>	
					<div class="panel-body">
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-8">
								
				  		
							 <div class="form-group">
									<label class="col-sm-2 control-label">item Name</label>
									<div class=" col-sm-offset-2 col-sm-6">
										 <input class="form-control typing" 
										  type="text" 
										  name="Name" 
										  placeholder="Item Name" 
										  autocomplete="off" 
										  data-tag=".name" required="required">
									</div>
							  </div>
							  <div class="form-group">
								    <label class=" col-sm-2 control-label">Description</label>
								    <div class=" col-sm-offset-2 col-sm-6">
								     	 <textarea class="form-control typing" name="Description"  placeholder="Item Description" required data-tag=".desc"> </textarea>
								    </div>
							   </div>
							   <div class="form-group">
								    <label class="col-sm-2 control-label">Price</label>
									    <div class=" col-sm-offset-2 col-sm-6">
									      <input class="form-control typing" 
									      type="text" 
									      name="Price" 
									      pattern="[0-9]*"
									      title="PLZ enter valid price"
									      placeholder="Type Item Price" data-tag=".pric" required="required"> 
							    		</div>
								</div> 
								<div class="form-group">
									 <label class=" col-sm-3 control-label">country of made </label>
									    <div class=" col-sm-offset-1 col-sm-6">
									      <input class="form-control " type="text" name="country"  placeholder="country of made" required> 
									    </div>
								</div>
								<div class="form-group">
									<label class=" col-sm-2 control-label">Item Status</label>
									 <div class=" col-sm-offset-2 col-sm-2">
										<select name="status" required>
											<option value="">....</option>
											<option value="New">New</option>
											<option value="like new">Like New</option>
											<option value="old">Old</option>
											<option value="Very old">Very Old</option>
										</select>
									</div>
									<label class=" col-sm-1 control-label">Amount</label>
									<div class="  col-sm-3">
									      <input class="form-control " type="text" 
									      name="amount" 
									      pattern="[0-9]*"
									      title="PLZ enter valid Amount"
									      placeholder="Item Amount" required> 
									    </div>
								</div>
								<div class="form-group">
									 <label class=" col-sm-4 control-label">select related category</label>
									 <div class="col-sm-2">
										<select name="category" required>
											<option value="">....</option>
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
									 <label class=" col-sm-3 control-label">Tags</label>
									    <div class=" col-sm-offset-1 col-sm-6">
									       <input class="form-control tags" type="text" name="tags" >
									    </div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-6">
									    <button class="btn btn-success" type="submit"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add New Item </button>
									</div>
								</div>
						<ul id="myTags"></ul>
					</div>
					<div class="col-sm-4">
						<div class='thumbnail live items'>
								<Span class="pricetag"><span class="pric">0</span>$</Span>
								 <input id="uploads" type="file"  name="image" placeholder="Item Name" autocomplete="off"> 
								
								 <img class='addone img-responsive'  src='layout\images\addphoto.jpg' alt='' />
									
									<div class='caption'>
										<h2 class="name">Name</h2>
										<p class="desc">Description</P>
									</div>
						</div>
				 	</div>
			</form>
		</div>
	
	</div>
</div>




<?php			
ob_end_flush();
			?>