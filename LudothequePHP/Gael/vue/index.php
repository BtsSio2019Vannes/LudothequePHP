<?php
include ("../XFinal/db/Daos.php");
include ("../XFinal/metier/Emprunt.php");
include ("../XFinal/metier/Jeu.php");
include ("../XFinal/metier/Parametre.php");
include ("../XFinal/metier/Personne.php");
?>
<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="index.css">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<title><?php /* Afficher titre de la page */ ?></title>
</head>
<body>


<?php
$page = (isset($_GET['page'])) ? htmlentities($_GET['page']) : "personnes";
?>

<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Ludothèque</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="index.php?page=personnes">Personnes</a></li>
				<li><a href="index.php?page=jeux">Jeux</a></li>
				<li><a href="index.php?page=emprunts">Emprunts</a></li>
				<li><a href="index.php?page=parametres">Paramètres</a></li>
			</ul>
		</div>
	</nav>


	<div class="container">
<?php
switch ($page) {
    case "personnes":
        include ('../controleur/accueilPersonnes.php');
        break;
    case "jeux":
        include ('../controleur/accueilJeux.php');
        break;
    case "emprunts":
        include ('../controleur/accueilEmprunts.php');
        break;
    case "parametres":
        include ('../controleur/accueilParametres.php');
        break;
    default:
        include ('../controleur/accueilPersonnes.php');
        break;
}
?>
</div>


</body>

</html>