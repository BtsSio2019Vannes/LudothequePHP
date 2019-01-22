<?php
include '../dao/Dao.php';
?>
<html>
<head>
<title>Gestion Jeux</title>
<link rel="stylesheet" type="text/css" href="../vue/css/formulaire.css">
<meta charset="utf-8">
</head>
<body>
	<h1>Ajout D'un Jeu</h1>
	<nav>
		<ul>
			<a href="GestionAdherents.php"><img src="../vue/images/iconfinder_173_95790.png" title="Gestion des Personnes"></a>
			
			<a href="GestionJeux.php"><img src="../vue/images/iconfinder_chess_19227.png" title="Gestion des jeux"></a>
			
			<a href="GestionEmprunts.php"><img src="../vue/images/iconfinder_social__media__social_media__share__3259412.png" title="Gestion des emprunts"></a>
			
			<a href="GestionParametres.php"><img src="../vue/images/iconfinder_120_95711.png" title="Gestion Ludothèque"></a>
			
			<a href="../vue/formulaire.php"><img src="../vue/images/iconfinder_clipboard-document-office-form-application_3209374.png" title="Formulaire"></a>
			
			<a href="../vue/accueil.php"><img src="../vue/images/iconfinder_go-home_118770.png" title="Accueil"></a>
		</ul>

	</nav>
	<form action="../metier/GestionJeux.php" method="post" class="AjoutJeux">
		<table>
			<tr>
				<td>Id:</td>
				<td><input type="text" name="IdJeu"></td>
			</tr>
			<br>
			<tr>
				<td>IdRègle:</td>
				<td><input type="text" name="IdRègle"></td>
			</tr>
			<br>
			<tr>
				<td>Titre:</td>
				<td><input type="text" name="Titre Jeu"></td>
			</tr>
			<br>
			<tr>
				<td>Année de sortie:</td>
				<td><input type="datetime" name="Année sortie"></td>
			</tr>
			<tr>
				<td>Auteur:</td>
				<td><input type="text" name="Auteur"></td>
			</tr>
			<tr>
				<td>Id Editeur:</td>
				<td><input type="text" name="IdEditeur"></td>
			</tr>
			<tr>
				<td>Catégorie:</td>
				<td><input type="text" name="categorie"></td>
			</tr>
			<tr>
				<td>Univers:</td>
				<td><input type="text" name="univers"></td>
			</tr>
			<tr>
				<td>Contenu Initial:</td>
				<td><input type="text" name="contenu"></td>
			</tr>
			</form>
		
		</table>
		
		<form action="../metier/GestionJeux.php"></form>
		<div>
			<button type="submit" name="Ajouter Jeu">Valider</button>	
			<button type="submit" name="Retour">Retour</button>
		</div>
		
</body>
</html>