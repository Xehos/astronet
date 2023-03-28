<?php
	// Výpis exoplanet
	$allExoplanets = Db::queryAll("SELECT * FROM astronet_exoplanets ORDER BY id");
	echo 
	"<script type='module' src='js/model-viewer.min.js'></script>
	
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 
			if($admin_logged){

			echo "
			<tr>
			<th>Admin</th>
			<td colspan='7'><a href='?page=edit&table=exoplanets&action=create' class='btn btn-secondary'>Vložit novou exoplanetu</a></td>
			</tr>
			";

			}
			echo $EXOPLANETS_TABLE_HEADER;

				// echo "start: " .  $start. "<br>" ;
				// echo "end: ". $end. "<br>" ;
				
				$exoplanets = array_slice($allExoplanets, $start, $end-1);
				$exoplanets = array_slice($exoplanets, 0 , $limit);
				//var_dump($exoplanets);
		
				//var_dump($exoplanets);
				$i = 0;
				foreach($exoplanets as $exoplanet){
					$i+=1;
					$id = $exoplanet["id"];
					echo "<tr id='row_exoplanet_$id'>";

					echo "<th>".$exoplanet["name"]."</th>";
					echo "<td>".$exoplanet["parent_star"]."</td>";
					echo "<td>".$exoplanet["distance_from_parent_star"]."</td>";
						//echo "<td>".$exoplanet["density"]."</td>";
						echo "<td>".$exoplanet["mass"]."</td>";
						echo "<td>".$exoplanet["inclination"]."</td>";
						echo "<td>".$exoplanet["eccentricity"]."</td>";
						if($exoplanet["potentially_habitable"]){
							$habitable = "ANO";
						}else{
							$habitable = "NE";
						}


						echo "<td>".$habitable."</td>";
						echo "<td>"."<button  data-toggle='collapse' data-target='#exoplanet$i' class='accordion-toggle'>	&#128065;</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='exoplanet$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						if(isset($exoplanet["3d_model"]) && $exoplanet["3d_model"] != ""){
						echo "<th>"."Model"."</th>";
					}
						echo "<th>"."Popis"."</th>";
						echo "<th>"."API"."</th>";

						//echo "<td>".$exoplanet["year"]."</td>";
						echo "</tr>";

						echo "<tr>";
						$satname = $exoplanet["name"];
						$sat_id = $exoplanet["id"];
						if(isset($exoplanet["3d_model"]) && $exoplanet["3d_model"] != ""){

						$modelpath = "3d/".$exoplanet["3d_model"];
						echo "<td>".
						"
						<model-viewer shadow-intensity='0' alt='$satname' src='$modelpath' ar shadow-intensity='1' camera-controls touch-action='pan-y'></model-viewer>"

						."</td>";
					}else{
						$modelpath = "";
					}
						

						echo "<td>".$exoplanet["description"]."</td>";
						if($user_logged){
						echo "<td><a class='btn btn-info' target='_blank' href='$api_endpoint/exoplanets?limit=1&exoplanet_id=$sat_id&api_key=$api_key'>"."API"."</a></td>";
					}else{
						echo "<td><a style='pointer-events: auto;' class='btn btn-secondary disabled' title='Pro využití API se prosím přihlaste'>"."API"."</a></td>";
					}
						echo "</tr>";
						
						if($admin_logged){


						echo "<tr>";
						echo "<th>" . "Admin" . "</th>";
						
						echo "<td>"."<a href='?page=edit&table=exoplanets&id=$id&action=edit' class='btn btn-secondary m-1'>Upravit</a>";
						echo "<a href='?page=edit&table=exoplanets&id=$id&action=delete' class='btn btn-secondary m-1'>Smazat</a>";
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