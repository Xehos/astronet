<?php 
include("classes/User.php");
?>
<div class='row text-center justify-content-center'>
		<div class='col-md-9 col-sm-3 main-box'>
			<div class='container-xl'>
				<h1 class="m-4">Účet <?php echo $_SESSION["user_details"]["username"] ?></h1>
<?php 

if(isset($_POST["name"])){
	$name = htmlspecialchars(stripslashes($_POST['name']));
	$surname = htmlspecialchars(stripslashes($_POST['surname']));
	$mail = htmlspecialchars(stripslashes($_POST['mail']));
	$user = new User($_SESSION["user_details"]["username"],$mail,"",$name, $surname,0,0,"",0,0);
	$user->setID($_SESSION["user_id"]);
	Db::queryAll($user->sqlAccountUpdate());
	$_SESSION["user_details"]["name"] = $name;
	$_SESSION["user_details"]["surname"] = $surname;
	$_SESSION["user_details"]["mail"] = $mail;
	header("Location: ?page=account&stat=accupdated");
}
if(isset($_GET["action"])){
	if($_GET['action']=="change"){
		echo "<form action='' method='POST'>";
		echo "<p class='ml-1'>Jméno: <input type='text' name='name' class='form-control' value='".$_SESSION["user_details"]["name"]."' required></p>";
echo "<p class='ml-1'>Příjmení: <input type='text' name='surname' class='form-control' value='".$_SESSION["user_details"]["surname"]."' required></p>";
echo "<p class='ml-1'>E-mail: <input type='email' name='mail' class='form-control' value='".$_SESSION["user_details"]["mail"]."' required></p>";

echo "<input type='submit' class='btn-secondary btn' value='Potvrdit'>";
echo "</form>";
	}else{
		header("Location: ?page=account");
	}
}else{
echo "<p>Jméno: ".$_SESSION["user_details"]["name"]. "</p>";
echo "<p>Příjmení: ".$_SESSION["user_details"]["surname"]. "</p>";
echo "<p>E-mail: ".$_SESSION["user_details"]["mail"]. "</p>";
echo "<a href='?page=account&action=change' class='btn-secondary btn'> Změnit údaje</a>";
}



?>
</div>
</div>
</div>