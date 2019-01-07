<?php
include ("../dao/Dao.php");

try {
    $bdd = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>
<html>
<head>
<title>Gestion Adherents</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="../vue/css/adherentsCS.css">


</head>
<body>
	<h1>Gestion Adherents</h1>
	
	<nav>
		<ul>
			<img src="../vue/images/iconfinder_173_95790.png">
			<a href="Gestion des adhérents">Gestion des adhérents</a>
			<img src="../vue/images/iconfinder_chess_19227.png">
			<a href="Gestion des jeux">Gestion des jeux</a>
			<img src="../vue/images/iconfinder_social__media__social_media__share__3259412.png">
			<a href="Gestion des emprunts">Gestion des emprunts</a>
			<img src = "../vue/images/iconfinder_120_95711.png">
			<a href="Paramètres Ludothèque">Gestion Ludothèque</a>
			<img src="../vue/images/iconfinder_go-home_118770.png">
			<a href="Accueil Ludothèque">Accueil</a>
			
		</ul>
	</nav>
	<a href="" ><input type="submit" name="maj" value="Mettre à jour Personne"></a>
	<a href=""><input type="submit" name="ajout" value="Ajouter Personne"></a>
	<a href=""><input type="submit" name="supprimer" value="Supprimer Personne"></a>
	
	<table class="echo">
		<tr>
			<td>Identifiant</td>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Date de Naissance</td>
			<td>Id Coordonnees</td>
			<td>Mail</td>
			<td>Numéro Téléphone</td>
			
			
		</tr>
		<?php echo \Dao\Personne\PersonneDAO::getPersonne();?>
	</table>	
	
		
	

</body>

</html>