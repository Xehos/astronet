<?php 
include("classes/User.php");
include("scripts/APIscripts.php");
?>
<div class='row text-center justify-content-center'>
		<div class='col-md-9 col-sm-3 main-box'>
			<div class='container-xl'>
				<h1 class="m-4">Účet <?php echo $_SESSION["user_details"]["username"] ?></h1>
<?php 
/*
if(Db::querySingle("SELECT api_key FROM astronet_api_keys WHERE user_id = " . $_SESSION["user_id"]) == false){
		unset($_SESSION["user_details"]["api_key"]);
}
*/
addAPIkey($_SESSION['user_id']); // API key info update

function guidv4($data = null) { // https://www.uuidgenerator.net/dev-corner/php
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

if(isset($_POST["name"])){

		$name = htmlspecialchars(stripslashes($_POST['name']));
		$surname = htmlspecialchars(stripslashes($_POST['surname']));
		$mail = htmlspecialchars(stripslashes($_POST['mail']));
		if($name != "" && $surname!="" &&$mail!=""){
		$user = new User($_SESSION["user_details"]["username"],$mail,"",$name, $surname,0,0,"",0,0);
		$user->setID($_SESSION["user_id"]);
		Db::queryAll($user->sqlAccountUpdate());
		$_SESSION["user_details"]["name"] = $name;
		$_SESSION["user_details"]["surname"] = $surname;
		$_SESSION["user_details"]["mail"] = $mail;
		header("Location: ?page=account&stat=accupdated");
	}else{
		header("Location: ?page=account&action=change&stat=incompleterequest");
	}
	
}
if(isset($_GET["action"])){
	if($_GET['action']=="change"){
		echo "<form action='' method='POST'>";
		echo "<p class='ml-1'>Jméno: <input type='text' name='name' class='form-control' value='".$_SESSION["user_details"]["name"]."' required></p>";
echo "<p class='ml-1'>Příjmení: <input type='text' name='surname' class='form-control' value='".$_SESSION["user_details"]["surname"]."' required></p>";
echo "<p class='ml-1'>E-mail: <input type='email' name='mail' class='form-control' value='".$_SESSION["user_details"]["mail"]."' required></p>";

echo "<input type='submit' class='btn-secondary btn' value='Potvrdit'>";
echo "</form>";
	}else if($_GET['action']=="generateuid"){

		$key = guidv4();
		$user_id = $_SESSION['user_id'];
		Db::query("INSERT INTO astronet_api_keys (`api_key`, `user_id`) VALUES ('$key','$user_id')");
		$_SESSION["user_details"]["api_key"] = new APIkey($user_id);

		header("Location: ?page=account&stat=apikeygenerated");

}else{
		header("Location: ?page=account");
	}
}else{
echo "<p>Jméno: ".$_SESSION["user_details"]["name"]. "</p>";
echo "<p>Příjmení: ".$_SESSION["user_details"]["surname"]. "</p>";
echo "<p>E-mail: ".$_SESSION["user_details"]["mail"]. "</p>";

echo "<h4>API klíč:" . "</h4>";
	if($_SESSION["user_details"]["api_key"]!=""){
		echo "<p>". $_SESSION["user_details"]["api_key"]."</p>";
		if($_SESSION["user_details"]["api_key"]->revoked){
			echo "<p class='mb-2 text-danger'>API klíč byl zablokován administrátorem!</p>";
		}
	}else{
		echo "<a class='btn btn-primary mb-2' href='?page=account&action=generateuid'>Generovat</a><br>";
		
	}
echo "<a href='?page=account&action=change' class='btn-secondary btn'> Změnit údaje</a>";
}



?>
</div>
</div>
</div>