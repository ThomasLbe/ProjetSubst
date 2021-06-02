<?php 
/**
 * 
 */
class Compte {

	private $nom;
	private $login;
	private $pass;
	private $statut;
	
	function __construct($nom,$login,$pass,$statut)
	{
		$this->nom=$nom;
		$this->login=$login;
		$this->pass=$pass;
		$this->statut=$statut;
	}

	public function getnom(){
		return $this->nom;
	}

	public function getlogin(){
		return $this->login;
	}

	public function getpass(){
		return $this->pass;
	}

	public function getstatut(){
		return $this->statut;
	}
}

 ?>