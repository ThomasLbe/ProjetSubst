<?php 
/**
 * 
 */
class ClubStorageMySQL implements ClubStorage {

	public $connexion;
	
	function __construct($connexion){
		$this->connexion=$connexion;		
	}

	public function read($id){
		$rq = "SELECT * FROM club WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
		$stmt->execute($data);
		return $this->hydrate($stmt);
	}

	public function existsClub($id){
		$rq = "SELECT * FROM club WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
		$stmt->execute($data);
		$rs=$this->hydrate($stmt);
		if (empty($rs)) {
			return 0;
		}else{
			return 1;
		}
	}


	public function readAll(){
		$rq = "SELECT * FROM club WHERE valide='1'";
		$stmt = $this->connexion->prepare($rq);
		$stmt->execute();
        return $this->hydrate($stmt);
	}
	
	public function readAllValide(){
		$rq = "SELECT * FROM club WHERE valide='0'";
		$stmt = $this->connexion->prepare($rq);
		$stmt->execute();
        return $this->hydrate($stmt);
	}

	
	public function valideclub($id){
		$rq = "UPDATE club SET valide='1' WHERE id=:id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
		$stmt->execute($data);
		return $this->hydrate($stmt);
	}
	
	public function search($club){
		$rq = "SELECT * FROM club WHERE club like '%$club%'";
		$stmt = $this->connexion->prepare($rq);
		$stmt->execute();
        return $this->hydrate($stmt);
	}
	
	/*public function search($club){
		$rq = "SELECT * FROM club WHERE club LIKE '% :club %'";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':club' => $club,
        );
		$stmt->execute($data);
		return $this->hydrate($stmt);
	}*/

	public function create(Club $b){
		$rq = "INSERT INTO club (sport,club,twitter,site,image,valide) VALUES (:sport,:club,:twitter,:site,:image,0)";
		$stmt = $this->connexion->prepare($rq);
		$stmt ->bindValue(':sport',$b->get_sport(),PDO::PARAM_STR);
		$stmt ->bindValue(':club',$b->getclub(),PDO::PARAM_STR);
		$stmt ->bindValue(':twitter',$b->gettwitter(),PDO::PARAM_STR);
		$stmt ->bindValue(':site',$b->getsite(),PDO::PARAM_STR);
		$stmt ->bindValue(':image',$b->getimage(),PDO::PARAM_STR);
        $t=$stmt->execute();
        if ($t) {
        	return $this->connexion->lastInsertId();
        }
	}

	public function hydrate($stmt){
		$tab=[];
		while($setup = $stmt->fetch(PDO::FETCH_ASSOC)){
			$tab[$setup['id']]=new Club($setup['sport'],$setup['club'],$setup['twitter'],$setup['site'],$setup['image']);
		}
		return $tab;
	}

	

	public function delete($id){
		$rq = "DELETE FROM club WHERE id= :id";
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
	
	public function getUser($id){
		$rq = "SELECT * FROM club WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
		$stmt->execute($data);
		$rs;
		if($setup = $stmt->fetch(PDO::FETCH_ASSOC)){
			$rs=$setup['user'];
		}
		return $rs;
	}

	public function update($id, club $b){
		$rq = "UPDATE club SET sport= :sport, club= :club, twitter= :twitter, site= :site WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$stmt ->bindValue(':sport',$b->get_type(),PDO::PARAM_STR);
		$stmt ->bindValue(':club',$b->getnbpieces(),PDO::PARAM_STR);
		$stmt ->bindValue(':twitter',$b->getsurface(),PDO::PARAM_STR);
		$stmt ->bindValue(':site',$b->getPrix(),PDO::PARAM_STR);
		$stmt ->bindValue(':id',$id,PDO::PARAM_STR);
        if ($stmt->execute()) {
        	return true;
        }else{
        	return false;
        }
	}

}

 ?>