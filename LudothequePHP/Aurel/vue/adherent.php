<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="style.css">
<title>Ludothèque</title>
<link rel="shortcut icon" type="image/x-icon"
	href="../images/logo_ludo.jpg" />
</head>


<body>

	<div id="navigation">
		<ul style="list-style-type: none">

			<li class="personne"><a href="adherent.php"><img alt="Personne"
					src="../images/personne.png" style="width: 50px; height: 50px;"></br>Gérer
					les Adhérents</a></li>
			<li class="jeux"><a href="jeux.php"><img alt="Jeux"
					src="../images/jeu.png" style="width: 50px; height: 50px;"></br>Gérer
					les Jeux</a></li>
			<li class="emprunt"><a href="emprunts.php"><img alt="Emprunts"
					src="../images/emprunt.png" style="width: 50px; height: 50px;"></br>Gérer
					les Emprunts</a></li>
			<li class="setup"><a href="parametres.php"><img
					alt="Gestion Ludothèque" src="../images/setup.png"
					style="width: 50px; height: 50px;"></br>Gérer Ludothéque</a></li>
			<li class="home"><a href="index.php"><img alt="Accueil"
					src="../images/home.png" style="width: 50px; height: 50px;"></br>Accueil</a></li>
		</ul>
	</div>

	<div class="infoLudo">
		<h1>Betton Ludique</h1>

		<div class="fenetreInfo" style="overflow-y: scroll;">
			<form class="affichePersonne" method="post"
				action="formulaireModifAdh.php">
				<table style="width: 100%">
					<tr>
						<td colspan="7"></td>
						<td></td>
					</tr>

					<tr style="position: fixed">
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Date de Naissance</th>
						<!--<th>Coordonnées</th>-->
						<th>mél</th>
						<th>Numéro Téléphone</th>
						<th>Choix</th>
						<th><button type="submit" name="supprimer">Supprimer</button> <br />
							<button type="submit" name="maj">Mettre à Jour</button></th>
					</tr>


					<tr>
						<td colspan="7"></td>      
            <?php
            // On gère les include dès le début du programme
            // include ("../db/connexion.php");
            include ("../metier/adherent/adherents.php");
            include ("../db/Daos.php");

            $personnes = \DAO\Personne\PersonneDAO::getPersonnes();
            foreach ($personnes as $personne) {
                $rep = "<tr><td>" . $personne->getIdPersonne();
                $rep .= "</td><td>" . $personne->getNom();
                $rep .= "</td><td>" . $personne->getPrenom();
                $rep .= "</td><td>" . $personne->getDateNaissance();
                //$rep .= "</td><td>" . $personne->getCoordonnees();
                $rep .= "</td><td>" . $personne->getMel();
                $rep .= "</td><td>" . $personne->getNumeroTelephone();
                $rep .= "</td><td><input type=\"radio\" name=\"personne\" value=\"" . $personne->getIdPersonne() . "\"></td></tr>";

                echo $rep;
            }
            ?>
            <td></td>
				
				</table>
			</form>

		</div>
	</div>

	<div class="gestionBouton">
		<form action="formulaireAjoutAdh.php">
			<input type="submit" value="Ajouter Personne"
				style="width: 150px; height: 50px">
		</form>
	</div>


</body>

</html>