<?php

class Exoplanet{
	public int $id;
	public string $name;
	public string $parent_star; 
	public float $distance_from_parent_star;
	public float $mass;
	public float $inclination;
	public float $eccentricity;
	public int $potentially_habitable;
	public string $description;
	public string $model;

	public function __construct($name, $parent_star, $distance_from_parent_star, $mass, $inclination, $eccentricity,$potentially_habitable,$description){
		//$this->id = $id;
		$this->name = $name;
		$this->parent_star = $parent_star;
		$this->distance_from_parent_star = $distance_from_parent_star;
		$this->mass = $mass;
		$this->inclination = $inclination;
		$this->eccentricity = $eccentricity;
		$this->description = $description;
		$this->potentially_habitable=$potentially_habitable;
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
		return "INSERT INTO `astronet_exoplanets` (`name`, `parent_star`, `distance_from_parent_star`, `mass`, `inclination`, `eccentricity`, `potentially_habitable`, `description`, `3d_model`) VALUES ('$this->name','$this->parent_star','$this->distance_from_parent_star','$this->mass','$this->inclination','$this->eccentricity','$this->potentially_habitable','$this->description',$model)";
	}

	public function sqlEdit(){
		if(isset($this->model)){
			$model = "'".$this->model."'";
		}else{
			$model = "NULL";
		}

		return "UPDATE `astronet_exoplanets` SET `name`='$this->name', `parent_star`='$this->parent_star',`mass`='$this->mass',`inclination`='$this->inclination',`eccentricity`='$this->eccentricity',`potentially_habitable`='$this->potentially_habitable',`description`='$this->description',`3d_model`=$model WHERE `astronet_exoplanets`.`id` = $this->id";
	}

}