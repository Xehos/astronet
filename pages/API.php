<?php

?>
<div class="row justify-content-center text-center">
	<div class="col-md-6">
		<h1>Nápověda k API</h1>
		<h4>Endpoint: <?php echo "<a href=$api_endpoint>$api_endpoint</a> " ?></h4>
		<?php
		$ch = curl_init($api_endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100);
		$status = curl_exec($ch);

    	
		curl_close($ch);
		?>
		<h5>Status: <?php if(strlen($status)<1){echo "&#128308;";}else{echo "&#128994;";};?></h5>

		<table style='margin:0em' class='table table-dark table-condensed'>
			
				<tr>
					<th>Cesta</th>
					<th>Parametry</th>
					<th>Akce</th>
				</tr>

				<?php
				$response = Db::queryAll("SELECT * FROM astronet_api_help");
				foreach ($response as $row){
					echo "<tr>";
						echo "<th>" . "<a style='color:white;text-decoration:underline' href=$api_endpoint".$row["route"].">". $row["route"] . "</th>";
						echo "<td>" . $row["attributes"] . "</td>";
						echo "<td>" . $row["action"] . "</td>";
					echo "</tr>";
				}
				?>
		</table>



	</div>
</div>