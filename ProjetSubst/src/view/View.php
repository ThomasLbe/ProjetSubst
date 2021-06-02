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
               <link href='src/skin/s12.css' rel='stylesheet'>
              	<title> Mes équipes </title>
              </head>
              <body>
              <div id='navbar'> ".$this->navBar()." </div>
              ".$this->feedb()."
              <h1> ".$this->title." </h1>
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
		if (isset($_SESSION['user'])) {
			if ($_SESSION['user']->getStatut()=='admin') { //SI UN COMPTE ADMIN EST CONNECTE
	       	return " <img src='logo.png'> <a href='".$this->router->getAccueilPage()."'> Liste des clubs </a> <a href='".$this->router->getClubCreationURL()."'> Ajouter une équipe </a>  <a href='".$this->router->getMyList()."'> Mes équipes suivi </a> <a href='".$this->router->getGestionComptes()."'> Gestion  </a>  <a href='".$this->router->DeconnexionURL()."'> Deconnexion (".$_SESSION['user']->getlogin().") </a>";
			}
	       	return " <img src='logo.png'> <a href='".$this->router->getAccueilPage()."'> Liste des équipes </a> <a href='".$this->router->getClubCreationURL()."'> Ajouter une équipe </a>  <a href='".$this->router->getMyList()."'> Mes équipes suivi </a>  <a href='".$this->router->DeconnexionURL()."'> Deconnexion (".$_SESSION['user']->getlogin().") </a>";
	    }
		return " <img src='logo.png'> <a href='".$this->router->getAccueilPage()."'> Liste des clubs </a> <a href='".$this->router->getInscriptionURL()."'>"." Inscription </a> <a href='".$this->router->getLoginURL()."'> Connexion </a>";
	}

	public function makeClubPage(Club $Club,$id){
		$this->title=$Club->getclub()." ";
		$string="<div class='affClub'> ";
		$string.="<div class='affville'> Site internet du club : <a href=".$Club->getsite().">".$Club->getsite()."</a></div><br>";
		$string.="<h1><a class='twitter-timeline' data-lang='fr' data-width='600' data-height='700' href='https://twitter.com/".$Club->gettwitter()."?ref_src=twsrc%5Etfw'></a> <script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script></h1>";
		
		
		$string.="</div>";
		$this->content=$string;
	}
	
	public function makeClubValidePage($tabClub){ //Affichage des club en attente de validation par l'admin
		$this->title="Clubs a valider";
		$string="<h1><a href='".$this->router->getGestionClub()."'>Club a valider</a> | <a href='".$this->router->getGestionComptes()."'>Liste des comptes</a></h1>";
		if (empty($tabClub)) {
			$string.="<div>";
			$string.="<p id='ai'> Aucun club a validé. </p>";
			$string.='</div>';
			
		}else{
			$i=1;
		    foreach ($tabClub as $key => $value) {
		    	$tab[$i]=$value;
				
				$idclub[$i]=$key;
				$i++;
			}
			$nbresultats=$i-1;		
			$c=1;
			
			$string.='<h1>'.$nbresultats.' club en attente</h1>';
			$string.='<div class="ligne">';
			$string.='<p>Sport</p><p>Club</p>';
			$string.='</div>';
			
			
			while($c<=$nbresultats){
				$string.='<div class="ligneCompte">';
				$string.='<p>'.$tab[$c]->get_sport().'</p>';
				$string.='<p>'.$tab[$c]->getclub().'</p>';
				$string.="<form method='post' action='".$this->router->getClubDeletionURL($idclub[$c])."''>";
				$string.="Supprimer le club  ";
				$string.="<input type='submit' value='Supprimer'> <br>";
				$string.="</form>";
				$string.="<form method='post' action='".$this->router->getValideClubURL($idclub[$c])."''>";
				$string.="Valider le club  ";
				$string.="<input type='submit' value='Valider'> <br>";
				$string.="</form>";
				$string.="<br>";
				$string.="<br>";
				$string.='</div>';
				$c++;	
			}
			
		}
		$this->content=$string;
	}
	
	public function makeComptePage($tabCompte){ //Affichage des comptes utilisateur pour l'admin
		$this->title="Liste des comptes";
		$string="<h1><a href='".$this->router->getGestionClub()."'>Club a valider</a> | <a href='".$this->router->getGestionComptes()."'>Liste des comptes</a></h1>";
		if (empty($tabCompte)) {
			$string.="<div>";
			$string.="<p id='ai'> Aucun compte. </p>";
			$string.='</div>';
			
		}else{
			$i=1;
		    foreach ($tabCompte as $key => $value) {
		    	$tab[$i]=$value;
				
				$idcompte[$i]=$key;
				$i++;
			}
			$nbresultats=$i-1;		
			$c=1;
			
			$string.='<h1>'.$nbresultats.' comptes inscrits</h1>';
			$string.='<div class="ligne">';
			$string.='<p>Nom</p><p>Login</p>';
			$string.='</div>';
			
			
			while($c<=$nbresultats){
				$string.='<div class="ligneCompte">';
				$string.='<p>'.$tab[$c]->getnom().'</p>';
				$string.='<p>'.$tab[$c]->getlogin().'</p>';
				$string.="<form method='post' action='".$this->router->getCompteDeletionURL($tab[$c]->getlogin())."''>";
				$string.="Supprimer le compte  ";
				$string.="<input type='submit' value='Supprimer'> <br>";
				$string.="</form>";
				$string.="<form method='post' action='".$this->router->getPromCompteURL($tab[$c]->getlogin())."''>";
				$string.="Promouvoir le compte  ";
				$string.="<input type='submit' value='Pormouvoir'> <br>";
				$string.="</form>";
				$string.="<br>";
				$string.="<br>";
				$string.='</div>';
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
		
		$this->title='Club';
		
		$string="<form method='post' action='".$this->router->getSearchURL()."''>";
			$string.="<div class='search'> ";
			$string.="Rechercher un club : <input type='text' name='club' >";
			$string.="<input type='submit' value='Rechercher'> <br>";
			$string.="</div>";
		$string.="</form>";
		
			
		if (empty($tabClubs)) {
			
			$string.="<div>";
			$string.="<p id='ai'> Aucun club. </p>";
			$string.='</div>';
			
		}else{			
			
		    $string.="<div id='listeClub'>";
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
			$string.="<form method='POST' action='".$this->router->getListURL()."'>";
			$string.="Choisir un sport:</label>";
				$string.="<select name='categorie' id='categorie'>";
					$string.="<option value='tous'>Afficher tous</option>";
					foreach ((array)$cat as $sport) {		
						$string.="<option value='".$sport."'>".$sport."</option>";
					}		
					
				$string.="</select>";
				$string.="<input type='submit'/>";
			$string.="</form>";
			
			$c=1;
			while($c<=$nbresultats){
				$string.='<div class="ligne">';
				if (isset($_SESSION['user'])) { //SI ON EST CONNECTER ON AFFICHE LE BOUTON SUIVRE
					if ($_SESSION['user']->getStatut()=='admin') {
							$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().'  <br><img src="'.$tab[$c]->getimage().'"> </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a><a href="'.$this->router->getClubDeletionURL($idClub[$c]).'"> <button> Supprimer </button> </a> </p>';
						}else{
							$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().'  <br><img src="'.$tab[$c]->getimage().'"> </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a><a href="'.$this->router->getSuivreURL($idClub[$c]).'"> <button> Suivre </button> </a> </p>';
						}
				}else{
					$string.='<p>'.$tab[$c]->get_sport().'<b><br> '.$tab[$c]->getclub().'   <br><img src="'.$tab[$c]->getimage().'"> </b></p>';
				}
				$c++;
				if($c<=$nbresultats){ //Si on a un nombre d'annonces impaires 
					if (isset($_SESSION['user'])) { //SI ON EST CONNECTER ON AFFICHE LE BOUTON SUIVRE
					if ($_SESSION['user']->getStatut()=='admin') {
							$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().'    <br><img src="'.$tab[$c]->getimage().'">  </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a><a href="'.$this->router->getClubDeletionURL($idClub[$c]).'"> <button> Supprimer </button> </a> </p>';
						}else{
							$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().'   <br><img src="'.$tab[$c]->getimage().'"> </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a><a href="'.$this->router->getSuivreURL($idClub[$c]).'"> <button> Suivre </button> </a> </p>';
						}
				}else{
					$string.='<p>'.$tab[$c]->get_sport().'<b><br> '.$tab[$c]->getclub().'   <br><img src="'.$tab[$c]->getimage().'">  </b></p>';
				}
				}
				$c++;
				$string.='</div>';
			}
			$string.='</div>';
			
		}
		$this->content=$string;
	}
	
	public function makeMyListPage($tabClubs){ //Affichage de la liste des Club suivi par une personne
		$this->title='Club';	
		$string='';		
		if (empty($tabClubs)) {
			
			$string.="<div>";
			$string.="<p id='ai'> Aucun club suivi. </p>";
			$string.='</div>';
			
		}else{			
			
		    $string.="<div id='listeClub'>";
			$i=1;
		    foreach ($tabClubs as $key => $value) {
		    	$tab[$i]=$value;
				$idClub[$i]=$key;
				$i++;
			}
			$nbresultats=$i-1;
	       
			$c=1;
			
			
			
			while($c<=$nbresultats){
				$string.='<div class="ligne">';
				
				$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().'  <br><img src="'.$tab[$c]->getimage().'"> </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a> </p>';

				$c++;
				if($c<=$nbresultats){ //Si on a un nombre d'annonces impaires 
					$string.='<p>'.$tab[$c]->get_sport().'<b> '.$tab[$c]->getclub().' <br><img src="'.$tab[$c]->getimage().'"> </b><br><a href="'.$this->router->getClubURL($idClub[$c]).'"> <button> Détails </button> </a> </p>';
				}
				$c++;
				$string.='</div>';
			}
			$string.='</div>';
			
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
		$this->title="Ajout d'un club";
		$string="";
		$string.="<form method='post' class='addAnn' enctype='multipart/form-data'  action='".$this->router->getClubSaveURL()."'>";
		$string.="Sport : <input type='text' name='sport' value=".$sport."> ".$sportE." <br>";
		$string.="Nom du club : <input type='text' name='club' value=".$club."> ".$clubE." <br>";
		$string.="Compte Twitter : <input type='text' name='twitter' value=".$twitter."> ".$twitterE." <br>";
		$string.="Site internet : <input type='text' name='site' value=".$site."> ".$siteE." <br>";
		$string.="Image : <input type='file' name='image' value=".$image."> ".$imageE." <br>";
		$string.="<input type='submit' value='Valider'> <br>";
		$string.="</form>";
		$this->content=$string;
	}

	public function makeClubModificationPage(ClubBuilder $ClubBuilder,$id){
	    $data=$ClubBuilder->getData();
		$erreur=$ClubBuilder->getError();
		if ($data===null) {
			$sport=''; $club=''; $twitter=''; $site='';
		}else{
			$sport=key_exists('sport', $data) ? $data['sport'] : ''; 
			$club=key_exists('club', $data) ? $data['club'] :'';
			$twitter=key_exists('twitter', $data) ? $data['twitter'] : '';
			$site=key_exists('site', $data) ? $data['site'] :'';
			
			$sportE=key_exists('sport', $erreur) ? $erreur['sport'] : ''; 
			$clubE=key_exists('club', $erreur) ? $erreur['club'] :'';
			$twitterE=key_exists('twitter', $erreur) ? $erreur['twitter'] : '';
			$siteE=key_exists('site', $erreur) ? $erreur['site'] :'';
		}
		$this->title='Modification annonce';
		$string="";
		$string.="<form method='post' class='addClub' enctype='multipart/form-data' action='".$this->router->getClubSaveEditURL($id)."'>";
		$string.="Type : <input type='text' name='type' value=".$type."> ".$typeE." <br>";
		$string.="Nombre de pièces : <input type='number' name='nbpieces' value=".$nbpieces."> ".$nbpiecesE." <br>";
		$string.="Surface : <input type='number' name='surface' value=".$surface."> ".$surfaceE." <br>";
		$string.="Prix : <input type='number' name='prix' value=".$prix."> ".$prixE." <br>";
		$string.="<input type='submit' value='Modifier'> <br>";
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

	public function makeClubEditedPage($id) {
		$this->router->POSTredirect($this->router->getClubURL($id), "Le club a bien été modifié !");
	}

	public function makeClubNotEditedPage($id) {
		$this->router->POSTredirect($this->router->getClubEditURL($id), "Erreur lors de la saisie !");
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
		$string="<form id='login' method='post' action='".$this->router->getCheckURL()."'>";
		$string.="<div id='formLogin'>";
		$string.="<div id='user'> <p> Login </p> <input type='text' name='login'> </div>";
		$string.="<div id='mdpp'> <p> Mot de passe </p> <input type='password' name='pass'> </div>";
		$string.="</div>";
		$string.="<input id='conx' type='submit' value='Connexion'> <br>";
		$string.="</form>";
		$this->title="Login page";
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
		
		
		$string="<form  class='addAnn' method='post' action='".$this->router->getSaveUserURL()."'>";
		$string.="Nom : <input type='text' name='nom' value='".$nom."'> ".$nomE." <br>";
		$string.="Login : <input type='text' name='login' value='".$login."'> ".$loginE." <br>";
		$string.="Mot de passe : <input type='password' name='pass'> ".$passE." <br>";
		$string.="<input type='submit' class='addd' value='Valider'> <br>";
		$string.="</form>";
		$this->title="Inscription";
		$this->content=$string;
	}


}

 ?>