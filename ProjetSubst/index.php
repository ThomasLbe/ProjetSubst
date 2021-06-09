<?php
set_include_path("./src");


require_once("Router.php");
$router = new Router();


$PARAM_hote="mysql.info.unicaen.fr"; // le chemin vers le serveur
$PARAM_port='3306';
$PARAM_nom_bd='21900371_3'; // le nom de votre base de données
$PARAM_utilisateur='21900371'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='aamooqueo5oFai9a'; // mot de passe de l'utilisateur pour se connecter
$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);




$CompteStorage=new CompteStorageMySQL($connexion);
$ClubStorage=new ClubStorageMySQL($connexion);
$FollowStorage=new FollowStorageMySQL($connexion);
$router->main($ClubStorage,$CompteStorage,$FollowStorage);
?>
