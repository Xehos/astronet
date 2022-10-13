<?php
	function sessionCheck(){
		if(isset($_SESSION["user_id"])){
			return true;
		}else{
			return false;
		}
	}
?>