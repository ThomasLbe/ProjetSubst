<?php 

/**
 * 
 */
class CompteStorageMySQL implements CompteStorage {

	public $connexion;
	
	function __construct($connexion)
	{
		$this->connexion=$connexion;
	}

	public function checkAuth($login, $pass){
		$rq = "SELECT * FROM compte WHERE login= :login";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':login' => $login,
        );
		$stmt->execute($data);
		$account=$this->hydrate($stmt);
		if ($account!=null) {
			if (password_verify($pass, $account->getpass())) {
			    return $account;
		    }else{
			    return null;
		    }
		}else{
			return null;
		}
		
	}
	
	public function readAll(){ //On ne veut récuperer que les comptes utilisateurs
		$rq = "SELECT * FROM compte WHERE statut='user'";
		$stmt = $this->connexion->prepare($rq);
		$stmt->execute();
        $tab=[];
		while($setup = $stmt->fetch(PDO::FETCH_ASSOC)){
			$tab[$setup['login']]=new Compte($setup['nom'],$setup['login'],$setup['pass'],$setup['statut']);
		}
		return $tab;
		
	}

	public function create(Compte $c){
		$rq = "INSERT INTO compte (nom,login,pass,statut) VALUES (:nom,:login,:pass,:statut)";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':nom' => $c->getNom(),
         ':login' => $c->getLogin(),
         ':pass' => $c->getpass(),
         ':statut' => $c->getStatut(),
        );
        $t=$stmt->execute($data);
        if ($t) {
        	return $this->connexion->lastInsertId();
        }
	}
	
	public function delete($id){
		$rq = "DELETE FROM compte WHERE login= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
        if ($stmt->execute($data)) {
        	return true;
        }else{
        	return false;
        }
	}
	
	public function prom($id){
		$rq = "UPDATE compte SET statut='admin'	 WHERE login= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
        if ($stmt->execute($data)) {
        	return true;
        }else{
        	return false;
        }
	}

	public function exists($login){
		$rq = "SELECT * FROM compte WHERE login= :login";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':login' => $login,
        );
		$stmt->execute($data);
		$rs=$this->hydrate($stmt);
		if ($rs===[]) {
			return 0;
		}else{
			return 1;
		}
	}

	public function hydrate($stmt){
		$compte=[];
		if ($setup = $stmt->fetch(PDO::FETCH_ASSOC)) {
		     $compte=new Compte($setup['nom'],$setup['login'],$setup['pass'],$setup['statut']);
		}
    	return $compte;
	}
}

 ?>