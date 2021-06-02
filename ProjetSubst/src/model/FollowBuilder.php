<?php 
/**
 * 
 */
class FollowBuilder {

	private $data;
	private $error=null;
	
	function __construct($data)
	{
		
		$this->data=$data;
		$this->error= array();
	}

	public function createClub(){
		return new Club(htmlspecialchars($this->data['user']),htmlspecialchars($this->data['club']));
	}

	

	public function getData(){
		return $this->data;
	}

	public function getError(){
		return $this->error;
	}
}
 ?>