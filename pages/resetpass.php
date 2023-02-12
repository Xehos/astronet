<?php
function checkForm($postdata){
	$password_check = htmlspecialchars(stripslashes($postdata["password_check"]));
	$password_raw = htmlspecialchars(stripslashes($postdata["password"]));
	if($password_raw!=$password_check){
		return -1;
	}

	$password_hash = password_hash($postdata["password"], PASSWORD_BCRYPT);

	$sql = "UPDATE astronet_users SET `password` = '$password_hash',`password_reset` = '0' WHERE `id` = ".$_SESSION['user_id'];

	return $sql;
}

if(isset($_POST["password"])){
	$sql = checkForm($_POST);
	if($sql!=-1){
		Db::queryAll($sql);
		$_SESSION['user_details']['password_reset'] = 0;
		header("Location: ?page=domu?stat=passresetsuccess");
	}
}
?>
<div class="main-container mt-5 justify-content-center text-center">
	<h1 class="display-4" style="font-size:2.2em">Je vyžadován reset hesla</h1>
	<h1 class="display-4" style="font-size:1.5em">Prosím změňte své heslo:</h1>
	<form action="" method="post">
		
		<input type="password" name="password" class="form-control mt-2" placeholder="Heslo" required>
		<input type="password" name="password_check" class="form-control mt-2" placeholder="Heslo znovu" required>
		<input type="submit" class="btn btn-prim mt-2">
	</form>
	<p class="mt-3"><u><a class="text-white" href="?page=domu&action=logout">Odhlásit se</a></u></p>


</div>