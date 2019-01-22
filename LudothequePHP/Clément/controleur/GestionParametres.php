<?php

include '../../XFinal/db/Daos.php';
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<title>Gestion des Emprunts</title>
<link rel="stylesheet" type="text/css" href="../vue/css/jeux.css">
</head>
<body>
	<h1>Gestion des Paramètres</h1>
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
	<a href=""><input type="submit" name="maj" value="Mettre à jour Emprunt"></a>
	<a href="../vue/formulaire.php "><input type="submit" name="ajout emprunt"
		value="Ajouter Emprunt"></a>
	<a href=""><input type="submit" name="supprimer" value="Supprimer Emprunt"></a>
	<br>
	<table class="echo">
		<tr>
			<td>Id règlement</td>
			<td>Nombre de Jeux</td>
			<td>Durée</td>
			<td>Retard Toléré</td>
			<td>Valeur Caution</td>
			<td>Cout Adhésion</td>
			
		</tr>

<?php echo \Dao\Reglement\ReglementDAO::getReglement();?>

</table>


</body>
<?php ?>

</html>