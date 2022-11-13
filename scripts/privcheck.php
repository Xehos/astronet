<?php

if(isset($_SESSION["user_details"])){
	if($_SESSION["user_details"]["role"]!=1){
		header("Location: ?page=domu");
	}
}else{
	header("Location: ?page=domu");
}

