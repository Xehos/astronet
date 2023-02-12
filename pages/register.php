<?php 

if(isset($_SESSION['username'])){
	header("Location: index.php?page=domu");
}

function verifyMailDuplicates($mail){
	global $conn;
	$sql = "SELECT COUNT(*) FROM astronet_users WHERE mail='$mail' LIMIT 1";
	$dataraw = Db::querySingle($sql);
	if ($dataraw) {
	  return false;
	}else{
		return true;
	}

}

function verifyUsernameDuplicates($username){
global $conn;
	$sql = "SELECT COUNT(*) FROM astronet_users WHERE username='$username' LIMIT 1";
	$dataraw = Db::querySingle($sql);
	if ($dataraw) {
	  return false;
	}else{
		return true;
	}

}

function validateEmail($email){
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		return false;
	}else{
		return true;
	}
}
function checkForm($postdata){
	global $conn;
	$username = htmlspecialchars(stripslashes($postdata["username"]));
	$name = htmlspecialchars(stripslashes($postdata["name"]));
	$surname = htmlspecialchars(stripslashes($postdata["surname"]));
	$password = htmlspecialchars(stripslashes($postdata["password"]));
	$password_check = htmlspecialchars(stripslashes($postdata["password_check"]));
	$mail = htmlspecialchars(stripslashes($postdata["mail"]));
	$country_code = htmlspecialchars(stripslashes($postdata["country"]));
	$born_date = htmlspecialchars(stripslashes($postdata["born_date"]));

	if(!isset($postdata["sex"])){
		return "Nezadali jste pohlaví!";
	}
	$sex = htmlspecialchars(stripslashes($postdata["sex"]));

	if(!isset($postdata["city"])){
		return "Nezadali jste město!";
	}
	$city_id = htmlspecialchars(stripslashes($postdata["city"]));

	if($password!=$password_check){
		return "Zadaná hesla se neshodují!";
	}

	if(!validateEmail($mail)){
		return "Byl zadán nevalidní E-mail!";
	}

	if(!verifyUsernameDuplicates($username)){
		return "Již existuje uživatel se zadaným uživatelským jménem!";
	}

	if(!verifyMailDuplicates($mail)){
		return "Již existuje uživatel se zadaným E-mailem!";
	}

	$password_hash = password_hash($postdata["password"], PASSWORD_BCRYPT);
	


	$sql = "INSERT INTO `astronet_users` (`username`, `mail`, `password`, `name`, `surname`, `sex`, `city_id`, `born_date`) VALUES ('$username', '$mail', '$password_hash', '$name', '$surname', '$sex', '$city_id', '$born_date')";
	
	/*
	if(mysqli_query($conn, $sql)){
		return true;
	}else{
		return mysqli_error($conn);
	}
	*/
	Db::queryAll($sql);
	return true;

}


if(isset($_POST['username'])){
	//var_dump($_POST);
	$check = checkForm($_POST);
	
}

?>
<style>
	#state-select,#city-select{
		display:none;
	}
</style>

<script>
	/*
	function setDefaultTime(){
		let el_checkbox = document.getElementById("dktime");
		let el_time = document.getElementById("timeselect");
		if(el_checkbox.checked == true){
			el_time.value = "00:00:00";

			el_time.disabled = true;
		}else{
			el_time.value = "00:00:00";
			el_time.disabled = false;
		}

	}
	*/
</script>


<script>
	function getStatesSelectList(){
	var country_select = document.getElementById("country-select");
	var city_select = document.getElementById("city-select");
	try{
	var country_code = country_select.options[country_select.selectedIndex].value;
	}catch(e){
		var country_code = country_select.options[77].value; // Czechia as default
	}
	console.log('CountryCode : ' + country_code);

	var xhr = new XMLHttpRequest();
			var url = 'scripts/ajax_loc_selector/statelist.php?country_code=' + country_code;
			console.log(url);
			// open function
			xhr.open('GET', url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			// check response is ready with response states = 4
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					var text = xhr.responseText;
					//console.log('response from states.php : ' + xhr.responseText);
					var state_select = document.getElementById("state-select");
					state_select.innerHTML = text;
					state_select.style.display='inline';
					city_select.style.display='none';
				}
			}
 
			xhr.send();
		}


function getCitySelectList(){
			var state_select = document.getElementById("state-select");
 
			var state_name = state_select.options[state_select.selectedIndex].text;
			console.log('StateName : ' + state_name);
 
			var xhr = new XMLHttpRequest();
			var url = 'scripts/ajax_loc_selector/citieslist.php?state_name=' + state_name;
			// open function
			xhr.open('GET', url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			// check response is ready with response states = 4
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					var text = xhr.responseText;
					//console.log('response from cities.php : ' + xhr.responseText);
					var city_select = document.getElementById("city-select");
					city_select.innerHTML = text;
					city_select.style.display='inline';
					city_select.required=true;
				}
			}
 
			xhr.send();
		}
		
		setTimeout(() => { getStatesSelectList(); }, 50);
</script>

<div class="main-container mt-5 justify-content-center text-center">
	
	<?php 
	if(isset($check)){
	if($check!==true){

		echo "<div class='alert alert-danger' role='alert'> ".$check."</div>";
	}else{
		header("Location: index.php?page=login&state=registeredsucc");
	}
}

	?>

	<h1 class="display-4" style="font-size:2.2em">Registrace:</h1>
	
	<form action="" method="post">
		<div class="row justify-content-center">
		<div class="col-xs-6">
		<input type="text" name="username" tabindex="1" class="form-control form-item mt-2" placeholder="Uživatelské jméno" required>
		<input type="text" name="name" tabindex="3" class="form-control form-item mt-2" placeholder="Jméno" required>
		
		<input type="password" name="password" tabindex="5" class="form-control form-item mt-2" placeholder="Heslo" required>
		</div>
		<div class="col-xs-6">
		<input type="email" name="mail" tabindex="2" class="form-control form-item mt-2 ml-1" placeholder="E-mail" required>
		<input type="text" name="surname" tabindex="4" class="form-control form-item mt-2 ml-1" placeholder="Příjmení" required>
		<input type="password" name="password_check" tabindex="6" class="form-control form-item mt-2 ml-1" placeholder="Heslo pro kontrolu" required></div>

		
	
		</div>
		<div class="row justify-content-center">
		<div class="col-xs-6">
		<select name="sex" id="sex-select" tabindex="7" class="form-control form-item mt-2" required>

				<option disabled selected>Prosím vyberte pohlaví</option>
				<option value="0">Muž</option>
				<option value="1">Žena</option>
				<option value="2">Nechci uvádět</option>
		</select>
		</div>
	</div>
		


		<h1 class="display-4 mt-2" style="font-size:1.5em">Místo narození:</h1>
		<div class="row justify-content-center">
		<div class="col-xs-6">
			<select name="country" tabindex="8" id="country-select" class="form-control" onchange="getStatesSelectList();" required>

				<!--<option disabled selected>Prosím vyberte zemi</option>-->
				<?php
					$sql = "SELECT country_code, name FROM `astronet_countries` ORDER BY name ASC";
					$result = Db::queryAll($sql);
					foreach($result as $row){
				?>

				<option value=<?php echo "\"".$row['country_code']."\""; if($row["name"]=="Czechia"){echo " selected";}?>><?php echo $row['name'] ?></option>
				<?php } ?>

		</select>
		<select name="state" tabindex="9" class="form-control mt-2" id="state-select" onchange="getCitySelectList()" required>
		
		</select>
		<select name="city" tabindex="10" id="city-select" class="form-control mt-2">
		
		</select>


		</div>

		</div>
		<div class="row justify-content-center">
			<div class="col-xs-6">
			<h1 class="display-4 mt-2" style="font-size:1.5em">Datum narození:</h1>
			<input name="born_date" tabindex="11" type="date" value="<?php echo date("Y-m-d"); ?>" id="dateselect" class="form-control">
	
		</div>
		</div>

		<input type="submit" value="Registrovat se" class="btn btn-prim mt-2">

	</form>
	<p class="mt-1">Máte již účet? Prosím <a href="?page=login">přihlašte</a> se</p>


</div>