<?php

$SSPLANETS_TABLE_HEADER =  "
				<tr>
					<th>Název</th>
					<th>Průměrná vzdálenost od slunce <br>(10<sup>6</sup> km)</th>
					<th>Hustota (kg/m<sup>3</sup>)</th>
					<th>Průměr (km)</th>
					<th>Hmotnost (*10<sup>24</sup>kg)</th>
					<th>Perioda orbity (d)</th>
					<th>Orbitální sklon (stupně)</th>
					<th>Orbitální výstřednost</th>
					<th></th>
					
				</tr>";



$SATELLITES_TABLE_HEADER = "
				<tr>
					<th>Název</th>
					<th>Planeta</th>
					<th>Vzdálenost od planety <br>(km)</th>
					<th>Průměr (km)</th>
					<th>Hmotnost (*10<sup>24</sup>kg)</th>
					<th>Perioda orbity (d)</th>
					<th>Orbitální sklon (stupně)</th>
					<th>Orbitální výstřednost</th>
					<th></th>
				</tr>";

function printAPIPart($user_logged){
	if($user_logged){
						echo "<td><a class='btn btn-info' href='$api_endpoint/ssplanets?limit=1&planet=$plname'>"."API"."</a></td>";
					}else{
						echo "<td><a style='pointer-events: auto;' class='btn btn-secondary disabled' title='Pro využití API se prosím přihlaste'>"."API"."</a></td>";
					}
}