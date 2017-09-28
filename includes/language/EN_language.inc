<?php 

function lang ($word) {

	static $lang = array(
			//da
		'home_admin' => "Admin Area",
		'CATEGORIES' => "Categories",
		'ITEMS' 	 => "Items",
		'MEMBERS' 	 => "Members",
		'STATISTICS' => "Statistics",
		'LOGS' 		 => "Logs",
		'ViewProfile' => "View Profile",
		'Setting' => "Setting",
		'Logout' => "Logout",
		'COMMENTS' => "Comments",
		'sign' => "Sign IN",
		'reg' => "Register",
		'newitem' => " Add New Item",

		);

	return $lang[$word];

}

?>