
<?php


$menu = array("solarsystem","satellites","stars","exoplanets");

if(isset($_GET['menusel'])){
	if(in_array($_GET['menusel'],$menu)){
	$sel = htmlspecialchars(stripslashes($_GET['menusel']));
	}else{
	header("Location: ?page=objekty&menusel=solarsystem");
}
}else{
	header("Location: ?page=objekty&menusel=solarsystem");
}


?>
<link rel="stylesheet" href="styles/domu.css">
<div class='row text-center justify-content-center'>
		<div class='col-md-9 col-sm-3 main-box'>
			<div class='container-xl'>
			<h1 class="m-4">Seznam vesmírných těles</h1>
			<div class='row text-center justify-content-center'>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=solarsystem' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="solarsystem"){echo "menusel-active ";}} ?>'>Planety sl. soustavy</a></div>
				


				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=satellites' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="satellites"){echo "menusel-active ";}} ?>'>Satelity</a></div>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=stars' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="stars"){echo "menusel-active ";}} ?>'>Hvězdy</a></div>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=exoplanets' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="exoplanets"){echo "menusel-active ";}} ?>'>Exoplanety</a></div>
			</div>

<?php 
	include("lists/$sel.php");
?>
			

</div>