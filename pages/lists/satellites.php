<?php
	// Výpis satelitů planet sluneční soustavy
	$allSatellites = Db::queryAll("SELECT * FROM astronet_satellites ORDER BY id");

	echo 
	"<script type='module' src='js/model-viewer.min.js'></script>
	
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 

			if($admin_logged){

			echo "
			<tr>
			<th>Admin</th>
			<td colspan='7'><a href='?page=edit&table=satellites&action=create' class='btn btn-secondary'>Vložit nový satelit</a></td>
			</tr>
			";

			}
			echo $SATELLITES_TABLE_HEADER;

				// echo "start: " .  $start. "<br>" ;
				// echo "end: ". $end. "<br>" ;
				
				$satellites = array_slice($allSatellites, $start, $end-1);
				$satellites = array_slice($satellites, 0 , $limit);
				//var_dump($satellites);
		
				//var_dump($satellites);
				$i = 0;
				foreach($satellites as $satellite){
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