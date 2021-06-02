<?php 

/**
 * 
 */
class CompteBuilder {

	private $data;
	private $error=null;
	
	
	function __construct($data)
	{
		$this->data=$data;
		$this->error= array();
	}

	public function createCompte(){
		$hash = password_hash($this->data['pass'], PASSWORD_BCRYPT);
		return new Compte($this->data['nom'],$this->data['login'],$hash,'user');
	}

	public function isValid(){
		$bool=1;
		if (empty($this->data)) {
			$this->error['nom']='Veuillez saisir un nom';
			$this->error['login']='Veuillez saisir un pseudo ';
			$this->error['pass']='Veuillez saisir un mot de passe';
			$bool=0;
		}
		if ($this->data['nom']==="") {
			$this->error['nom']='Veuillez saisir un nom';
			$bool=0;
    	}if ($this->data['login']==="") {
    		$this->error['login']='Veuillez saisir un pseudo';
    		$bool=0;
    	}if ($this->data['pass']==="") {
    		$this->error['pass']='Vous devez entrer un mot de passe';
    		$bool=0;
    	}

    	return $bool;
	}

	public function getData(){
		return $this->data;
	}

	public function getError(){
		return $this->error;
	}
}
 ?>