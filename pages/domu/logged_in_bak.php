<style>
/*
TEMP
*/
body{
	background-color:white;
}

h1,h2,h3,h4,h5,h6{
	font-family:Verdana;
}
div.main-box{
	margin: 0 auto;
	background-color:black; 
	min-height:50em;
	padding-top:2em;
}
img.sign-icon{
	max-width:75%;
	margin: 0 auto;
}

div#vignette { 
	width: 100%;
	max-width: 480px; 
	min-width: 240px;

	min-height: 270px;
	background-image: url(img/constellations/taurus.jpg);
	background-size: cover;
	border-radius: 0%;
	display: inline-block;
	box-shadow: inset 0 0 150px rgba(0, 0, 0, 1);
	/*overflow: hidden;*/
}
</style>
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
	<div class="col-md-6 main-box">
		<h2><?php echo $_SESSION['user_details']["name"]." ".$_SESSION['user_details']['surname'] ?></h2>
		<h5><?php echo str_replace("-",".",date("d-m-Y",strtotime($_SESSION['user_details']['born_date']))) ?></h5>
		<h5><?php echo getCity($_SESSION['user_details']['city_id'])["name"] ?></h5>

		<img src="img/svgs/heads/taurus.svg" class="sign-icon">
	
		<!--<img src="img/constellations/taurus.jpg" class="sign-icon vignette">-->
		<div class="sign-icon justify-content-center text-center">
			<div id="vignette"></div>
		</div>
	</div>	


</div>