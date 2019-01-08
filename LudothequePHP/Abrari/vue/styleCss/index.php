
<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="test.css" />
<!--<link type="text/css" rel="stylesheet" href="stylesheet.css" />-->
<meta charset="utf-8" />
<title>Test</title>
</head>
<body>


	<div id="header">

		<div id="navbar">
			<ul>
				<li>Accueil</li>
				<li>LoginAdmin</li>
				<li>LoginAdherent</li>
				<li>Contact</li>
			</ul>

		</div>
		<h2>
			<p>
				<font size="10" face="georgia" color="black">
					<h1 align="center">
						<strong> Ludotheque</strong>
					</h1>
				</font>
			</p>
		</h2>
	</div>
	<!-- <p align="right">	
	<form action="Test.php" method="POST">
		<label for="field_1"> Recherche </label> <input type="text"
			name="texte" value="Tapez du texte" /> <input type="submit"
			value="Envoyer" />
	</form>
	</p> -->
	<!-- <div id="left">
		<div id="f1">
			<p align="center">
				<font size="3" face="georgia" color="red"> <span class="bold"></span></font>
			</p>
		</div> -->
	
	</div>
	<div id="right">
		<div>

			<form action="Test.php" method="post">
				<p>
					Rechercher : <input type="text" name="nom" />
				</p>
				<!--<p>Votre age : <input type="text" name="age" /></p>-->
				<p>
					<input type="submit" value="OK">
				</p>
			</form>
		</div>
		<?php
//On gère les include dès le début du programme
include ("../bdd/ConnexionLudotheque.php");
include ("../bdd/DaoLudotheque.php");

// Affichage des tables


// Affichage d'une colonne particulier



//    test read / create sur Pilote avec récupération de la clé générée Connexion::getInstance()->lastInsertId();
/*
$adherent=$daoaAdherent->read(1);
echo " : $adherent";
$adherent->setNomAdherent("A");
$daoadherent->create($adherent);
$adherent=$daoadherent->read($adherent->getNumPil());
echo "nouveau adherent : $adherent";
*/


?>
		
	</div>
	<div id="footer">
		<div id="button">
			<p>
				<span class="bold">S'abonner</span>!
			</p>
		</div>
		<p>
	
	
	<blockquote id="couleur">
		<p align="right" > date du jour <?php echo date('d-m-y'); ?></p>
	</blockquote>
	</p>
		
	</div>
</body>
</html>







 