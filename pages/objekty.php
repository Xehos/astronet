<script type='module' src='js/model-viewer.min.js'></script>
<?php
include("lists/const.php");
if($user_logged){
	$api_key = $_SESSION['user_details']['api_key']->key;
}else{
	$api_key = "";
}
$menu = array("search","solarsystem","satellites","stars","exoplanets");
$menusel = htmlspecialchars(stripslashes($_GET["menusel"]));
$pagesize = array(1=>5,2=>10,3=>20,4=>50,5=>100);

if(isset($_GET['menusel']) || $_GET['menusel']==''){
	if(in_array($_GET['menusel'],$menu)){
	$sel = htmlspecialchars(stripslashes($_GET['menusel']));
	}else{
	header("Location: ?page=objekty&menusel=search");
}
}else{
	header("Location: ?page=objekty&menusel=search");
}

if(!isset($_GET["size"]) || $_GET['size']==''){

	header("Location: ?page=objekty&menusel=$sel&size=1");
	//echo "Location: ?page=objekty&menusel=$sel&page=1";
}else{
	$size = htmlspecialchars(stripslashes($_GET["size"]));
}

if(!isset($_GET["pageno"]) || $_GET['pageno']==''){

	header("Location: ?page=objekty&pageno=1&menusel=$sel&size=$size");
	//echo "Location: ?page=objekty&menusel=$sel&page=1";
}else{
	$pageno = htmlspecialchars(stripslashes($_GET["pageno"]));
}

if($menusel == "search"){
	if(!$user_logged){
		header("Location: ?page=objekty&pageno=1&menusel=solarsystem&size=$size");
	}
}

$limit = $page_sizes[$size];
$start = $pageno * $limit - $limit;
$end = $start + $limit + 1;

?>
<link rel="stylesheet" href="styles/domu.css">
<div class='row text-center justify-content-center'>
		<div class='col-md-9 col-sm-3 main-box'>
			<div class='container-xl'>
			<h1 class="m-4">Seznam vesmírných těles</h1>
			<div class='row text-center justify-content-center'>

				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a style='pointer-events: auto;' title='Pro vyhledávání se prosím přihlaste' href='?page=objekty&menusel=search' class='menusel btn <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="search"){echo "menusel-active ";}} ?> <?php if(!$user_logged){echo "disabled ";} ?>'>Vyhledávač</a></div>
				

				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=solarsystem' class='menusel btn <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="solarsystem"){echo "menusel-active ";}}?>'>Planety sl. soustavy</a></div>
				
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel'><a href='?page=objekty&menusel=satellites' class='menusel btn <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="satellites"){echo "menusel-active ";}} ?>'>Satelity</a></div>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel btn'><a href='?page=objekty&menusel=stars' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="stars"){echo "menusel-active ";}} ?>'>Hvězdy</a></div>
				<div class='col-xs-3 mb-3 mr-3 ml-3 menusel btn'><a href='?page=objekty&menusel=exoplanets' class='menusel <?php if(isset($_GET['menusel'])){if(htmlspecialchars(stripslashes($_GET['menusel']))=="exoplanets"){echo "menusel-active ";}} ?>'>Exoplanety</a></div>


			</div>

			<div class="row text-center justify-content-center mb-3">
				<div class='col-xs-3'>
					
			<?php
			if($menusel!="search"){
			$sel = htmlspecialchars(stripslashes($_GET["menusel"]));
			
			echo "
			<p>Počet záznamů na stránce:</p>
			<form method='GET' action='' id='listchange'>
				<input type='hidden' name='page' value='objekty'>
				<input type='hidden' name='menusel' value='$sel'>
				<select name='size' id='sizeSelect' onchange='changeList();' class='form-control'>
					<option value='1'>5</option>
					<option value='2'>10</option>
					<option value='3'>20</option>
					<option value='4'>50</option>
					<option value='5'>100</option>
				</select>
				";
			}?>
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

		if($menusel!="search"){
		$db_table = $list_tables[$menusel];
    	
    	
    	
    	$pagecount = Db::querySingle("SELECT COUNT(*) FROM $db_table") / $page_sizes[$size];
    	$pagesel = $_GET["page"];

    	for ($x=0;$x<$pagecount;$x++){

    		$page =$x+1;
    		if($page != $pageno){
    		echo "<u><a style='color:white' href='?page=$pagesel&pageno=$page&menusel=$menusel&size=$size#object_table'> $page </a></u>";
    	}else{
			echo "<u><a style='color:	#4682B4' href='?page=$pagesel&pageno=$page&menusel=$menusel&size=$size#object_table'> $page </a></u>";
    		}
    		if($x+1 <$pagecount){
    		echo " ,&nbsp";}
    	}
    	}
    	//echo $pagecount;
	?>
</div>
