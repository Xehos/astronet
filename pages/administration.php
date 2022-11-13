<?php 

// Osetreni
include("scripts/privcheck.php");
$menu = array("users");
if(isset($_GET['menusel'])){
	if(in_array($_GET['menusel'],$menu)){
	$sel = htmlspecialchars(stripslashes($_GET['menusel']));
	}else{
	header("Location: ?page=administration&menusel=users");
}
}else{
	header("Location: ?page=administration&menusel=users");
}
?>
<link rel="stylesheet" href="styles/domu.css">
<div class='row text-center justify-content-center'>
		<div class='col-md-9 col-sm-3 main-box'>
			<div class='container-xl'>
			<h1 class="m-4">Administrace</h1>
			<div class='row text-center justify-content-center'>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=administration&menusel=users' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="users"){echo "menusel-active ";}} ?>'>Uživatelé</a></div>
				

			</div>
<?php 

	include("administration/$sel.php");

?>