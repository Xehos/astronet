<?php 
// Used to query states from MySQL DB
include("../../env.php");
require_once("../Db.php");
Db::connect($MYSQLHOST,$MYSQLDB,$MYSQLUSER,$MYSQLPASS);
$country_code = $_GET['country_code'];
$sql = "SELECT * FROM astronet_states WHERE country='$country_code'";
$result = Db::queryAll($sql);
	echo "<option disabled selected>Prosím vyberte kraj/stát/provincii</option>";
foreach($result as $row){
	echo "<option value='" . $row['id'] . "'>" . $row['name'] ."</option>";
}
?>