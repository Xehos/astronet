
<?php 
include("classes/SSPlanet.php");
include("classes/Satellite.php");
include("classes/SatelliteArt.php");
include("classes/User.php");

// Osetreni
include("scripts/privcheck.php");

include("scripts/APIscripts.php");
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

$objects = array("solarsystem" => "Planeta sluneční soustavy", "satellites" => "Satelit", "stars" => "Hvězda", "exoplanets" => "Exoplaneta", "users" => "Uživatel");

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
            Db::querySingle("DELETE FROM astronet_ssplanets WHERE id = $id");
            header("Location: ?page=objekty&menusel=solarsystem&stat=deleted");
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
    if($action == "edit"){
        $userdb = Db::queryAll("SELECT * FROM astronet_users WHERE id = $id")[0];
        $user = new User($userdb["username"],$userdb["mail"],$userdb["password"], $userdb["name"],
            $userdb["surname"], $userdb["sex"], $userdb["city_id"], $userdb["born_date"],
            $userdb["role"], $userdb["password_reset"]);
        
        if(isset($_POST['name'])){
            if($_POST['name'] != "" && $_POST['surname'] != ""){
            $user = new User(htmlspecialchars(stripslashes($_POST["username"])), "", "", htmlspecialchars(stripslashes($_POST["name"])), htmlspecialchars(stripslashes($_POST["surname"])),
                htmlspecialchars(stripslashes($_POST["sex"])),$userdb["city_id"],$_POST["born_date"],htmlspecialchars(stripslashes($_POST["role"])),$userdb["password_reset"]);
            $user->setID($userdb["id"]);
            $sql = $user->sqlEdit();
            Db::queryAll($sql);
            if($user->id == $_SESSION['user_id']){
                $_SESSION['user_details']['username'] = $user->username;
                $_SESSION['user_details']['name'] = $user->name;
                $_SESSION['user_details']['surname'] = $user->surname;
                $_SESSION['user_details']['sex'] = $user->sex;
                $_SESSION['user_details']['born_date'] = $user->born_date;
                $_SESSION['user_details']['role'] = $user->role;
                
            }
            
            header("Location: ?page=administration&menusel=users&stat=edited");
        }else{
            header("Location: ?page=edit&table=users&id=$id&action=edit&stat=incompleterequest");
        }
        }
        
        echo "<div class='col-xs-12'>";
        echo "<h1 class='text-center mt-4'>Úprava objektu</h1>";
        echo "<h3 class='text-center'>Objekt: ".$objects[$table]. "</h3>";


                
        echo " <form action='' method='post'>
            
            <div class='row justify-content-center mt-3 mb-3'>
            <div class='col-xs-12'>
                <div class='label'>
                    <label>Uživatelské jméno<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' value='$user->username' type='text' name='username' id='username' required>
            </div>
            </div>
            </div>

            <div class='row justify-content-center text-center'>

          
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Jméno<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' value='$user->name' type='text' name='name' id='name' required>
            </div>


            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Příjmení<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' value='$user->surname' type='text' name='surname' id='surname' required>
            </div>
            

            </div>

            <div class='row justify-content-center text-center'>

            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Pohlaví<sup class='supreq'>*</sup></span>
                </div>
                <select name='sex' style='width:17em' id='sex-select' class='form-control form-item' required>

                <option disabled selected>Prosím vyberte pohlaví</option>
                <option value='0'>Muž</option>
                <option value='1'>Žena</option>
                <option value='2'>Nechci uvádět</option>
        </select>
        <script> document.getElementById('sex-select').selectedIndex=$user->sex+1 </script>
            </div>
            

            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Datum narození<sup class='supreq'>*</sup></span>
                </div>
                <input style='width:17em' class='form-control' value='$user->born_date' type='date' name='born_date' id='born_date' required>
            </div>
            </div>
           

            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Role<sup class='supreq'>*</sup></span>
                </div>
                <select name='role' style='width:17em' id='role-select' tabindex='7' class='form-control form-item mt-2' required>
                <option value='0'>Uživatel</option>
                <option value='1'>Admin</option>
                <!--<option value='2'></option>-->
        </select>
        <script> document.getElementById('role-select').selectedIndex=$user->role </script>
            </div>
            </div>

            </div>
            
                <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-1'>
                <input type=submit value='Upravit' class='btn btn-secondary'> 
            </div>
            </div>
            </div>
            <input type=hidden name='action' value='$action'>
            </form>
            ";


        echo "</div>";
    

}else if ($action == "delete") {
         if(isset($_GET['stat'])){
            if($_GET['stat']=="confirm"){
                Db::querySingle("DELETE FROM astronet_users WHERE id = $id");
                header("Location: ?page=administration&menusel=users&stat=deleted");
            }
        }
        $userdb = Db::queryAll("SELECT * FROM astronet_users WHERE id = $id")[0];
        $user = new User($userdb["username"],$userdb["mail"],$userdb["password"], $userdb["name"],
            $userdb["surname"], $userdb["sex"], $userdb["city_id"], $userdb["born_date"],
            $userdb["role"], $userdb["password_reset"]);
        $user->setID($userdb["id"]);
        echo "<div class='col-xs-12 text-center'>";
        echo "<h1 class='text-center mt-4'>Smazání uživatele</h1>";
        
        echo "<h2>Opravdu si přejete smazat uživatele $user->username?</h2>";
        echo "<h4 class='text-danger'><u>Tato akce nelze vrátit!</u></h4>";
        
        
        echo "<a class='btn btn-secondary mr-2' href='?page=administration&menusel=users#row_user_$user->id'>Zrušit</a>";
        echo "<a class='btn btn-danger ml-2' href='?page=edit&table=users&id=$user->id&action=delete&stat=confirm'>Potvrdit</a>";

        echo "</div>";

    }
    else if ($action == "resetpass") {

        $userdb = Db::queryAll("SELECT * FROM astronet_users WHERE id = $id")[0];
        $user = new User($userdb["username"],$userdb["mail"],$userdb["password"], $userdb["name"],
            $userdb["surname"], $userdb["sex"], $userdb["city_id"], $userdb["born_date"],
            $userdb["role"], $userdb["password_reset"]);
        $user->setID($userdb["id"]);
        $user->password_reset = 1;
        Db::queryAll($user->sqlEdit());
        if ($_SESSION['user_id'] == $user->id){
            session_destroy();
            header("Location: ?page=login&stat=resetpass");
        }else{
            header("Location: ?page=administration&menusel=users");
        }


    }

}else if($table == "satellites"){
    if($action == "create"){
        if(isset($_POST['name']) && $_POST["action"]=="create"){
            //var_dump($_POST);
            if($_POST['type']=="0"){
            $name = htmlspecialchars(stripslashes($_POST['name']));
            $planet_id = htmlspecialchars(stripslashes($_POST['planet_id']));
            $distance_from_planet = htmlspecialchars(stripslashes($_POST['distance_from_planet']));
            $diameter = htmlspecialchars(stripslashes($_POST['diameter']));
            $mass = htmlspecialchars(stripslashes($_POST['mass']));
            $orbital_period = htmlspecialchars(stripslashes($_POST['orbital_period']));
            $inclination = htmlspecialchars(stripslashes($_POST['inclination']));
            $eccentricity = htmlspecialchars(stripslashes($_POST['eccentricity']));
            $description = htmlspecialchars(stripslashes($_POST['description']));

            $satellite = new Satellite($name, $_POST["type"], $planet_id, $distance_from_planet, $diameter, $mass, $orbital_period, $inclination, $eccentricity, $description);
            Db::queryAll($satellite->sqlCreate());
            header("Location: ?page=objekty&menusel=satellites&stat=created");
        }else{
            $name = htmlspecialchars(stripslashes($_POST['name']));
            $planet_id = htmlspecialchars(stripslashes($_POST['planet_id']));
            $distance_from_planet = htmlspecialchars(stripslashes($_POST['distance_from_planet']));
            $orbital_period = htmlspecialchars(stripslashes($_POST['orbital_period']));
            $description = htmlspecialchars(stripslashes($_POST['description']));

            $satellite = new SatelliteArt($name, $_POST["type"], $planet_id, $distance_from_planet, $orbital_period, $description);
            Db::queryAll($satellite->sqlCreate());
            header("Location: ?page=objekty&menusel=satellites&stat=created");
        }
        }
        /*
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
            header("Location: ?page=objekty&menusel=satellites&stat=created");
        }
        */
        echo "<div class='col-xs-12'>";
        echo "<h1 class='text-center mt-4'>Vytvoření nového objektu</h1>";
        echo "<h3 class='text-center'>Objekt: ".$objects[$table]. "</h3>";
        echo "<div class='text-center justify-content-center'>";
        echo "<form action='' method='post'>";
        echo "<input type='radio' id='nat-checkbox' onclick='radioCheck();'  name='type' value='0' checked>";
        echo "<label class='mr-2' for='nat-checkbox'>&nbsp;Přírodní</label>";
        echo "<input class='ml-2' type='radio' id='art-checkbox' onclick='radioCheck();' name='type' value='1'>";
        echo "<label for='art-checkbox'>&nbsp;Umělý</label>";
        echo "</div>";
        echo "<script>
        function radioCheck(){
            if(document.getElementById('nat-checkbox').checked){
                document.getElementById('inclination_section').style.display = 'block';
                document.getElementById('eccentricity_section').style.display = 'block';
                document.getElementById('mass_section').style.display = 'block';
                document.getElementById('diameter_section').style.display = 'block';
                document.getElementById('diameter').required = true;
                document.getElementById('inclination').required = true;
                document.getElementById('mass').required = true;
                document.getElementById('eccentricity').required = true;
                console.log('natural');
            }else{
                document.getElementById('inclination_section').style.display = 'none';
                document.getElementById('eccentricity_section').style.display = 'none';
                document.getElementById('mass_section').style.display = 'none';
                document.getElementById('diameter_section').style.display = 'none';
                document.getElementById('diameter').required = false;
                document.getElementById('inclination').required = false;
                document.getElementById('mass').required = false;
                document.getElementById('eccentricity').required = false;
                console.log('artificial');
            }  
           
        }
        

        </script>";
        echo "
            
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

          
            
            ";
            echo "
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Planeta<sup class='supreq'>*</sup></span>
                </div>
                <select style='width:17em' class='form-control' name='planet_id' id='planet_id' required>
            ";
            $planets = Db::queryAll("SELECT * FROM astronet_ssplanets ORDER BY solar_order");
            foreach($planets as $planet){


            echo "
                <option value='".$planet["id"]."'>".$planet["name"]."</option>
            ";
            }
            echo "</select>
            </div>";


            echo "
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Vzdálenost od planety
                    (10<sup>3</sup> km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='distance_from_planet' id='distance_from_planet' required>
            </div>
            </div>

            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3' id='diameter_section'>
                <div class='label'>
                    <label>Průměr (km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='diameter' id='diameter' required>
            </div>
            

            <div class='col-xs-12 m-3' id='mass_section'>
                <div class='label'>
                    <label>Hmotnost (*10<sup>24</sup>kg)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='mass' id='mass' required>
            </div>
            </div>
            <div class='row justify-content-center text-center'>
            
            <div class='col-xs-12 m-3' id='eccentricity_section'>
                <div class='label'>
                    <label>Orbitální výstřednost<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='eccentricity' id='eccentricity' required>
            </div>

            <div class='col-xs-12 m-3' id='inclination_section'>
                <div class='label'>
                    <label>Orbitální sklon (stupně)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='inclination' id='inclination' required>
            </div>
            </div>

            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Perioda orbity (d)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' name='orbital_period' id='orbital_period' required>
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
            <div class='col-xs-12 m-1'>
                <input type=submit value='Vytvořit' class='btn btn-secondary'> 
            </div>
            </div>
            </div>
            <input type=hidden name='action' value='$action'>
            </form>
            ";
        echo "</div>";
    }else if($action == "edit"){
        $id = htmlspecialchars(stripslashes($_GET["id"]));

        $satelit_db = Db::queryAll("SELECT * FROM astronet_satellites WHERE id = $id")[0];

        if($satelit_db["artificial"]==0){
            $satellite = new Satellite($satelit_db["name"], $satelit_db["artificial"], $satelit_db["planet_id"], $satelit_db["distance_from_planet"], $satelit_db["diameter"], $satelit_db["mass"], $satelit_db["orbital_period"],$satelit_db["inclination"], $satelit_db["eccentricity"], $satelit_db["description"]);
        }else{
            
            $satellite = new SatelliteArt($satelit_db["name"], $satelit_db["artificial"], $satelit_db["planet_id"], $satelit_db["distance_from_planet"], $satelit_db["orbital_period"], $satelit_db["description"]);
          
        }

        if(isset($_POST["name"])){
            if($satelit_db["artificial"]==0){
            $satellite_new = new Satellite($_POST["name"], $satelit_db["artificial"], $_POST["planet_id"], $_POST["distance_from_planet"], $_POST["diameter"], $_POST["mass"], $_POST["orbital_period"],$_POST["inclination"], $_POST["eccentricity"], $_POST["description"]);

        }else{
            
            $satellite_new = new SatelliteArt($_POST["name"], $satelit_db["artificial"], $_POST["planet_id"], $_POST["distance_from_planet"], $_POST["orbital_period"], $_POST["description"]);
          
        }
        if(isset($_POST["model"]) && $_POST["model"]!=""){
            $satellite_new->setModel($_POST['model']);
        }
        $satellite_new->setID($satelit_db["id"]);
        Db::queryAll($satellite_new->sqledit());
        header("Location: ?page=objekty&menusel=satellites&stat=edited");

        }

        echo "<div class='col-xs-12'><h1 class='text-center mt-4'>Úprava objektu</h1><h3 class='text-center'>Objekt: $satellite->name</h3>";
        echo "<form action='' method='post'>";


        echo "
            
            <div class='row justify-content-center mt-3 mb-3'>
            <div class='col-xs-12'>
                <div class='label'>
                    <label>Název<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$satellite->name' name='name' id='name' required>
            </div>
            </div>
            </div>

            <div class='row justify-content-center text-center'>

          
            
            ";
            echo "
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Planeta<sup class='supreq'>*</sup></span>
                </div>
                <select style='width:17em' class='form-control' name='planet_id' id='planet_id' required>
            ";
            $planets = Db::queryAll("SELECT * FROM astronet_ssplanets ORDER BY solar_order");
            foreach($planets as $planet){


            echo "
                <option value='".$planet["id"]."'>".$planet["name"]."</option>
            ";
            }
            echo "</select>
            <script>document.getElementById('planet_id').selectedIndex = $satellite->planet_id +1</script>
            </div>";


            echo "
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Vzdálenost od planety
                    (10<sup>3</sup> km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$satellite->distance_from_planet' name='distance_from_planet' id='distance_from_planet' required>
            </div>
            </div>
            ";
            if($satelit_db["artificial"]==0){
            echo "
            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3' id='diameter_section'>
                <div class='label'>
                    <label>Průměr (km)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' value='$satellite->diameter' type='text' name='diameter' id='diameter' required>
            </div>
            

            <div class='col-xs-12 m-3' id='mass_section'>
                <div class='label'>
                    <label>Hmotnost (*10<sup>24</sup>kg)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' value='$satellite->mass' type='text' name='mass' id='mass' required>
            </div>
            </div>
            <div class='row justify-content-center text-center'>
            
            <div class='col-xs-12 m-3' id='eccentricity_section'>
                <div class='label'>
                    <label>Orbitální výstřednost<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$satellite->eccentricity' name='eccentricity' id='eccentricity' required>
            </div>

            <div class='col-xs-12 m-3' id='inclination_section'>
                <div class='label'>
                    <label>Orbitální sklon (stupně)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$satellite->inclination' name='inclination' id='inclination' required>
            </div>
            </div>
            ";
        }
            echo"
            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Perioda orbity (d)<sup class='supreq'>*</sup></span>
                </div>
                <input size=30 class='form-control' type='text' value='$satellite->orbital_period' name='orbital_period' id='orbital_period' required>
            </div>

            </div>

            </div>

        
            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Popis<sup class='supreq'>*</sup></span>
                </div>
                <textarea style='width:30em;height:5em' class='form-control' name='description' id='description' required>$satellite->description</textarea>
            </div>
            </div>

            <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-3'>
                <div class='label'>
                    <label>Jméno 3D modelu (nepovinné)</span>
                </div>";
                if(isset($satellite->model)){
                echo "<input size=30 class='form-control' value='$satellite->model' placeholder='*.glb' type='text' name='model' id='model'>";
            }else{
                echo "<input size=30 class='form-control' placeholder='*.glb' type='text' name='model' id='model'>";
            }echo "
            </div>
            </div>

            
            
                <div class='row justify-content-center text-center'>
            <div class='col-xs-12 m-1'>
                <input type=submit value='Upravit' class='btn btn-secondary'> 
            </div>
            </div>
            </div>
            <input type=hidden name='action' value='$action'>
            </form>
            ";
    }else if($action=="delete"){
        if(isset($_GET['stat'])){
        if($_GET['stat']=="confirm"){
            Db::querySingle("DELETE FROM astronet_satellites WHERE id = $id");
            header("Location: ?page=objekty&menusel=satellites&stat=deleted");
        }}
        $satelit_db = Db::queryAll("SELECT * FROM astronet_satellites WHERE id = $id")[0];
        if($satelit_db["artificial"]==0){
            $satellite = new Satellite($satelit_db["name"], $satelit_db["artificial"], $satelit_db["planet_id"], $satelit_db["distance_from_planet"], $satelit_db["diameter"], $satelit_db["mass"], $satelit_db["orbital_period"],$satelit_db["inclination"], $satelit_db["eccentricity"], $satelit_db["description"]);
        }else{
            
            $satellite = new SatelliteArt($satelit_db["name"], $satelit_db["artificial"], $satelit_db["planet_id"], $satelit_db["distance_from_planet"], $satelit_db["orbital_period"], $satelit_db["description"]);
          
        }
        $satellite->setID($satelit_db["id"]);
        echo "<div class='col-xs-12 text-center'>";
        echo "<h1 class='text-center mt-4'>Smazání objektu</h1>";
        
        echo "<h2>Opravdu si přejete smazat objekt $satellite->name?</h2>";
        echo "<h4 class='text-danger'><u>Tato akce nelze vrátit!</u></h4>";
        
        
        echo "<a class='btn btn-secondary mr-2' href='?page=objekty&menusel=satellites#row_satellite_$satellite->id'>Zrušit</a>";
        echo "<a class='btn btn-danger ml-2' href='?page=edit&table=satellites&id=$satellite->id&action=delete&stat=confirm'>Potvrdit</a>";

        echo "</div>";



    }

}





















