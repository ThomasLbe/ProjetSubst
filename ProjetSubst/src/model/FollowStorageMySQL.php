<?php 
/**
 * 
 */
 
class FollowStorageMySQL implements FollowStorage {
	
	public $connexion;
	
	function __construct($connexion){
		$this->connexion=$connexion;		
	}

	public function read($id){
		$rq = "SELECT * FROM follow WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':id' => $id,
        );
		$stmt->execute($data);
		return $this->hydrate($stmt);
	}

	public function existsFollow($id){
		$rq = "SELECT * FROM follow WHERE id= :id";
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
		$rq = "SELECT * FROM follow";
		$stmt = $this->connexion->prepare($rq);
		$stmt->execute();
        return $this->hydrate($stmt);
	}
	
	public function readByUser($user){
		$rq = "SELECT * FROM club WHERE id IN (SELECT club FROM follow WHERE user=:user)";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':user' => $user,
        );
		$stmt->execute($data);
		return $this->hydrateclub($stmt);
	}
	
	public function hydrateclub($stmt){
		$tab=[];
		while($setup = $stmt->fetch(PDO::FETCH_ASSOC)){
			$tab[$setup['id']]=new Club($setup['sport'],$setup['club'],$setup['twitter'],$setup['site'],$setup['image']);
		}
		return $tab;
	}

	public function suivre($id,$user){
		$rq = "INSERT INTO follow (user,club) VALUES (:user,:club)";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':user' => $user,
         ':club' => $id,
        );
        $stmt->execute($data);
        return $this->connexion->lastInsertId();
        
	}
	
	public function unfollow($id,$user){
		$rq = "DELETE FROM follow WHERE user=:user AND club=:club";
		$stmt = $this->connexion->prepare($rq);
		$data = array(
         ':user' => $user,
         ':club' => $id,
        );
        $stmt->execute($data);
        return $this->connexion->lastInsertId();
        
	}

	public function hydrate($stmt){
		$tab=[];
		$i=1;
		while($setup = $stmt->fetch(PDO::FETCH_ASSOC)){
			$tab[$i]=new Follow($setup['user'],$setup['club']);
			$i=$i+1;
		}
		return $tab;
	}
	
	

	

	public function delete($id){
		$rq = "DELETE FROM follow WHERE id= :id";
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

	public function update($id, Follow $b){
		$rq = "UPDATE follow SET user= :user, club= :club WHERE id= :id";
		$stmt = $this->connexion->prepare($rq);
		$stmt ->bindValue(':user',$b->get_type(),PDO::PARAM_STR);
		$stmt ->bindValue(':club',$b->getnbpieces(),PDO::PARAM_STR);
		$stmt ->bindValue(':id',$id,PDO::PARAM_STR);
        if ($stmt->execute()) {
        	return true;
        }else{
        	return false;
        }
	}

}

 ?>