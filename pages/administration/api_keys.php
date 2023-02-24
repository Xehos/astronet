<?php

$api_keys_sql = Db::queryAll("SELECT * FROM astronet_api_keys");

if(isset($_GET["action"])){
	if(!isset($_GET["id"])){
		header("?page=administration&menusel=api_keys");
	}else{
		$api_key_id = htmlspecialchars(stripslashes($_GET["id"]));
	}
	if($_GET['action']=="block"){
		Db::query("UPDATE astronet_api_keys SET revoked = 1 WHERE id = $api_key_id");
		echo " <meta http-equiv='refresh' content=\"0; url='?page=administration&menusel=api_keys&stat=apiblocked'\" />";
	}else if ($_GET['action']=="allow") {
		Db::query("UPDATE astronet_api_keys SET revoked = 0 WHERE id = $api_key_id");
		echo " <meta http-equiv='refresh' content=\"0; url='?page=administration&menusel=api_keys&stat=apiallowed'\" />";
	}else{
		header("?page=administration&menusel=api_keys");
	}
}

echo "
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 

			echo "
				<tr>
					<th>ID</th>
					<th>Klíč</th>
					<th>Uživatel</th>
					<th>Denní kvóta (requestů)</th>
					<th>Dnes vyčerpáno (requestů)</th>
					<th>Zablokován</th>
					<th>Akce</th>
				</tr>
					";

				foreach($api_keys_sql as $api_key){
					$username = Db::querySingle("SELECT username FROM astronet_users WHERE id = ". $api_key["user_id"]);

					echo "<tr>";
					$api_key_id = $api_key["id"];
					echo "<td>".$api_key_id."</td>";
					echo "<td>".$api_key["api_key"]."</td>";
					echo "<td>".$username."</td>";
					echo "<td>".$api_key["requests_quota"]."</td>";
					echo "<td>".$api_key["requests_today"]."</td>";
					
					if($api_key["revoked"]){
						echo "<td>Ano</td>";
						echo "<td><a href='?page=administration&menusel=api_keys&action=allow&id=$api_key_id' class='btn btn-secondary'>Povolit</a></td>";
					}else{
						echo "<td>Ne</td>";
						echo "<td><a href='?page=administration&menusel=api_keys&action=block&id=$api_key_id' class='btn btn-secondary'>Blokovat</a></td>";
					}
					

					echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
