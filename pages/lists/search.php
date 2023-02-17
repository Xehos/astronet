<?php
$results = array();
if(isset($_POST["search_query"])){
	$search_query = htmlspecialchars(stripslashes($_POST["search_query"]));
}
//var_dump($_POST);
?>


<form method='POST' action=''>
<input type='text' name='search_query' class='form-control' placeholder='Hledejte' value='<?php 
if(isset($search_query)){echo $search_query;} ?>'>
<input type='submit' class='btn btn-secondary mt-2' value='Vyhledat'>
</form>
<?php

	if(isset($search_query)){
		
		foreach ($list_tables as $table) {
			$sql_table = Db::queryAll("SELECT * FROM $table WHERE name LIKE '$search_query%'");
			$results[$table] = $sql_table;
		}
		
	}
?>



<?php
	foreach ($results as $table => $value) {
		echo "<div class='table-responsive' id='object-table'>   
			<table class='table mt-4 table-dark table-condensed'>";
			
		if($table=="astronet_ssplanets"){
			if(count($value)>0){
			echo "<h3 class='mt-2'>Nalezené planety sluneční soustavy:</h3>";
			echo $SSPLANETS_TABLE_HEADER;
			}
			$i = 0;
			foreach($value as $planet){
					$i+=1;
					$id = $planet["id"];

					echo "<tr id='row_planet_$i'>";
					echo "<th>".$planet["name"]."</th>";
					echo "<td>".$planet["distance_from_sun"]."</td>";
						echo "<td>".$planet["density"]."</td>";
						echo "<td>".$planet["diameter"]."</td>";
						echo "<td>".$planet["mass"]."</td>";

						echo "<td>".$planet["orbital_period"]."</td>";
						echo "<td>".$planet["inclination"]."</td>";
						echo "<td>".$planet["eccentricity"]."</td>";
						echo "<td>"."<button  data-toggle='collapse' data-target='#planet$i' class='accordion-toggle'>	&#128065;</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='planet$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						if(isset($planet["3d_model"])){
						echo "<th>"."Model"."</th>";
					}
						echo "<th>"."Popis"."</th>";
						echo "<th>"."API"."</th>";

						//echo "<td>".$planet["year"]."</td>";
						echo "</tr>";

						echo "<tr>";
						$plname = $planet["name"];
						if(isset($planet["3d_model"]) && $planet["3d_model"] != ""){
							$modelpath = "3d/".$planet["3d_model"];
							echo "<td>".
							"
							<model-viewer shadow-intensity='0' alt='$plname' src='$modelpath' ar shadow-intensity='1' camera-controls touch-action='pan-y'></model-viewer>"

							."</td>";
						}
						
						

						echo "<td>".$planet["description"]."</td>";

						if($user_logged){
						echo "<td><a class='btn btn-info' target='_blank' href='$api_endpoint/ssplanets?limit=1&planet=$plname'>"."API"."</a></td>";
					}else{
						echo "<td><a style='pointer-events: auto;' class='btn btn-secondary disabled' title='Pro využití API se prosím přihlaste'>"."API"."</a></td>";
					}

						echo "</tr>";
						
						if($admin_logged){


						echo "<tr>";
						echo "<th>" . "Admin" . "</th>";
						
						echo "<td>"."<a href='?page=edit&table=solarsystem&id=$id&action=edit' class='btn btn-secondary mr-2'>Upravit</a>";
						echo "<a href='?page=edit&table=solarsystem&id=$id&action=delete' class='btn btn-secondary ml-2'>Smazat</a>";
						echo "</td>";
						
						echo "</tr>";
						}
						
						echo "</div";
						echo "</td>";

						echo "</table>";
						
						
						echo "</div>";
						echo "</td>";

					echo "</tr>";
		}}
		else if($table=="astronet_satellites"){
			if(count($value)>0){
			echo "<h3 class='mt-2'>Nalezené satelity:</h3>";
			echo $SATELLITES_TABLE_HEADER;
			}
			$i = 0;
				foreach($value as $satellite){
					$i+=1;
					$id = $satellite["id"];
					echo "<tr id='row_satellite_$id'>";

					echo "<th>".$satellite["name"]."</th>";
					$planet_id = $satellite["planet_id"];
					echo "<td>". Db::querySingle("SELECT name FROM astronet_ssplanets WHERE id = $planet_id")."</td>";
					echo "<td>".$satellite["distance_from_planet"]."</td>";
						//echo "<td>".$satellite["density"]."</td>";
						echo "<td>".$satellite["diameter"]."</td>";
						echo "<td>".$satellite["mass"]."</td>";
						echo "<td>".$satellite["orbital_period"]."</td>";
						echo "<td>".$satellite["inclination"]."</td>";
						echo "<td>".$satellite["eccentricity"]."</td>";
						echo "<td>"."<button  data-toggle='collapse' data-target='#satellite$i' class='accordion-toggle'>	&#128065;</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='satellite$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						if(isset($satellite["3d_model"]) && $satellite["3d_model"] != ""){
						echo "<th>"."Model"."</th>";
					}
						echo "<th>"."Popis"."</th>";
						echo "<th>"."API"."</th>";

						//echo "<td>".$satellite["year"]."</td>";
						echo "</tr>";

						echo "<tr>";
						$satname = $satellite["name"];
						$sat_id = $satellite["id"];
						if(isset($satellite["3d_model"]) && $satellite["3d_model"] != ""){

						$modelpath = "3d/".$satellite["3d_model"];
						echo "<td>".
						"
						<model-viewer shadow-intensity='0' alt='$satname' src='$modelpath' ar shadow-intensity='1' camera-controls touch-action='pan-y'></model-viewer>"

						."</td>";
					}else{
						$modelpath = "";
					}
						

						echo "<td>".$satellite["description"]."</td>";
						if($user_logged){
						echo "<td><a class='btn btn-info' target='_blank' href='$api_endpoint/satellites?limit=1&satellite_id=$sat_id'>"."API"."</a></td>";
					}else{
						echo "<td><a style='pointer-events: auto;' class='btn btn-secondary disabled' title='Pro využití API se prosím přihlaste'>"."API"."</a></td>";
					}

						echo "</tr>";
						
						if($admin_logged){


						echo "<tr>";
						echo "<th>" . "Admin" . "</th>";
						
						echo "<td>"."<a href='?page=edit&table=satellites&id=$id&action=edit' class='btn btn-secondary mr-2'>Upravit</a>";
						echo "<a href='?page=edit&table=satellites&id=$id&action=delete' class='btn btn-secondary ml-2'>Smazat</a>";
						echo "</td>";
						
						echo "</tr>";
						}
						
						echo "</div";
						echo "</td>";

						echo "</table>";
						
						
						echo "</div>";
						echo "</td>";

					echo "</tr>";
				}

		
		echo "
			</table>
			</div>	
			</div>
			</div>";
	}
}
	//var_dump($results);

?>