<?php

class SatelliteArt extends Satellite{
	public int $id;
	public string $name;
	public int $artificial;
	public int $planet_id;
	public float $distance_from_planet;
	public float $orbital_period;
	public string $description;
	public string $model;
	function __construct($name, $artificial, $planet_id, $distance_from_planet, $orbital_period, $description){
		$this->name = $name;
		$this->artificial = $artificial;
		$this->planet_id = $planet_id;
		$this->distance_from_planet = $distance_from_planet;
		$this->orbital_period = $orbital_period;
		$this->description = $description;
	}
}