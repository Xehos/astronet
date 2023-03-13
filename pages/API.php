<?php

?>

<div class="row justify-content-center text-center">
	<div class="col-md-6">
	<?php
	if(isset($_SESSION["user_id"])){
	echo "
		<h1>Nápověda k API</h1>
		<h4>Endpoint: " . "<a href=$api_endpoint>$api_endpoint</a>" ."</h4>
		<h5>Váš API klíč naleznete/vygenerujete v sekci vašeho účtu</h5>
		";

		
		$ch = curl_init($api_endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500);
    	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);

		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    	
		curl_close($ch);
		echo "
		<h5>Status:"; if($status!=200){echo "&#128308;";}else{echo "&#128994;";}; echo "</h5>

		<table style='margin:0em' class='table table-dark table-condensed'>
			
				<tr>
					<th>Cesta</th>
					<th>Parametry</th>
					<th>Akce</th>
				</tr>";

				
				$response = Db::queryAll("SELECT * FROM astronet_api_help");
				foreach ($response as $row){
					echo "<tr>";
					if($_SESSION["user_details"]["api_key"]!=""){
						$api_key = $_SESSION["user_details"]["api_key"]->key;
					}else{
						$api_key = "";
					}
						echo "<th>" . "<a style='color:white;text-decoration:underline' href=$api_endpoint".$row["route"]."?api_key=$api_key".">". $row["route"] . "</th>";
						echo "<td>" . $row["attributes"] . "</td>";
						echo "<td>" . $row["action"] . "</td>";
					echo "</tr>";
					
				}
		echo "</table>";
			}else{
					echo "<h3>Pro použití API se prosím zdarma <a href='?page=register'>zaregistrujte</a>, nebo <a href='?page=login'>přihlaste</a>!</h3>";
				}
				?>
		



	</div>
</div>