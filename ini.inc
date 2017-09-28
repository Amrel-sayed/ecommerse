<?php 

include "admin/connect.inc";

$func="includes/functions";
$tbl="includes/templates";
$lan="includes/language";
$css="layout/css";
$img="layout/images";
$js="layout/js";

// include the important files 
include $func."/functions.php"; 
include $lan."/EN_language.inc"; 
include $tbl."/header.inc"; 
// check if we need to include navbar in this page or not 


include $tbl."/footer.inc";

?>