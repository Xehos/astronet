<?php
class APIkey{
	public int $id;
	public string $key;
	public int $user_id;
	public bool $revoked;


	public function __construct($user_id){
		$key_table = Db::queryAll("SELECT * FROM astronet_api_keys WHERE user_id = " . $user_id);
		if(count($key_table)>0){
		$this->id = $key_table[0]["id"];
		$this->key = $key_table[0]["api_key"];
		$this->user_id = $key_table[0]["user_id"];
		$this->revoked = $key_table[0]["revoked"];
	}else{
		$this->key = "";
	}
	}

	public function __toString(){    
		return $this->key;
	}

}