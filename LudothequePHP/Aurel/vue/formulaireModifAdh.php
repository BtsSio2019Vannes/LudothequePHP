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
	<?php print $_POST['personne'];?>
	<div class="fenetreFormulaire">
	
		<form class="formulaireModif" method="post" action="../controleur/adherent/gestionAdh.php">
		<?php $personne= $_POST['personne'];?>
			<table>
				<tr>
					<td>Nom:</td>
					<td><input type="text" name="nom" value="<?php echo $personne->getNom()?>"/></td>
				</tr>
			
				<tr>
					<td>Prénom:</td>
					<td><input type="text" name="prenom" value="<?php echo $personne->getPrenom()?>"/></td>
				</tr>
			
				<tr>
					<td>Date de Naissance:</td>
					<td><input type="text" name="dateNaissance" value="<?php echo $personne->getDateNaissance()?>" /></td>
				</tr>
				
				<tr>
					<td>Rue:</td>
					<td><input type="text" name="rue" value="<?php $coordonnees->getRue()?>"/></td>
					<td>Code Postal:</td>
					<td><input type="text" name="codePostal" value="<?php $coordonnees->getCodePostal()?>"/></td>
					<td>Ville:</td>
					<td><input type="text" name="ville" value="<?php $coordonnees->getVille()?>"/></td>
				</tr>
				
				<tr>
					<td>Mel:</td>
					<td><input type="text" name="mel" value="<?php echo $personne->getMel()?>"/></td>
				</tr>
				
				<tr>
					<td>Numéro de Téléphone:</td>
					<td><input type="text" name="numTel" value="<?php echo $personne->getNumeroTelephone()?>"/></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" name="modifier">Mettre à jour</button></td>
					<td colspan="2"><button type="submit" name="supprimer">Supprimer</button></td>
				</tr>				
			</table>
		</form>

	</div>

	<div class="gestionBouton">
		<form action="adherent.php">
			<button type="submit" name="Retour" style="width: 150px; height: 50px">Retour</button>
		</form>

	</div>
</body>

</html>

