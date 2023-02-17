<?php
	// Výpis planet sluneční soustavy
	
	echo 
	"
	
			<div class='table-responsive' id='object-table'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 

			if($admin_logged){

			echo "
			<tr>

			<th>Admin</th>
			<td colspan='7'><a href='?page=edit&table=solarsystem&action=create' class='btn btn-secondary'>Vložit novou planetu</a></td>
			</tr>
			";

			}
			echo $SSPLANETS_TABLE_HEADER;
				
				//echo "start: " . $start . "<br>" ;
				//echo "end: ". $end. "<br>" ;
				$planets = Db::queryAll("SELECT * FROM astronet_ssplanets WHERE solar_order > $start AND solar_order < $end ORDER BY solar_order");
				$i = 0;
				foreach($planets as $planet){
					$i+=1;
					$id = $planet["id"];
					echo "<tr id='row_planet_$id'>";
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
				}
				echo "
				</table>
				</div>	
				</div>
				</div>";