<?php 
/**
 * 
 */
class Controller {

	private $view;
	private $data;
	private $ClubStorage;
	public $currentClubBuilder;
	public $modifiedClubBuilders;
    public $CompteManager;
    public $currentCompteBuilder;
    public $CompteStorage;
    public $FollowStorage;
	
	function __construct($view,ClubStorage $ClubStorage,$CompteManager,$CompteStorage,$FollowStorage)
	{
		$this->view=$view;
		$this->data=$ClubStorage->readAll();
		$this->ClubStorage=$ClubStorage;
        $this->CompteManager=$CompteManager;
        $this->CompteStorage=$CompteStorage;
        $this->FollowStorage=$FollowStorage;
        $this->currentCompteBuilder= key_exists('currentCompteBuilder', $_SESSION) ? $_SESSION['currentCompteBuilder'] : null;
		$this->currentClubBuilder = key_exists('currentClubBuilder', $_SESSION) ? $_SESSION['currentClubBuilder'] : null;
		$this->modifiedClubBuilders = key_exists('modifiedClubBuilders', $_SESSION) ? $_SESSION['modifiedClubBuilders'] : array();
	}

	public function __destruct() {
		$_SESSION['currentClubBuilder'] = $this->currentClubBuilder;
		$_SESSION['modifiedClubBuilders'] = $this->modifiedClubBuilders;
        $_SESSION['currentCompteBuilder']= $this->currentCompteBuilder;
	}

	public function showInformation($id) {
		$bool=0;
		foreach ($this->data as $key => $value) {
			if ($key==$id) {
                

				$this->view->makeClubPage($value,$id);
				$bool=1;
			}
		}
		if ($bool===0) {
			$this->view->makeUnknownClubPage();
		}
        
    }

    public function showList(){
    	$this->view->makeListPage($this->data);
    }
	
	public function showListSearch($club){
    	$this->view->makeListPage($this->ClubStorage->search($club));
    }
	
	public function showListCompte(){
    	$this->view->makeValidationPage($this->CompteStorage->readAll());
    }
	
	public function showClubValide(){
    	$this->view->makeValidationPage($this->ClubStorage->readAllValide());
    }
	
	public function valideclub($id){
		$this->ClubStorage->valideclub($id);
    	$this->view->makeValidationPage($this->ClubStorage->readAllValide());
    }
	
	public function SuivreClub($id){
		$this->FollowStorage->suivre($id,$_SESSION['user']->getlogin());
		$this->view->makeListPage($this->data);
	}
	
	public function UnfollowClub($id){
		$this->FollowStorage->unfollow($id,$_SESSION['user']->getlogin());
		$follow=$this->FollowStorage->readByUser($_SESSION['user']->getlogin());
		$this->view->makeMyListPage($follow);
	}

    public function showMylist($user){
        $follow=$this->FollowStorage->readByUser($user);
        $this->view->makeMyListPage($follow);
    }

    public function newClub() {
		if ($this->currentClubBuilder === null) {
			$this->currentClubBuilder = new ClubBuilder(null);
		}
		$this->view->makeClubCreationPage($this->currentClubBuilder);
        
	}

    public function saveNewClub(array $data){
		$this->currentClubBuilder=new ClubBuilder($data);
        if ($this->currentClubBuilder->isValid()) {
			$Club=$this->currentClubBuilder->createClub();
			$id=$this->ClubStorage->create($Club);
			$this->currentClubBuilder = null;
        
			$this->view->makeClubCreatedPage($id);
		}else{
			$this->view->makeClubNotCreatedPage();
		}
    }

    public function EditNewClub(array $data,$id){
       
    if($this->ClubStorage->existsClub($id)){
            ////////////
            if ($this->ClubStorage->read($id)===null) {
            $this->view->makeUnknownClubPage();
        }else{
            $Builder=new ClubBuilder($data);
            if ($Builder->isValid()) {
                $Club=$Builder->createClub();
                $this->ClubStorage->update($id,$Club);
                 unset($this->modifiedClubBuilders[$id]);
                 $this->view->makeClubEditedPage($id);
            }else{
                $this->modifiedClubBuilders[$id] = $Builder;
                $this->view->makeClubNotEditedPage($id);
            }

        }

     }else{
        $this->view->makeDeniedPage();
     }
    }

    public function askClubDeletion($id){
        if($this->ClubStorage->existsClub($id,$_SESSION['user']->getlogin())){
            $Club=$this->ClubStorage->read($id);
        if ($Club) {
            $this->view->makeClubDeletionPage($id);
        }else{
            $this->view->makeUnknownClubPage();
        }

        }else{
            $this->view->makeDeniedPage();
        }
    }


    public function deleteClub($id){
        
        if ($this->ClubStorage->delete($id)) {
            $this->view->makeClubDeletedPage();
            }
        else{
            $this->view->makeDeniedPage();
        }
    }
	
	public function deleteCompte($id){
		if ($this->CompteStorage->delete($id)) {
            $this->view->makeCompteDeletedPage();
        }else{
            $this->view->makeDeniedPage();
        }
	}
	
	public function promCompte($id){
		if ($this->CompteStorage->prom($id)) {
            $this->view->makeComptePromPage();
        }else{
            $this->view->makeDeniedPage();
        }
	}

    public function transformData($data,$id){
    	$tab=[];
    	$Club=$data[$id];
        $tab['sport']=$Club->get_type();
        $tab['club']=$Club->getnbpieces();
        $tab['twitter']=$Club->getsurface();
        $tab['site']=$Club->getprix();
        return $tab;
    }

    public function MakeLoginPage(){
        $this->view->makeLoginFormPage();
    }
	
	

	
	
    public function checkConnection(array $data){
        $b=$this->CompteManager->connectUser($data['login'], $data['pass']);
        if ($b) {
            $this->view->makeUserConnectedPage();
        }else{
            $this->view->makeUserNotConnectedPage();
        }
    }

    public function newCompte(){

        if ($this->currentCompteBuilder === null) {
            $this->currentCompteBuilder = new CompteBuilder(null);
        }
        $this->view->makeInscriptionPageUser($this->currentCompteBuilder);
    }

    public function saveNewCompte(array $data){
        $this->currentCompteBuilder=new CompteBuilder($data);
        if($this->currentCompteBuilder->isValid()){
            if ($this->CompteStorage->exists($data['login'])) {
                $this->view->alreadyExistCompte();
            }else{
                //
                  $compte=$this->currentCompteBuilder->createCompte();
                  $id=$this->CompteStorage->create($compte);

                  $this->currentCompteBuilder = null;
        
                  $this->view->makeCompteCreatedPage();
                //
            }
        }else{
            $this->view->makeNotCreatedPage();
        }
        
    
    }

    public function deconnexion(){

            $this->CompteManager->disconnectUser();
        $this->view->makeDeconnexionPage();
    }











}
 ?>