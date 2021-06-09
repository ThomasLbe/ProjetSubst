<?php 
/**
 * 
 */
class View {
	
	
	
	private $title;
	private $content;
	private $router;
	private $feedback;
	
	function __construct($router,$feedback){
		$this->router=$router;
		$this->feedback=$feedback;
	}

	public function render(){
			echo "<!DOCTYPE html>
				<html>
				<head>
				<meta charset='UTF-8' />
				<meta http-equiv='X-UA-Compatible' content='IE=edge'>
				<meta name='viewport' content='width=device-width, initial-scale=1'>
               <!-- Bootstrap Core CSS -->
				<link href='src/skin/bootstrap.min.css' rel='stylesheet'>

				<!-- Custom CSS -->
				<link href='src/skin/business-casual.css' rel='stylesheet'>

				<!-- Fonts -->
				<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
				<link href='https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>
              	<title> Mes équipes </title>
              </head>
              <body>
               ".$this->navBar()." 
              ".$this->feedb()."
              <div class='brand'>".$this->title."</div>
              <p> ".$this->content." </p>
			  
              </body>
			  
              </html>";
		
		
	}

	public function feedb(){
		if ($this->feedback!=='') {
			return "<p class='feedback'> ".$this->feedback." </p>";
		}
		return "";
	}

	public function navBar(){
		
		$string='
		<nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">';
		
		if (isset($_SESSION['user'])) {
			if ($_SESSION['user']->getStatut()=='admin') { //SI UN COMPTE ADMIN EST CONNECTE
				$string.= "
					<li>
						<a href='".$this->router->getAccueilPage()."'>Clubs</a>
                    </li>
                    <li>
                        <a href='".$this->router->getClubCreationURL()."'>Suggerer une équipe</a>
                    </li>
					<li>
                        <a href='".$this->router->getGestionComptes()."'>Gestion</a>
                    </li>
					 <li>
                        <a href='".$this->router->DeconnexionURL()."'>Deconnexion </a>
                    </li>";
			
			}else{
				$string.= "
					<li>
						<a href='".$this->router->getAccueilPage()."'> Clubs </a>
					</li> 
					<li>
						<a href='".$this->router->getClubCreationURL()."'> Suggerer une équipe </a>
					</li>  
					<li>
						<a href='".$this->router->getMyList()."'>Mes équipes</a>
					</li>  
					<li>
						<a href='".$this->router->DeconnexionURL()."'> Deconnexion </a>
					</li>";
			}
		}else{
			$string.= " 
				<li>
					<a href='".$this->router->getAccueilPage()."'> Liste des clubs </a>
				</li> 
				<li>
					<a href='".$this->router->getLoginURL()."'> Connexion </a>
				</li>";
		}
			$string.="</ul></div></div></nav>";
		return $string;
	}
	
	
	

	public function makeClubPage(Club $Club,$id){ //AFFICHAGE DETAILS DU CLUB
		$this->title=$Club->getclub()." ";
		$string="<div class ='text-center'><a class='btn btn-default btn-lg' href='".$Club->getsite()."'>Site internet </a></div>";
		
		$string.="<hr><h2 class='intro-text text-center' ><strong>Twitter du club</strong></h2><hr>";
		$string.="<h1><div class ='text-center'><a class='twitter-timeline' data-lang='fr' data-width='600' data-height='700' href='https://twitter.com/".$Club->gettwitter()."?ref_src=twsrc%5Etfw'></a> <script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script></h1></div>";
		
		/*
				///////////////////// NE FONCTIONE PAS SUR LE SERVEUR  //////////////////
		
		$string.="<hr><h3 class='text-center'><a href='".$this->router->getArticleRMC($id)."'>Articles RMC</a> | <a href='".$this->router->getArticleEquipe($id)."'>Articles L'Equipe</a></h3><hr>";
		
		$rssequipe = "https://rmcsport.bfmtv.com/rss/football/"; //ON RECUPERE LE LIEN RSS DE RMC
		$rssrmc = "https://www6.lequipe.fr/rss/actu_rss_Football.xml"; //ON RECUPERE LE LIEN RSS DE RMC
		
		if(!isset($_GET['action'])){$_GET['action']="RMC";}
		
		switch($_GET['action']){
			case 'RMC':
				$rss_load = simplexml_load_file($rssrmc); //ON RECUPERE LE XML RMC
				$journal="RMC";
				break;
			
			case 'lequipe':
				$rss_load = simplexml_load_file($rssequipe); //ON RECUPERE LE XML RMC
				$journal="L'équipe";
				break;
				
			
		}
		
		$article=0;
		$string.="<hr><h2 class='intro-text text-center' >Articles <strong>".$journal."</strong></h2><hr>";
		foreach ($rss_load->channel->item as $item) {
			
			$nomclub=strtolower($Club->getclub());
			if(strpos($item->link,$nomclub)){ //ON VERIFIE SI ON A UN ARTICLE DU CLUB, TEST SUR LE LIEN CAR ERREUR SUR LE TITRE
				$image=$item->enclosure['url'];
				$article=1; //COMPTEUR POUR SAVOIR SI ON A AU MOINS 1 ARTICLE
				$string.= '<div class="col-sm-4 text-center">
							<h5 class="intro-text "><strong>'.$item->title.' </strong></h5>
							<img width="350" height="200" src="'.$image.'"><br>
							<a class="btn btn-default btn-lg" href="'.$item->link.'">Article </a><hr></div>';
			}
            
          }
		  if($article==0){
			  $string.="<h3 class='text-center'> Aucun article. </h3>";
		  }
		  */
		
		$this->content=$string;
	}
	
	
	public function makeValidationPage($tab){ //Affichage des comptes utilisateur et club a vérifier pour l'admin
		$this->title="Liste des comptes";
		
		$test=$_GET['action']; //Recupere si on affiche liste des club ou liste des comptes
		
		$this->title= ($test=="gestion")? "Liste des comptes" : "Liste des clubs";
		
		$string="<hr><h3 class='text-center'><a href='".$this->router->getGestionClub()."'>Club a valider</a> | <a href='".$this->router->getGestionComptes()."'>Liste des comptes</a></h3><hr>";
		if (empty($tab)) {
			$string.="<div>";
			$string.= ($test=="gestion")?"<div class='text-center'><h3> Aucun compte. </h3></div>":"<div class='text-center'><h3> Aucun club a valider. </h3></div>"; //Gestion = on affiche les comptes sinon les clubs
			$string.='</div>';
			
		}else{
			$i=1;
		    foreach ($tab as $key => $value) {
		    	$tab[$i]=$value;
				
				$id[$i]=$key;
				$i++;
			}
			$nbresultats=$i-1;		
			$c=1;
			
			$string.= ($test=="gestion")? '<div class="text-center"><h3>'.$nbresultats.' comptes inscrits</h"></div>':'<div class="text-center"><h3>'.$nbresultats.' club en attente</h3></div>';
			
			
			
			while($c<=$nbresultats){
				
				if($test=="gestionclub"){
					$string.= '<div class="col-sm-4 text-center">
								<h5 class="intro-text "><strong>'.$tab[$c]->getclub().' </strong></h5>
								<img  src="'.$tab[$c]->getimage().'" width="200" height="150" alt="">
								<h5 class="intro-text "><strong>Catégorie : '.$tab[$c]->get_sport().' </strong></h5>';
					$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getClubDeletionURL($id[$c]).'">Supprimer </a>';			
					$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getValideClubURL($id[$c]).'">Valider </a>';			
					$string.='</div>';	
				}					
							
				if($test=="gestion"){
					$string.= '<div class="col-sm-4 text-center">
								<h5 class="intro-text ">Nom :<strong>'.$tab[$c]->getnom().' </strong></h5>
								<h5 class="intro-text ">Login :<strong>'.$tab[$c]->getlogin().' </strong></h5>';
								$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getCompteDeletionURL($tab[$c]->getlogin()).'">Supprimer </a>';			
					$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getPromCompteURL($tab[$c]->getlogin()).'">Promouvoir </a>';			
					$string.='</div>';
								
				}
				$c++;	
			}
			
		}
		$this->content=$string;
	}

	function makeAccueilPage(){
		$this->title='Page d accueil';
		$this->content='<a href='.$this->router->getListURL().'> liste des Club </a>';
	}
	
	public function makeUnknownClubPage(){
		$this->title='Page inconnue';
		$this->content='page inconnue';
	}

	public function makeNonPage(){
		$this->title='Accès interdit';
		$this->content="<p id='ai'> Accès interdit, veuillez vous connecter </p>";
	}

	public function makeDeniedPage(){
		$this->title='Accès interdit';
		$this->content="<p id='ai'> Vous n'etes pas autorisé(e) a effectuer cette tâche. </p>";
	}
	
	
	
	//AFFICHAGE EN EN LIGNE DE 2 ITEM
	public function makeListPage($tabClubs){ //Affichage de la liste de tous les Club		
		$string="<hr><h2 class='intro-text text-center' >Liste des <strong>clubs</strong></h2><hr>
		
				<br><form method='post' class='text-center' action='".$this->router->getSearchURL()."''>
					<div class='search'> 
						Rechercher un club : <input type='text' name='club' >
						<input type='submit' value='Rechercher'> <br>
						</div>
				</form><br>";
		
			
		if (empty($tabClubs)) {
			
			$string.="<br><br><br><h3 class='text-center'> Aucun club. </h3>";
			
		}else{			
			
			$i=1;
			$c=1;
			$cat=[];
		    foreach ($tabClubs as $key => $value) {
				
				if(!in_array($value->get_sport(), $cat)){ //ON RECUPERE LA LISTE DES DIFFERENTS SPORTS
					$cat[$c]=$value->get_sport();
					$c++;
				}
				
				if(isset($_POST['categorie']) && $_POST['categorie']!='tous'){
					if( $value->get_sport()==$_POST['categorie']){
					$tab[$i]=$value;
					$idClub[$i]=$key;
					$i++;
					}
					
				}else{
					$tab[$i]=$value;
					$idClub[$i]=$key;
					$i++;
				}
				
				
			}
			$nbresultats=$i-1;
			 //LISTE DEROULANTE CATEGORIE SPORT
			$string.="<form method='POST' class='text-center' action='".$this->router->getListURL()."'>";
			$string.="Choisir un sport:</label>";
				$string.="<select name='categorie' id='categorie'>";
					$string.="<option value='tous'>Afficher tous</option>";
					foreach ((array)$cat as $sport) {		
						$string.="<option value='".$sport."'>".$sport."</option>";
					}		
					
				$string.="</select>";
				$string.="<input type='submit'/>";
			$string.="</form><br><br>";
			
			$c=1;
			while($c<=$nbresultats){
				
				$string.= '<div class="col-sm-4 text-center">
							<h5 class="intro-text "><strong>'.$tab[$c]->getclub().' </strong></h5>
							<img  src="'.$tab[$c]->getimage().'" width="200" height="150" alt="">
							<h5 class="intro-text "><strong>Catégorie : '.$tab[$c]->get_sport().' </strong></h5>';
				if (isset($_SESSION['user'])) { //SI ON EST CONNECTER ON AFFICHE LE BOUTON DETAILS
					$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getClubURL($idClub[$c]).'">Details </a>';
					if ($_SESSION['user']->getStatut()=='admin') {//SI ON EST CONNECTER EN ADMIN BOUTON SUPPRIMER
						$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getClubDeletionURL($idClub[$c]).'">Supprimer </a>';
					}else{ //SI ON EST PAS ADMIN BOUTON SUIVRE
						$string.='<a class="btn btn-default btn-lg" href="'.$this->router->getSuivreURL($idClub[$c]).'">Suivre </a>';
					}
				}
				$string.='</div>';
				$c++;
				
			}
			
		}
		$this->content=$string;
	}
	
	public function makeMyListPage($tabClubs){ //Affichage de la liste des Club suivi par une personne
		$string="<hr><h2 class='intro-text text-center' >Liste des <strong>clubs suivi</strong></h2><hr>";
			
		if (empty($tabClubs)) {
			
			$string.="<br><br><br><h3 class='text-center'> Aucun club suivi. </h3>";
			
		}else{			
			
			$i=1;
		    foreach ($tabClubs as $key => $value) {
		    	$tab[$i]=$value;
				$idClub[$i]=$key;
				$i++;
			}
			$nbresultats=$i-1;
	       
			$c=1;
			
			
			
			while($c<=$nbresultats){
				
				$string.= '<div class="col-sm-4 text-center">
							<h5 class="intro-text "><strong>'.$tab[$c]->getclub().' </strong></h5>
							<img  src="'.$tab[$c]->getimage().'" width="200" height="150" alt="">
							<h5 class="intro-text "><strong>Catégorie : '.$tab[$c]->get_sport().' </strong></h5>
							<a class="btn btn-default btn-lg" href="'.$this->router->getClubURL($idClub[$c]).'">Details </a>
							<a class="btn btn-default btn-lg" href="'.$this->router->getUnfollowURL($idClub[$c]).'">Unfollow </a>';
				$string.='</div>';
				$c++;
			}
			
		}
		$this->content=$string;
	}
	
	public function makeClubCreationPage(ClubBuilder $ClubBuilder){
	    $data=$ClubBuilder->getData();
		$erreur=$ClubBuilder->getError();
		$sportE=''; $clubE=''; $twitterE=''; $siteE='';$imageE='';
		if ($data===null) {
			$sport=''; $club=''; $twitter=''; $site='';$image='';
		}else{
			$sport=key_exists('sport', $data) ? $data['sport'] : ''; 
			$club=key_exists('club', $data) ? $data['club'] :'';
			$twitter=key_exists('twitter', $data) ? $data['twitter'] : '';
			$site=key_exists('site', $data) ? $data['site'] :'';
			$image=key_exists('image', $data) ? $data['image'] :'';
			
			$sportE=key_exists('sport', $erreur) ? $erreur['sport'] : ''; 
			$clubE=key_exists('club', $erreur) ? $erreur['club'] :'';
			$twitterE=key_exists('twitter', $erreur) ? $erreur['twitter'] : '';
			$siteE=key_exists('site', $erreur) ? $erreur['site'] :'';
			$imageE=key_exists('image', $erreur) ? $erreur['image'] :'';
		}
		$string="<hr><h2 class='intro-text text-center' >Ajjout d'un <strong>club</strong></h2><hr>";
		
		
		$string.="<form method='post' id='lg-form' name='lg-form' enctype='multipart/form-data'  action='".$this->router->getClubSaveURL()."'>";
		
					$string.="<div class='form-group col-lg-4'>";
						$string.="<label for='sport'>Sport :</label>";
						$string.="<input type='text' name='sport' class='form-control' placeholder='Sport' value=".$sport.">".$sportE;
					$string.="</div>";
					
					$string.="<div class='form-group col-lg-4'>";
						$string.="<label for='club'>Club :</label>";
						$string.="<input type='text' name='club' class='form-control' placeholder='Club' value=".$club.">".$clubE;
					$string.="</div>";
					
					$string.="<div class='form-group col-lg-4'>";
						$string.="<label for='twitter'>Compte Twitter :</label>";
						$string.="<input type='text' name='twitter' class='form-control' placeholder='Twitter' value=".$twitter.">".$twitterE;
					$string.="</div>";
					
					$string.="<div class='form-group col-lg-4'>";
						$string.="<label for='site'>Site internet :</label>";
						$string.="<input type='text' name='site' class='form-control' placeholder='Site internet' value=".$site.">".$siteE;
					$string.="</div>";
					
					$string.="<div class='form-group col-lg-4'>";
						$string.="<label for='image'>Image :</label>";
						$string.="<input type='file' name='image' class='form-control' value=".$image.">".$imageE;
					$string.="</div>";
					
					$string.="<div class=' col-lg-12 text-center'>";
						$string.="<input class='btn btn-default btn-lg' type='submit' value='Valider'> <br>";
					$string.="</div>";
		$string.="</form>";
		$this->content=$string;
	}

	

	public function makeDebugPage($variable) {
	$this->title = 'Debug';
	$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function makeCompteCreatedPage(){
    	$this->router->POSTredirect($this->router->getLoginURL(), "Le compte a bien été crée !");
    }

    public function makeClubCreatedPage($id) {
		$this->router->POSTredirect($this->router->getListURL(), "Le club a bien été créé !");
	}

	public function makeClubNotCreatedPage() {
		$this->router->POSTredirect($this->router->getClubCreationURL(), "Erreur lors de la saisie !");
	}

	public function alreadyExistCompte(){
		$this->router->POSTredirect($this->router->getInscriptionURL(), "Le login est dèja utilisé, veuillez essayer autre chose !");
	}

	public function makeNotCreatedPage() {
		$this->router->POSTredirect($this->router->getInscriptionURL(), "Erreur lors de la saisie !");
	}

	public function makeClubDeletedPage() {
		$this->router->POSTredirect($this->router->getListURL(), "Le club a bien été supprimé");
	}
	
	public function makeCompteDeletedPage() {
		$this->router->POSTredirect($this->router->getListURL(), "L'utilisateur a bien été supprimée");
	}
	
	public function makeComptePromPage() {
		$this->router->POSTredirect($this->router->getListURL(), "L'utilisateur est maintenant un admin");
	}

	public function makeUserConnectedPage() {
		$this->router->POSTredirect($this->router->getListURL(), "Bonjour, ".$_SESSION['user']->getnom());
	}

	public function makeUserNotConnectedPage() {
		$this->router->POSTredirect($this->router->getLoginURL(), "Tentative de connexion echoué !");
	}

	public function makeDeconnexionPage() {
		$this->router->POSTredirect($this->router->getListURL(), "Deconnexion réussie !");
	}

	public function makeClubDeletionPage($id){
		$string="<form method='post' action='".$this->router->getClubDeletionURL($id)."''>";
		$string.="Etes vous sûr de vouloir supprimer ce club ?";
		$string.=" Oui ? <input type='radio' name='ouiNon' value='oui'> <br>";
		$string.=" Non ? <input type='radio' name='ouiNon' value='non'> <br>";
		$string.="<input type='submit' value='Confirmer'> <br>";
		$string.="</form>";
		$this->title="Supprimer?";
		$this->content=$string;
	}

	public function makeLoginFormPage(){
		$string="<hr><h2 class='intro-text text-center' ><strong>Connexion</strong></h2><hr>";
		$string.="<div class='col-lg-12 text-center'>";
		$string.="<form class='text-center'  id='lg-form' name='lg-form' method='post' action='".$this->router->getCheckURL()."'>";
				$string.="<div>";
					$string.="<label for='login'>Login :</label>";
					$string.="<input type='text' name='login' id='login' placeholder='Login'/>";
				$string.="</div>";
				
				$string.="<div>";
					$string.="<label for='password'>Mot de passe :</label>";
					$string.="<input type='password' name='pass' id='password' placeholder='Mot de passe' />";
				$string.="</div>";
				
			$string.="<br><button type='submit' id='login' name='valid' value='Valider' class='btn btn-default btn-lg'>Valider</button>";
			$string.=" <a href='".$this->router->getInscriptionURL()."' class='btn btn-default btn-lg'>Inscription</a>";
		$string.="</form>";
		$string.="<hr>";
		$string.="</div>";
		
		
		$this->content=$string;
	}

	public function makeInscriptionPageUser(CompteBuilder $CompteBuilder){
		$data=$CompteBuilder->getData();
		$erreur=$CompteBuilder->getError();
		$nom="";
		$login="";
		$nomE="";
		$loginE="";
		$passE="";
		if($data!==null){
		$nom=key_exists('nom', $data) ? $data['nom'] : '';
		$login=key_exists('login', $data) ? $data['login'] : '';
		$nomE=key_exists('nom', $erreur) ? $erreur['nom'] : ''; 
		$loginE=key_exists('login', $erreur) ? $erreur['login'] : ''; 
		$passE=key_exists('pass', $erreur) ? $erreur['pass'] : ''; 
		}
		
		$string="<hr><h2 class='intro-text text-center' ><strong>Inscription</strong></h2><hr>";
		
		$string.="<form  class='text-center'  id='lg-form' name='lg-form' method='post' action='".$this->router->getSaveUserURL()."'>";
		$string.="<label for='nom'>Nom :</label>";
		$string.="<input type='text' name='nom' placeholder='Nom' value='".$nom."'> ".$nomE." <br>";
		$string.="<label for='login'>Login :</label>";
		$string.="<input type='text' name='login' placeholder='Login' value='".$login."'> ".$loginE." <br>";
		$string.="<label for='password'>Mot de passe :</label>";
		$string.="<input type='password' placeholder='Mot de passe' name='pass'> ".$passE." <br>";
		$string.="<input type='submit' class='btn btn-default btn-lg' value='Valider'> <br>";
		$string.="</form>";
		$string.="<hr>";
		$this->content=$string;
	}


}

 ?>