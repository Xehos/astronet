<?php
class Satellite{
	public int $id;
	public string $name;
	public int $artificial;
	public int $planet_id;
	public float $distance_from_planet;
	public float $diameter;
	public float $mass;
	public float $orbital_period;
	public float $inclination;
	public float $eccentricity;
	public string $description;
	public string $model;

	function __construct($name, $artificial, $planet_id,$distance_from_planet,$diameter, $mass, $orbital_period,$inclination, $eccentricity, $description){
		$this->name = $name;
		$this->artificial = $artificial;
		$this->planet_id = $planet_id;
		$this->distance_from_planet = $distance_from_planet;
		$this->diameter = $diameter;
		$this->mass = $mass;
		$this->orbital_period = $orbital_period;
		$this->inclination = $inclination;
		$this->eccentricity = $eccentricity;
		$this->description = $description;
	}

	

	public function setID($id){
		$this->id = $id;
	}
	public function setModel($model){
		$this->model = $model;
	}

	public function sqlCreate(){
		if(isset($this->model)){
			$model = "'".$this->model."'";
		}else{
			$model = "NULL";
		}
		if(!$this->artificial){

		return "INSERT INTO `astronet_satellites` (`name`, `artificial`, `planet_id`, `distance_from_planet`, `diameter`, `mass`, `orbital_period`, `inclination`, `eccentricity`, `description`, `3d_model`) VALUES ('$this->name', '$this->artificial', '$this->planet_id', '$this->distance_from_planet', '$this->diameter', '$this->mass', '$this->orbital_period', '$this->inclination', '$this->eccentricity', '$this->description',$model)";
		}else{
			return "INSERT INTO `astronet_satellites` (`name`, `artificial`, `planet_id`, `distance_from_planet`, `orbital_period`, `description`, `3d_model`) VALUES ('$this->name', '$this->artificial', '$this->planet_id', '$this->distance_from_planet', '$this->orbital_period', '$this->description', $model)";
		}
	}

	public function sqlEdit(){
		if(isset($this->model)){
			$model = "'".$this->model."'";
		}else{
			$model = "NULL";
		}

		if(!$this->artificial){
			return "UPDATE `astronet_satellites` SET `name`='$this->name', `planet_id`='$this->planet_id', `distance_from_planet`='$this->distance_from_planet', `diameter`='$this->diameter',`mass`='$this->mass', `orbital_period` = '$this->orbital_period', `inclination` = '$this->inclination', `eccentricity` = '$this->eccentricity', `description` = '$this->description', `3d_model` = $model WHERE id = $this->id";
		
	}else{

			return "UPDATE `astronet_satellites` SET `name`='$this->name', `planet_id`='$this->planet_id', `distance_from_planet`='$this->distance_from_planet', `diameter`='$this->diameter',`mass`='$this->mass', `orbital_period` = '$this->orbital_period', `inclination` = '$this->inclination', `eccentricity` = '$this->eccentricity', `description` = '$this->description', `3d_model` = $model WHERE id = $this->id";
	}
	}


}

