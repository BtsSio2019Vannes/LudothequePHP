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

	<div class="fenetreFormulaire">

		<form class="formulaireAjout" method="post" action="../controleur/adherent/gestionAdh.php">
			<table>
				<tr>
					<td>Nom:</td>
					<td><input type="text" name="nom" /></td>
				</tr>
			
				<tr>
					<td>Prénom:</td>
					<td><input type="text" name="prenom" /></td>
				</tr>
			
				<tr>
					<td>Date de Naissance:</td>
					<td><input type="text" name="dateNaissance" /></td>
				</tr>
				
				<tr>
					<td>rue:</td>
					<td><input type="text" name="rue" /></td>
					<td>Code Postal:</td>
					<td><input type="text" name="codePostal" /></td>
					<td>Ville:</td>
					<td><input type="text" name="ville" /></td>
				</tr>
								
				<tr>
					<td>Mel:</td>
					<td><input type="text" name="mel" /></td>
				</tr>
				
				<tr>
					<td>Numéro de Téléphone:</td>
					<td><input type="text" name="numTel" /></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" name="ajouter">Ajouter une Nouvelle Personne</button></td>
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

