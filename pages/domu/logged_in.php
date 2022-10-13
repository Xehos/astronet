
<?php

include("scripts/location/findcity.php");

/*
	include("scripts/prokerala/client.php");
	$client = new Prokerala\Api\Sample\ApiClient('980e9a89-28f5-4e78-a7a2-0efc5ef260a9', 'hpggUPs8s4OhEQOx1t5NVhyDxLJ1fgxa3Fui6YP9');

$data = $client->get('v2/astrology/chart', [
    'ayanamsa' => 1,
    'coordinates' => '23.1765,75.7885',
    'datetime' => '2020-10-19T12:31:14+00:00',
    'chart_type'=>'drekkana',
    'chart_style'=>'south-indian',
    'format'=>'svg'
]);

print_r($data);
*/
?>

<div class="row text-center justify-content-center">
	<div class="col-md-9 col-sm-3 main-box">
		<div class="container-xl">
		<h1 style="margin:1em">Seznam vesmírných těles</h1>
		<div class='table-responsive'>
		<table style="margin:0.5em" class="table table-dark table-condensed">
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
				
			
			</tr>

			
				<?php 
				$planets = Db::queryAll("SELECT * FROM planets ORDER BY solar_order");
				$i = 0;
				foreach($planets as $planet){
					$i+=1;

					echo "<tr data-toggle='collapse' data-target='#planet$i' class='accordion-toggle'>";
					echo "<td>".$planet["name"]."</td>";
					echo "<td>".$planet["distance_from_sun"]."</td>";
						echo "<td>".$planet["density"]."</td>";
						echo "<td>".$planet["diameter"]."</td>";
						echo "<td>".$planet["mass"]."</td>";

						echo "<td>".$planet["orbital_period"]."</td>";
						echo "<td>".$planet["inclination"]."</td>";
						echo "<td>".$planet["eccentricity"]."</td>";
						echo "<td>"."<button class='btn btn-secondary'>Další informace</button>"."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='8' class='hiddenRow'>
							<div class='accordian-body collapse' id='planet$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						
						echo "<th>"."Popis"."</th>";
						//echo "<td>".$planet["year"]."</td>";

						echo "</tr>";
						echo "<tr>";

						echo "<td>".$planet["description"]."</td>";

						echo "</tr>";
						echo "</div";
						echo "</td>";

						echo "</table>";
						
						
						echo "</div>";
						echo "</td>";

					echo "</tr>";
				}
				?>
			

		</table>
	</div>	
</div>
</div>

</div>