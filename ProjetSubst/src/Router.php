<?php 

/**
 * 
 */
require_once("view/View.php");
require_once("ctl/Controller.php");

require_once("model/Club.php");
require_once("model/ClubStorage.php");
require_once("model/ClubStorageMySQL.php");
require_once("model/ClubBuilder.php");

 require_once("model/CompteBuilder.php");
 require_once("model/Compte.php");
 require_once("model/CompteStorage.php");
 require_once("model/CompteManager.php");
 require_once("model/CompteStorageMySQL.php");
 
  require_once("model/FollowBuilder.php");
 require_once("model/Follow.php");
 require_once("model/FollowStorage.php");
 require_once("model/FollowStorageMySQL.php");

class Router {
	
	public function main($clubStorage,$CompteStorage,$FollowStorage){
		session_start();

		$feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
		$_SESSION['feedback'] = '';

		$login=key_exists('user', $_SESSION) ? $_SESSION['user'] : '';
		$view=new View($this,$feedback);
        $CompteManager= new CompteManager ($CompteStorage);
		$Controller=new Controller($view,$clubStorage,$CompteManager,$CompteStorage,$FollowStorage);



		$clubID = key_exists('club', $_GET) ? $_GET['club'] : null;
		$compteID = key_exists('compte', $_GET) ? $_GET['compte'] : null;
		$action = key_exists('action', $_GET) ? $_GET['action'] : null;
		

		if ($action === null) {
			$action = ($clubID === null) ? "accueil" : "voir";
		}


		try {
			switch ($action) {
				case 'voir':
					if ($clubID === null) {
				    } else {
				    	if (isset($_SESSION['user'])) {
				    		$Controller->showInformation($clubID);
				    	}else{
				    		$view->makeNonPage();
				    	}     
					     
				    }
					break;

				case 'nouveau':
					if (isset($_SESSION['user'])) {
						$Controller->newclub();
					}else{
						$view->makeNonPage();
					}
					break;

				case 'sauverNouveau':
				    if (isset($_SESSION['user'])) {
				        $Controller->saveNewclub($_POST);
				    }else{
				    	$view->makeNonPage();
				    }
					
					break;

				case 'login':
					$Controller->MakeLoginPage();
					break;

				case 'check':
					$Controller->checkConnection($_POST);
					break;

				case 'inscription':
					$Controller->newCompte();
					break;

				case 'Saveinscription':
					$Controller->saveNewCompte($_POST);
					break;

				case 'deconnexion':
				    if (isset($_SESSION['user'])) {
				    	$Controller->deconnexion();
				    }else{
				    	$view->makeNonPage();
				    }
					break;

				case 'mylist':
				    if (isset($_SESSION['user'])) {
				    	$Controller->showMylist($_SESSION['user']->getlogin());
				    }else{
				    	$view->makeNonPage();
				    }
					break;

				case 'accueil':
					$Controller->showList();
					break;
				
					
				case 'recherche':
					if ($_POST['club']!='') {
						$Controller->showListSearch($_POST['club']);
					}else{
						$Controller->showList();
					}
					break;

				case 'liste':
					$Controller->showList();
					break;
				
					
				case 'valideclub':
					$Controller->valideclub($clubID);
					break;
					
				case 'RMC':
					$Controller->showInformation($clubID);
					break;
					
				case 'lequipe':
					$Controller->showInformation($clubID);
					break;
					
				
					
				case 'gestion':
					$Controller->showListCompte();
					break;
					
				case 'suivre';
					$Controller->SuivreClub($clubID);
					break;
					
				case 'unfollow';
					$Controller->UnfollowClub($clubID);
					break;
					
				case 'gestionclub':
					$Controller->showClubValide();
					break;

				case 'edit':
					if ($clubID===null) {
					}else{
						$Controller->modifierclub($clubID);
					}
					break;

				case 'saveEdit':
					if ($clubID===null) {
					}else{
						$Controller->EditNewclub($_POST,$clubID);
					}
					break;

				case 'askDelete':
					if ($clubID===null) {
						//
					}else{
						$Controller->askclubDeletion($clubID);
					}
					break;

				case 'delete':
					if ($clubID===null) {
					}else{
						$Controller->deleteclub($clubID);
					}
					break;
					
				case 'delcompte':
					$Controller->deleteCompte($compteID);
					break;
				
				case 'promcompte':
					$Controller->promCompte($compteID);
					break;
				
				default:
					$view->makeUnknownclubPage();
					break;
			}
			
		} catch (Exception $e) {
			$view->makeUnexpectedErrorPage($e);
		}
        


		
		

		$view->render();
		}
    

    public function getAccueilPage(){
    	return '.';
    }

	public function getclubURL($key){
		return '?club='.$key;
	}

	public function getListURL(){
		return '?action=liste';
	}
	
	
	
	public function getGestionComptes(){
		return '?action=gestion';
	}
	
	public function getValideClubURL($id){
		return '?action=valideclub&amp;club='.$id;
	}
	
	public function getGestionClub(){
		return '?action=gestionclub';
	}
	
	public function getArticleRMC($id){
		return '?action=RMC&amp;club='.$id;
	}
	
	public function getArticleEquipe($id){
		return '?action=lequipe&amp;club='.$id;
	}
	
	public function getAProposURL(){
		return '?action=apropos';
	}
	
	public function getclubCreationURL(){
		return '?action=nouveau';
	}
	
	public function getSearchURL(){
		return '?action=recherche';
	}

	public function getclubSaveURL(){
		return '?action=sauverNouveau';
	}

	public function POSTredirect($url, $feedback){
		$_SESSION['feedback'] = $feedback;
		header("Location: ".htmlspecialchars_decode($url), true, 303);
		die;
	}

	public function getclubAskDeletionURL($id){
		return '?action=askDelete&amp;club='.$id;
	}

	public function getclubDeletionURL($id){
		return '?action=delete&amp;club='.$id;
	}
	
	public function getSuivreURL($id){
		return '?action=suivre&amp;club='.$id;
	}
	
	public function getUnfollowURL($id){
		return '?action=unfollow&amp;club='.$id;
	}
	
	public function getCompteDeletionURL($id){
		return '?action=delcompte&amp;compte='.$id;
	}
	
	public function getPromCompteURL($id){
		return '?action=promcompte&amp;compte='.$id;
	}

	public function getclubEditURL($id){
		return '?action=edit&amp;club='.$id;
	}

	public function getclubSaveEditURL($id){
		return '?action=saveEdit&amp;club='.$id;
	}

	public function getLoginURL(){
		return '?action=login';
	}

	public function getCheckURL(){
		return '?action=check';
	}

	public function getInscriptionURL(){
		return '?action=inscription';
	}

	public function getSaveUserURL(){
		return '?action=Saveinscription';
	}

	public function DeconnexionURL(){
		return '?action=deconnexion';
	}

	public function getMyList(){
		return '?action=mylist';
	}
		
	}

 ?>