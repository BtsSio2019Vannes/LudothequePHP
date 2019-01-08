<?php 
session_start();
?>

<!DOCTYPE html>
<html>

   <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
   		<title>Formulaire nouvelle personne</title>
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
        
        <div class="fenetreFormulaire" ;">
                        
            
            <form>
    		Nom:<input type="text" name="nom"/><br>  			
  			Prénom:<input type="text" name="prenom"/><br>
  			Date de Naissance:<input type="text" name="dateNaissance"/><br>
  			Adresse: <input type="text" name="adresse"/><br>
  			Mel: <input type="text" name="mel"/><br>
  			Numéro de Téléphone: <input type="text" name="numTel"/><br>
  			
  			<input type="submit" value="Submit">
  			<input type="reset">
    	</form>
            
    	</div>
    	  	
      
    </body>

</html>