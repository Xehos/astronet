<?php
	function sessionCheck(){
		if(isset($_SESSION["user_id"])){
		
			if($_SESSION["user_details"]["password_reset"] == 1){
			if(explode("=",$_SERVER["REQUEST_URI"])[1]!="resetpass"){
				header("Location: ?page=resetpass"); // Don't let user do anything before he changes his password
			}
			}
			return true;

		}else{
			return false;
		}

	}
?>