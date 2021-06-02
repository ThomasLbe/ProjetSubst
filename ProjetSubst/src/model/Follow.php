<?php 
/**
 * 
 */
class Follow {

	private $user;
	private $club;
	
	function __construct($user,$club)
	{
		$this->user=$user;
		$this->club=$club;
	}

	public function get_user(){
		return $this->user;
	}
	public function getclub(){
		return $this->club;
	}


}
 ?>