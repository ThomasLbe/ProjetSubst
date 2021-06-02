<?php 
/**
 * 
 */
class Club {

	private $sport;
	private $club;
	private $twitter;
	private $site;
	private $image;
	private $id;
	
	function __construct($sport,$club,$twitter,$site,$image)
	{
		$this->sport=$sport;
		$this->club=$club;
		$this->twitter=$twitter;
		$this->image=$image;
		$this->site=$site;
	}

	public function get_sport(){
		return $this->sport;
	}
	public function getid(){
		return $this->id;
	}
	public function getclub(){
		return $this->club;
	}
	public function gettwitter(){
		return $this->twitter;
	}
	
	public function getsite(){
		return $this->site;
	}
	public function getimage(){
		return $this->image;
	}


}
 ?>