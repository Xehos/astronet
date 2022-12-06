<?php

class User{
	public int $id;
	public string $username;
	public string $mail;
	public string $password_hash;
	public string $name;
	public string $surname;
	public int $sex;
	public int $city_id;
	public string $born_date;
	public int $role;
	public int $password_reset;
	public function __construct($username, $mail, $password_hash, $name, $surname, $sex, $city_id, $born_date, $role, $password_reset){
		$this->username = $username;
		$this->mail = $mail;
		$this->password_hash = $password_hash;
		$this->name = $name;
		$this->surname = $surname;
		$this->sex = $sex; 
		$this->city_id = $city_id;
		$this->born_date = $born_date;
		$this->role = $role;
		$this->password_reset = $password_reset;
	}
	public function setID($id){
		$this->id = $id;
	}

	public function bornCitySql(){
		return "SELECT name FROM astronet_cities WHERE id = $this->city_id LIMIT 1";
	}

	public function sqlEdit(){
		return "UPDATE astronet_users SET `username` = '$this->username', `name` = '$this->name',
		`surname` = '$this->surname',`sex` = '$this->sex',`role` = '$this->role',`password_reset` = '$this->password_reset' WHERE `id` = '$this->id'";
	}

}