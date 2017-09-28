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
		'EditProfile' => "Edit Profile",
		'Setting' => "Setting",
		'Logout' => "Logout",
		'COMMENTS' => "Comments",


		);

	return $lang[$word];

}

?>