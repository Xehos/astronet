<?php
$allStars = Db::queryAll("SELECT * FROM astronet_stars ORDER BY id");
echo 
	"<script type='module' src='js/model-viewer.min.js'></script>
	
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 
			if($admin_logged){

			echo "
			<tr>
			<th>Admin</th>
			<td colspan='7'><a href='?page=edit&table=stars&action=create' class='btn btn-secondary'>Vložit novou hvězdu</a></td>
			</tr>
			";

			}
			echo $STARS_TABLE_HEADER;
				// echo "start: " .  $start. "<br>" ;
				// echo "end: ". $end. "<br>" ;
				
				$stars = array_slice($allStars, $start, $end-1);
				$stars = array_slice($stars, 0 , $limit);
				//var_dump($stars);
		
				//var_dump($stars);
				$i = 0;
				foreach($stars as $star){
					$i+=1;
					$id = $star["id"];
					echo "<tr id='row_star_$id'>";

					echo "<th>".$star["name"]."</th>";
					echo "<td>".$star["distance_from_earth"]."</td>";
					echo "<td>".$star["distance_from_sun"]."</td>";
						//echo "<td>".$star["density"]."</td>";
						echo "<td>".$star["magnitude"]."</td>";
						echo "<td>".$star["color"]."</td>";
						echo "<td>".$star["luminosity"]."</td>";
						echo "<td>".$star["mass"]."</td>";
						//echo "<td>".$star["description"]."</td>";
						echo "<td>"."<button  data-toggle='collapse' data-target='#star$i' class='accordion-toggle'>	&#128065;</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='star$i'> ";
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						if(isset($star["3d_model"]) && $star["3d_model"] != ""){
						echo "<th>"."Model"."</th>";
					}
						echo "<th>"."Popis"."</th>";
						echo "<th>"."API"."</th>";

						//echo "<td>".$star["year"]."</td>";
						echo "</tr>";

						echo "<tr>";
					
						$star_id = $star["id"];
						
					
						echo "<td>".$star["description"]."</td>";
						if($user_logged){
						echo "<td><a class='btn btn-info' target='_blank' href='$api_endpoint/stars?limit=1&star_id=$star_id'>"."API"."</a></td>";
					}else{
						echo "<td><a style='pointer-events: auto;' class='btn btn-secondary disabled' title='Pro využití API se prosím přihlaste'>"."API"."</a></td>";
					}
						echo "</tr>";
						
						if($admin_logged){
						echo "<tr>";
						echo "<th>" . "Admin" . "</th>";
						
						echo "<td style='width:10em'>"."<a href='?page=edit&table=stars&id=$id&action=edit' class='btn btn-secondary m-1'>Upravit</a>";
						echo "<a href='?page=edit&table=stars&id=$id&action=delete' class='btn btn-secondary m-1'>Smazat</a>";
						
						echo "</td>";
						echo "</div>";
						
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