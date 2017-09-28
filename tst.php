
<?php  
ob_start();
session_start();

$pagetitle="tst page";
include "ini.inc" ;

?>
<div class="container ">


		<div class="inputforms">
		<div class="input-group input-group-lg">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>
			  <input class="form-control"
			  		 id="name" 
			  		 type="text"
			  		 pattern=".{4,}"
			  		 title="Username name must be between 4 & 8 Char"  
			  		 name="username"
			  		 placeholder="Type your username here" 
			  		 autocomplete="off" required>
		</div>
		</div>
	<div id= "updated">
		
	</div>
	<button id="update"> update</button>


</div>

