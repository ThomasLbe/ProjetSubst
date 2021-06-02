<?php 
/**
 * 
 */
class CompteManager {

	private $CompteStorage;

	function __construct(CompteStorage $CompteStorage)
	{
		$this->CompteStorage=$CompteStorage;
	}

	public function connectUser($login, $pass){
		$login=$this->CompteStorage->checkAuth($login, $pass);
		if ($login!=null) {
			$_SESSION['user']=$login;
			return true;
		}else{
			return false;
		}
	}

	public function isUserConnected(){
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	public function isAdminConnected(){
		if (isset($_SESSION['user'])) {
			if ($_SESSION['user']->getdtatut()==='admin') {
				return true;
			}
		}
		return false;
	}

	public function getUserName(){
		return $_SESSION['user']->getnom();
	}

	public function disconnectUser(){
		unset($_SESSION['user']);
	}

	public function getAccountStorage(){
		return $this->AccountStorage;
	}
}
 ?>