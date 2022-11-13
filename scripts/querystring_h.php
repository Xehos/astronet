<?php
/*

Used to redirect pages via appropriate querystring using "include"
IMPORTANT NO OTHER PAGES CAN WORK WITHOUT ADDITION TO THIS ARRAY!

*/
$pages = array("domu","funkce","o_projektu", "objekty", "login","register", "account", "edit", "administration");


if(isset($_GET['page'])){
$page = htmlspecialchars(stripslashes($_GET["page"]));
if(in_array($page,$pages)){
	include "pages/$page".".php";
	echo "
	<script>
		menu_selected('$page');
	</script>";

}else{
	header("Location: index.php?page=domu");
}

}else{
	header("Location: index.php?page=domu");
}

?>