
<?php 
include("classes/SSPlanet.php");
// Osetreni
include("scripts/privcheck.php");
if(isset($_GET["action"])){
	$action = htmlspecialchars(stripslashes($_GET["action"]));
}
if(isset($_GET["table"])){
	$table = htmlspecialchars(stripslashes($_GET["table"]));
}
if(!isset($action) || !isset($table)){
	header("Location: ?page=domu");
}

if(isset($_GET["id"])){
	$id = htmlspecialchars(stripslashes($_GET["id"]));
}
if($action != "create" && !isset($id)){
	header("Location: ?page=domu");
}

$objects = array("solarsystem" => "Planeta sluneční soustavy", "satellites" => "Satelit", "stars" => "Hvězda", "exoplanets" => "Exoplaneta");


if($table == "solarsystem"){
	if($action == "create"){
    	if(isset($_POST['name']) && $_POST["action"]=="create"){
    		if(!isset($_POST["model"])){
    		$planet = new SSPlanet($_POST["name"], $_POST['distance_from_sun'], $_POST['density'], $_POST['diameter'],
    			$_POST["mass"], $_POST["orbital_period"], $_POST["inclination"], $_POST["eccentricity"], $_POST["description"],
    			"", $_POST["solar_order"]);
    		}else{
    			$planet = new SSPlanet($_POST["name"], $_POST['distance_from_sun'], $_POST['density'], $_POST['diameter'],
    			$_POST["mass"], $_POST["orbital_period"], $_POST["inclination"], $_POST["eccentricity"], $_POST["description"],
    			$_POST["model"], $_POST["solar_order"]);
    		}
    		$sql = $planet->sqlCreate();
    		Db::queryAll($sql);
    		header("Location: ?page=objekty&menusel=solarsystem&stat=created");
    	}

    	echo "<div class='col-xs-12'>";
    	echo "<h1 class='text-center mt-4'>Vytvoření nového objektu</h1>";
    	echo "<h3 class='text-center'>Objekt: ".$objects[$table]. "</h3>";


        		
    	echo " <form action='' method='post'>
    		
    		<div class='row justify-content-center mt-3 mb-3'>
    		<div class='col-xs-12'>
                <div class='label'>
                    <label>Název<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='name' id='name' required>
          	</div>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>

          
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Průměrná vzdálenost od slunce
    				(10<sup>6</sup> km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='distance_from_sun' id='distance_from_sun' required>
          	</div>
          	

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Hustota (kg/m<sup>3</sup>)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='density' id='density' required>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Průměr (km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='diameter' id='diameter' required>
          	</div>
          	

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Hmotnost (*10<sup>24</sup>kg)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='mass' id='mass' required>
          	</div>
          	</div>
          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Perioda orbity (d)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='orbital_period' id='orbital_period' required>
          	</div>

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Orbitální sklon (stupně)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='inclination' id='inclination' required>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Orbitální výstřednost<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='eccentricity' id='eccentricity' required>
          	</div>
          	</div>

          	</div>

        
          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Popis<sup class='supreq'>*</sup></span>
                </div>
                <textarea style='width:30em;height:5em' class='form-control' name='description' id='description' required></textarea>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Jméno 3D modelu (nepovinné)</span>
                </div>
                <input size=30 class='form-control' placeholder='*.glb' type='text' name='model' id='model'>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Pořadí ve sluneční soustavě<sup class='supreq'>*</sup></span>
                </div>
                	<input class='form-control' type='number' value='1' min='1' name='solar_order'  id='order' required>
          	</div>
          	</div>
          	
          	 	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-1'>
                <input type=submit value='Vytvořit' class='btn btn-secondary'> 
          	</div>
          	</div>
          	</div>
          	<input type=hidden name='action' value='$action'>
        	</form>
    		";


        echo "</div>";
    }else if($action=="edit"){
    	$planetdb = Db::queryAll("SELECT * FROM astronet_ssplanets WHERE id = $id")[0];
    	$planet = new SSPlanet($planetdb["name"], $planetdb['distance_from_sun'], $planetdb['density'], $planetdb['diameter'],
    			$planetdb["mass"], $planetdb["orbital_period"], $planetdb["inclination"], $planetdb["eccentricity"], $planetdb["description"],
    			$planetdb["3d_model"], $planetdb["solar_order"]);

    	if(isset($_POST["name"]) && $_POST["action"]=="edit"){
    		$planet->name = $_POST['name'];
    		$planet->distance_from_sun = $_POST['distance_from_sun'];
    		$planet->density = $_POST['density'];
    		$planet->diameter = $_POST['diameter'];
    		$planet->mass = $_POST['mass'];
    		$planet->orbital_period = $_POST['orbital_period'];
    		$planet->inclination = $_POST['inclination'];
    		$planet->eccentricity = $_POST['eccentricity'];
    		$planet->description = $_POST['description'];
    		$planet->model = $_POST['model'];
    		$planet->solar_order = $_POST['solar_order'];
    		$planet->id = $id;
    		Db::queryAll($planet->sqlUpdate($id));
    		header("Location: ?page=objekty&menusel=solarsystem&stat=edited");
    	}

    	echo "<div class='col-xs-12'>";
    	echo "<h1 class='text-center mt-4'>Úprava objektu</h1>";
    	echo "<h3 class='text-center'>Objekt: ".$planet->name. "</h3>";
    	echo " <form action='' method='post'>
    		
    		<div class='row justify-content-center mt-3 mb-3'>
    		<div class='col-xs-12'>
                <div class='label'>
                    <label>Název<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->name' name='name' id='name' required>
          	</div>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>

          
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Průměrná vzdálenost od slunce
    				(10<sup>6</sup> km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->distance_from_sun' name='distance_from_sun' id='distance_from_sun' required>
          	</div>
          	

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Hustota (kg/m<sup>3</sup>)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->density' name='density' id='density' required>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Průměr (km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->diameter' name='diameter' id='diameter' required>
          	</div>
          	

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Hmotnost (*10<sup>24</sup>kg)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->mass' name='mass' id='mass' required>
          	</div>
          	</div>
          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Perioda orbity (d)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->orbital_period' name='orbital_period' id='orbital_period' required>
          	</div>

          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Orbitální sklon (stupně)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->inclination' name='inclination' id='inclination' required>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Orbitální výstřednost<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$planet->eccentricity' name='eccentricity' id='eccentricity' required>
          	</div>
          	</div>

          	</div>

        
          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Popis<sup class='supreq'>*</sup></span>
                </div>
                <textarea style='width:30em;height:5em' class='form-control' name='description' id='description' required>$planet->description</textarea>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Jméno 3D modelu (nepovinné)</span>
                </div>
                <input size=30 class='form-control' placeholder='*.glb' type='text' value='$planet->model'  name='model' id='model'>
          	</div>
          	</div>

          	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Pořadí ve sluneční soustavě<sup class='supreq'>*</sup></span>
                </div>
                	<input class='form-control' type='number' min='1' value='$planet->solar_order' name='solar_order'  id='order' required>
          	</div>
          	</div>
          	
          	 	<div class='row justify-content-center text-center'>
          	<div class='col-xs-12 m-1'>
                <input type=submit value='Upravit' class='btn btn-secondary'> 
          	</div>
          	</div>
          	</div>
          	<input type=hidden name='action' value='$action'>
          	<input type=hidden name='id' value='$id'>
        	</form>
    		";
        echo "</div>";
    }else if($action=="delete"){
        if(isset($_GET['stat'])){
        if($_GET['stat']=="confirm"){

        }}
        $planetdb = Db::queryAll("SELECT * FROM astronet_ssplanets WHERE id = $id")[0];
        $planet = new SSPlanet($planetdb["name"], $planetdb['distance_from_sun'], $planetdb['density'], $planetdb['diameter'],
                $planetdb["mass"], $planetdb["orbital_period"], $planetdb["inclination"], $planetdb["eccentricity"], $planetdb["description"],
                $planetdb["3d_model"], $planetdb["solar_order"]);
        $planet->setID($planetdb["id"]);
        echo "<div class='col-xs-12 text-center'>";
        echo "<h1 class='text-center mt-4'>Smazání objektu</h1>";
        
        echo "<h2>Opravdu si přejete smazat objekt $planet->name?</h2>";
        echo "<h4 class='text-danger'><u>Tato akce nelze vrátit!</u></h4>";
        
        
        echo "<a class='btn btn-secondary mr-2' href='?page=objekty&menusel=solarsystem#row_planet_$planet->id'>Zrušit</a>";
        echo "<a class='btn btn-danger ml-2' href='?page=edit&table=solarsystem&id=$planet->id&action=delete&stat=confirm'>Potvrdit</a>";

        echo "</div>";



    }

}else if($table == "users"){

}
























