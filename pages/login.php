<?php
//Login page script
//echo sessionCheck();
include("scripts/APIscripts.php");
if(sessionCheck()){
	header("Location: index.php?page=domu");
}


function login(){
	if (!isset($_POST['password']) or $_POST['password'] == '') { // In case of "required" attribute removal via element inspection
		return false;
	}else{
		return true;
	}
}

if(isset($_POST['mail'])){
	if(login()){
		$mail = htmlspecialchars(stripslashes($_POST["mail"]));
		$password = htmlspecialchars(stripslashes($_POST["password"]));
		$sql = "SELECT * FROM astronet_users WHERE mail='$mail'";
		$result = Db::queryAll($sql);
		$found = false;
		$wrongpassword = false;
		foreach($result as $row){
			if(password_verify($password,$row['password'])){
				$_SESSION['user_id'] = $row["id"];
				$user_details = array('username' => $row["username"], 'name' => $row["name"], 'surname' => $row["surname"],
					'sex' => $row["sex"], 'city_id' => $row["city_id"], 'born_date' => $row["born_date"], 'born_time' => $row["born_time"],'role' => $row["role"], 
					'password_reset' => $row["password_reset"], 'mail' => $row["mail"] // Saving user details into array
				);
				
				
				$_SESSION['user_details'] = $user_details;
				addAPIkey($row["id"]);
				header("Location: index.php?page=login");  // Refresh to log in
				$found = true;
				}else{
					$wrongpassword = true;
					header("Location: index.php?page=login&stat=wrongpassword"); 
				}
			
				
				break;
			
		}
	
	}else{
		header("Location: index.php?page=login"); 
	}
	if(!$found && !$wrongpassword){
	header("Location: index.php?page=login&stat=usernotfound"); 
}
}

?>
<div class="main-container mt-5 justify-content-center text-center">
	<?php 
	if(isset($_GET["state"])){
	if($_GET['state']=="registeredsucc"){
		echo "<div class='alert alert-success mb-2' role='alert'> Registrace byla úspěšná! Nyní se můžete přihlásit</div>";
		}
	}


	?>
	<h1 class="display-4" style="font-size:2.2em">Prosím přihlaste se:</h1>
	<form action="" method="post">
		<input type="email" name="mail" class="form-control" placeholder="E-mail" required>
		<input type="password" name="password" class="form-control mt-2" placeholder="Heslo" required>
		<input type="submit" value="Přihlásit se" class="btn btn-prim mt-2">
	</form>
	<p class="mt-1">Nemáte ještě účet? Neváhejte se zdarma <a href="?page=register">zaregistrovat</a></p>


</div>