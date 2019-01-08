<?php 
session_start();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
   		<title>Ludothèque</title>
   		<link rel="shortcut icon" type="image/x-icon" href="../images/logo_ludo.jpg"/>
	</head>
    
    
    <body>
    
        <div id="navigation">
            <ul style="list-style-type:none">
            	
                <li class = "personne"><a href="adherent.php" ><img alt="Personne" src="../images/personne.png" style="width: 50px; height: 50px;"></br>Gérer les Adhérents</a></li>
                <li class ="jeux"><a href="jeux.php"><img alt="Jeux" src="../images/jeu.png" style="width: 50px; height: 50px;"></br>Gérer les Jeux</a></li>
                <li class ="emprunt"><a href="emprunts.php"><img alt="Emprunts" src="../images/emprunt.png" style="width: 50px; height: 50px;"></br>Gérer les Emprunts</a></li>
	            <li class ="setup"><a href="parametres.php"><img alt="Gestion Ludothèque" src="../images/setup.png" style="width: 50px; height: 50px;"></br>Gérer Ludothéque</a></li>
            	<li class ="home"><a href="index.php"><img alt="Accueil" src="../images/home.png" style="width: 50px; height: 50px;"></br>Accueil</a></li>
            </ul>
        </div>
  
        <div class= "infoLudo">
            <h1>Betton Ludique</h1>
            <div class="fenetreInfo" style="overflow:scroll;">
                        
            <?php
                //On gère les include dès le début du programme
                include ("../bd/Connexion.php");
                include ("../bd/Daos.php");
                // Affichage des pilots
                echo \DAO\Personne\PersonneDAO::getPersonne();?>
            </div>
    	</div>
    	
    	<div class="gestionBouton">
    	<form action ="\adherent2.php">
    	<input type="button" class="bouton" value="Ajouter Personne" style="width: 150px; height: 50px"></form>
    	<form action ="\adherent3.php">
    	<input type="button" class="bouton" value="Modifier Personne" style="width: 150px; height: 50px"></form>
    	<form action ="\formulaireAdh1.php">
    	<input type="button" class="bouton" value="Supprimer Personne" style="width: 150px; height: 50px"></form>
    	<form>
    	<input type="button" class="bouton" value="Rechercher Personne" style="width: 150px; height: 50px"></form>
    	</div>
    	
      
    </body>

</html>