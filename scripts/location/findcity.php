<?php 
// Used to query single city from MySQL DB
function getCity($id){
	global $conn;
	
	$sql = "SELECT * FROM cities WHERE id='$id';";
	#echo $sql;
	$result = Db::queryAll($sql);
	
	foreach($result as $row){
		$city_arr = array('name'=>$row['name'],'lon'=>$row['lon'],'lat'=>$row['lat']);
		break;
	}
return $city_arr;
}
?>