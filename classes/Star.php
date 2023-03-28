<?php
class Star{
	public int $id;
	public string $name;
	public float $distance_from_earth;
	public float $distance_from_sun;
	public float $magnitude;
	public string $color;
	public float $luminosity;
	public float $mass;
	public string $description;

	function __construct($name, $distance_from_earth, $distance_from_sun, $magnitude, $color, $luminiosity, $mass, $description){
		$this->name = $name;
		$this->distance_from_earth = $distance_from_earth;
		$this->distance_from_sun = $distance_from_sun;
		$this->magnitude = $magnitude;
		$this->color = $color;
		$this->luminosity = $luminiosity;
		$this->mass = $mass;
		$this->description = $description;
	}
	public function sqlCreate(){
		return "INSERT INTO `astronet_stars` (`name`, `distance_from_earth`, `distance_from_sun`, `magnitude`, `color`, `luminosity`, `mass`, `description`) VALUES ('$this->name', '$this->distance_from_earth', '$this->distance_from_sun', '$this->magnitude', '$this->color', '$this->luminiosity', '$this->mass', '$this->description')";
	}

	public function sqlEdit(){
		return "UPDATE `astronet_stars` SET `name` = '$this->name', `distance_from_earth` = '$this->distance_from_earth', `distance_from_sun`='$this->distance_from_sun',`magnitude`='$this->magnitude',`color`='$this->color',`luminosity`='$this->luminosity',`mass`='$this->mass',`description`='$this->description' WHERE id = $this->id";
	}
	public function setID($id){
		$this->id = $id;
	}
	


}