<?php 
/**
 * 
 */
class ClubBuilder {

	private $data;
	private $error=null;
	
	function __construct($data)
	{
		
		$this->data=$data;
		$this->error= array();
	}

	public function createClub(){
		$datetime = date("Y_m_d_H_i_s");
		if (move_uploaded_file($_FILES['image']['tmp_name'], "upload/".$datetime.".jpg")) {
		}
		return new Club(htmlspecialchars($this->data['sport']),htmlspecialchars($this->data['club']),htmlspecialchars($this->data['twitter']),htmlspecialchars($this->data['site']),"upload/".$datetime.'.jpg');
	}

	public function isValid(){
		$bool=1;
		if (empty($this->data)) {
			$this->error['sport']='Veuillez saisir un sport';
			$this->error['club']='Veuillez saisir le nom du club';
			$this->error['twitter']='Veuillez saisir le compte twitter';
			$this->error['site']='Veuillez saisir un site';
			$bool=0;
		}
		if ($this->data['sport']==="") {
			$this->error['sport']='Veuillez saisir un sport valide';
			$bool=0;
    	}if ($this->data['club']==="") {
			$this->error['club']='Veuillez saisir un nom de club valide';
			$bool=0;
    	}if ($this->data['twitter']==="") {
			$this->error['twitter']='Veuillez saisir un compte twitter valide';
			$bool=0;
    	}if ($this->data['site']==="") {
			$this->error['site']='Veuillez saisir un site valide';
			$bool=0;
    	
    	}if($_FILES['image']['name']===""){
            $this->error['image']='Veuillez saisir une image';
    		$bool=0;
    	}else {
    		$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
		    $detectedType = exif_imagetype($_FILES['image']['tmp_name']);
    		if (!in_array($detectedType, $allowedTypes)) {
    		$this->error['image']='Vous devez entrer une image au format JPEG ou PNG !';
    		$bool=0;
    	    }
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