<?php

function addAPIkey($user_id){
	$api_key = new APIkey($user_id);
	$_SESSION["user_details"]['api_key'] = $api_key;	
}