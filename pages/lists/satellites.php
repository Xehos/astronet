<?php
	// Výpis planet sluneční soustavy
	
	echo 
	"<script type='module' src='js/model-viewer.min.js'></script>
	
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 

			if(isset($_SESSION['user_details'])){
							if($_SESSION['user_details']['role']==1){

			echo "
			<tr>

			<th>Admin</th>
			<td colspan='7'><a href='?page=edit&table=satellites&action=create' class='btn btn-secondary'>Vložit nový satelit</a></td>


			</tr>
			";

			}}
			echo "
				<tr>
					<th>Název</th>
					<th>Planeta</th>
					<th>Vzdálenost od planety <br>(10<sup>3</sup> km)</th>
					<th>Průměr (km)</th>
					<th>Hmotnost (*10<sup>24</sup>kg)</th>
					<th>Perioda orbity (d)</th>
					<th>Orbitální sklon (stupně)</th>
					<th>Orbitální výstřednost</th>
					<th></th>
					
				</tr>";

				$satellites = Db::queryAll("SELECT * FROM astronet_satellites ORDER BY id");
				$i = 0;
				foreach($satellites as $satellite){
					$i+=1;
					$id = $satellite["id"];
					echo "<tr id='row_satellite_$id'>";
					echo "<th>".$satellite["name"]."</th>";
					echo "<td>".$satellite["distance_from_planet"]."</td>";
						//echo "<td>".$satellite["density"]."</td>";
						echo "<td>".$satellite["diameter"]."</td>";
						echo "<td>".$satellite["mass"]."</td>";

						echo "<td>".$satellite["orbital_period"]."</td>";
						echo "<td>".$satellite["inclination"]."</td>";
						echo "<td>".$satellite["eccentricity"]."</td>";
						echo "<td>"."<button  data-toggle='collapse' data-target='#planet$i' class='accordion-toggle'>	&#128065;</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='planet$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						
						echo "<th>"."Model"."</th>";
						echo "<th>"."Popis"."</th>";
						echo "<th>"."API"."</th>";

						//echo "<td>".$satellite["year"]."</td>";
						echo "</tr>";

						echo "<tr>";
						$satname = $satellite["name"];
						$sat_id = $satellite["id"];
						$modelpath = "3d/".$satellite["3d_model"];
						echo "<td>".
						"
						<model-viewer shadow-intensity='0' alt='$satname' src='$modelpath' ar shadow-intensity='1' camera-controls touch-action='pan-y'></model-viewer>"

						."</td>";

						echo "<td>".$satellite["description"]."</td>";
						echo "<td><a class='btn btn-info' href='$api_endpoint/satellites?limit=1&satellite=$sat_id'>"."API"."</a></td>";

						echo "</tr>";
						
						if(isset($_SESSION['user_details'])){
							if($_SESSION['user_details']['role']==1){


						echo "<tr>";
						echo "<th>" . "Admin" . "</th>";
						
						echo "<td>"."<a href='?page=edit&table=satellites&id=$id&action=edit' class='btn btn-secondary mr-2'>Upravit</a>";
						echo "<a href='?page=edit&table=satellites&id=$id&action=delete' class='btn btn-secondary ml-2'>Smazat</a>";
						echo "</td>";
						
						echo "</tr>";
						}
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