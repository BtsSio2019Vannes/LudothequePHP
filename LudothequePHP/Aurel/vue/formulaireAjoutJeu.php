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

		<form class="formulaireAjout" method="post"
			action="../controleur/jeux/gestionJeu.php">
			<table>

				<tr>
					<td>Titre:</td>
					<td><input type="text" name="titre" /></td>
				</tr>

				<tr>
					<td>Auteur:</td>
					<td><input type="text" name="Auteur" /></td>
					<td>Année de Sortie:</td>
					<td><input type="text" name="anneeSortie" /></td>
				</tr>

				<tr>
					<td>Catégorie:</td>
					<td><input type="text" name="Auteur" /></td>
					<td>Univers:</td>
					<td><input type="text" name="anneeSortie" /></td>
				</tr>

				<tr>
					<td>Editeur:</td>
					<td><input type="text" name="Editeur" /></td>

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
					<td colspan="2"><button type="submit" name="ajouter">Ajouter un
							nouveau Jeu</button></td>
				</tr>
			</table>
		</form>

	</div>

	<div class="gestionBouton">
		<form action="jeux.php">
			<button type="submit" name="Retour"
				style="width: 150px; height: 50px">Retour</button>
		</form>

	</div>
</body>

</html>

