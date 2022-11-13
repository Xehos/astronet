<?php

class SSPlanet{

	public int $id;
	public string $name;
	public float $distance_from_sun; 
	public float $density;
	public float $diameter;
	public float $mass;
	public float $orbital_period;
	public float $inclination;
	public float $eccentricity;
	public string $description;
	public string $model;
	public int $solar_order;

	public function __construct($name, $distance_from_sun, $density, $diameter, $mass, $orbital_period, $inclination, $eccentricity,
		$description, $model, $solar_order){
		//$this->id = $id;
		$this->name = $name;
		$this->distance_from_sun = $distance_from_sun;
		$this->density = $density;
		$this->diameter = $diameter;
		$this->mass = $mass;
		$this->orbital_period = $orbital_period;
		$this->inclination = $inclination;
		$this->eccentricity = $eccentricity;
		$this->description = $description;
		$this->model = $model;
		$this->solar_order = $solar_order;
	}
	
	public function setID($id){
		$this->id = $id;
	}

	public function sqlCreate(){
		return "INSERT INTO `astronet_ssplanets` (`name`, `distance_from_sun`, `density`, `diameter`, `mass`, `orbital_period`, `inclination`, `eccentricity`, `description`, `3d_model`, `solar_order`) VALUES ('$this->name','$this->distance_from_sun','$this->density','$this->diameter','$this->mass','$this->orbital_period','$this->inclination','$this->eccentricity','$this->description','$this->model','$this->solar_order')";
	}

	public function sqlUpdate(){
		return "UPDATE `astronet_ssplanets` SET `name` = '$this->name', `distance_from_sun` = '$this->distance_from_sun', `density` = '$this->density', `diameter` = '$this->diameter', `mass` = '$this->mass', `orbital_period` = '$this->orbital_period', `inclination` = '$this->inclination', `eccentricity` = '$this->eccentricity', `description` = '$this->description', `3d_model` = '$this->model' WHERE `astronet_ssplanets`.`id` = $this->id";
	}
}