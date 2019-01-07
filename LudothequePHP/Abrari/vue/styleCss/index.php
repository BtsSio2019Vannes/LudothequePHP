<html>
<head>
<link rel="stylesheet" media="screen" type="text/css"
	href="./css/ludotheque.css" />
<title>LUDOTHEQUE</title>
</head>

<body>


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

    </body>
</html>
