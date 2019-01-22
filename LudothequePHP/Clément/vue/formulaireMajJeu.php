<?php

use Dao\Jeu\JeuDAO;

?>
<!DOCTYPE html>

<html>
<head>
<title>Mise à jour Jeu</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../vue/css/formulaire.css">
</head>
<body>
	<h1>Mise à jour D'un Jeu</h1>
	<nav>
		<ul>
			<a href="../metier/GestionAdherents.php"><img src="../vue/images/iconfinder_173_95790.png" title="Gestion des Personnes"></a>
			
			<a href="../metier/GestionJeux.php"><img src="../vue/images/iconfinder_chess_19227.png" title="Gestion des jeux"></a>
			
			<a href="../metier/GestionEmprunts.php"><img src="../vue/images/iconfinder_social__media__social_media__share__3259412.png" title="Gestion des emprunts"></a>
			
			<a href="../metier/GestionParametres.php"><img src="../vue/images/iconfinder_120_95711.png" title="Gestion Ludothèque"></a>
			
			<a href="../vue/formulaire.php"><img src="../vue/images/iconfinder_clipboard-document-office-form-application_3209374.png" title="Formulaire"></a>
			
			<a href="../vue/accueil.php"><img src="../vue/images/iconfinder_go-home_118770.png" title="Accueil"></a>
		</ul>

	</nav>
	<?php $jeu = $_POST['JeuDAO'];?>
	<form action="../metier/GestionJeux.php" method="post">
<?php 
$_POST = JeuDAO::getJeu()->read();
?>


<table>
			<tr>
				<td>Id :</td>
				<td><input type="text" name="Id"
					value="<?php echo $jeu->getIdJeu();?>"></td>
			</tr>
			<tr>
				<td>Id Règle :</td>
				<td><input type="text" name="Id Règle"
					value="<?php echo $jeu->getIdRegle();?>"></td>
			</tr>
			<tr>
				<td>Titre :</td>
				<td><input type="text" name="titre"
					value="<?php echo $jeu->getTitre();?>"></td>
			</tr>
			<tr>
				<td>Année de sortie :</td>
				<td><input type="date" name="annee de sortie"
					value="<?php echo $jeu->getAnneeSortie();?>"></td>
			</tr>
			<tr>
				<td>Auteur :</td>
				<td><input type="text" name="auteur"
					value="<?php echo $jeu->getAuteur();?>"></td>
			</tr>
			<tr>
				<td>Id Editeur :</td>
				<td><input type="text" name="Id editeur"
					value="<?php echo $jeu->getIdEditeur();?>"></td>
			</tr>
			<tr>
				<td>Categorie :</td>
				<td><input type="text" name="categorie"
					value="<?php echo $jeu->getCategorie();?>"></td>
			</tr>
			<tr>
				<td>Univers :</td>
				<td><input type="text" name="univers"
					value="<?php echo $jeu->getUnivers();?>"></td>
			</tr>
			<tr>
				<td>Contenu Initial :</td>
				<td><input type="text" name="contenu initial"
					value="<?php echo $jeu->getContenuInitial();?>"></td>
			</tr>
		</table>

	</form>
	<button type="button" name="maj">Mettre à jour</button>
	<button type="submit" name="supprimer">Supprimer</button>
</body>

</html>
