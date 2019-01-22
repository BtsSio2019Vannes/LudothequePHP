<?php

use Jeu\Jeu;

include ("../../XFinal/db/Dao.php");
try {
    $bdd = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title>Gestion des jeux</title>
<link rel="stylesheet" type="text/css" href="../vue/css/jeux.css">
</head>
<body>
	<h1>Gestion des Jeux</h1>
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
	<a href="../vue/formulaireMajJeu.php"><input type="submit" name="maj" value="Mettre à jour Jeu"></a>
	<a href="../vue/formulaireAjoutJeu.php "><input type="submit" name="ajout"
		value="Ajouter Jeu"></a>
	<a href=""><input type="submit" name="supprimer" value="Supprimer Jeu"></a>
	<br>
	<table class="echo">
		<tr>
			<td>Identifiant</td>
			<td>IdRegle</td>
			<td>Titre</td>
			<td>Année de Sortie</td>
			<td>Auteur</td>
			<td>Id Editeur</td>
			<td>Categorie</td>
			<td>Univers</td>
			<td>Contenu Initial</td>
		</tr>

<?php echo \Dao\Jeu\JeuDAO::getJeu();?>

</table>


</body>
<?php 
if (htmlspecialchars(isset($_POST['supprimer jeu']) && isset($_POST['jeu']))) {
    $idJeu = htmlspecialchars($_POST['jeu']);
    $daoP->read($idJeu);
    $dao->delete($daoP);
    echo "Le jeu à été supprimé";
}
if (htmlspecialchars(isset($_POST['mettre à jour jeu']) && isset($_POST['jeu']))) {
    $idJeu = htmlspecialchars($_POST['jeu']);
    $daoP->read($idJeu);
    $dao->update($daoP);
    echo "Le jeu à bien été mis à jour";
}
if (htmlspecialchars(isset($_POST['ajouter un jeu']))) {
    $jeu = new Jeu("", "", "", "", "", "", "", "", "");
    include_once 'formulaireAjoutJeu.php'; 
}
elseif (htmlspecialchars(isset($_POST['ajouter un jeu']))) {
    $messageErreur = "Erreur";
    $id = htmlspecialchars($_POST['idJeu']);
    $idR = htmlspecialchars($_POST['idRegle']);
    $titre = htmlspecialchars($_POST['titre']);
    $annee = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idE = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenu = htmlspecialchars($_POST['contenuInitial']);
    
    $;
}
?>

</html>