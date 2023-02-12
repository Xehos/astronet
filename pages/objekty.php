
<?php


$menu = array("solarsystem","satellites","stars","exoplanets");

$pagesize = array(1=>5,2=>10,3=>20,4=>50,5=>100);

if(isset($_GET['menusel'])){
	if(in_array($_GET['menusel'],$menu)){
	$sel = htmlspecialchars(stripslashes($_GET['menusel']));
	}else{
	header("Location: ?page=objekty&menusel=solarsystem");
}
}else{
	header("Location: ?page=objekty&menusel=solarsystem");
}

if(!isset($_GET["size"])){

	header("Location: ?page=objekty&menusel=$sel&size=1");
	//echo "Location: ?page=objekty&menusel=$sel&page=1";
}else{
	$size = htmlspecialchars(stripslashes($_GET["size"]));
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

			<div class="row text-center justify-content-center mb-3">
				<div class='col-xs-3'>
					<p>Počet záznamů na stránce:</p>
			<form method="GET" action="" id="listchange">
				<input type="hidden" name="page" value="<?php echo "objekty"?>">
				<input type="hidden" name="menusel" value="<?php echo $sel?>">
				<select name="size" id="sizeSelect" onchange="changeList();" class="form-control">
					<option value="1">5</option>
					<option value="2">10</option>
					<option value="3">20</option>
					<option value="4">50</option>
					<option value="5">100</option>
				</select>
				
			</form>
			<script type="text/javascript">
				function changeList(){
					document.getElementById("listchange").submit();
				}
				function setList(){
					document.getElementById("sizeSelect").selectedIndex = <?php echo $size-1;?>;
				}
				setList();
			</script>
		</div>
			</div>

<?php 
	include("lists/$sel.php");
?>
			

</div>
<div class="row text-center justify-content-center mt-3">
	<?php 
	$db_table = "astronet_ssplanets";
    	$pagecount = Db::querySingle("SELECT COUNT(*) FROM $db_table");

    	for ($x=0;$x<$pagecount;$x++){
    		echo $x+1;
    		echo ",";
    	}

    	//echo $pagecount;
	?>
</div>