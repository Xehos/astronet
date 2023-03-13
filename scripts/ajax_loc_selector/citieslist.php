<?php 
// Used to query cities from MySQL DB
include("../../env.php");
require_once("../Db.php");
Db::connect($MYSQLHOST,$MYSQLDB,$MYSQLUSER,$MYSQLPASS);
$state_name = $_GET['state_name'];
$sql = "SELECT * FROM astronet_cities WHERE admin1='$state_name' ORDER BY name ASC";
$result = Db::queryAll($sql);
	echo "<option disabled selected>Prosím vyberte město</option>";
foreach($result as $row){
	echo "<option value='" . $row['id'] . "'>" . $row['name'] ."</option>";
}
?>