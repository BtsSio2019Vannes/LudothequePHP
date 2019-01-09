<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="index.css">
<title><?php /* Afficher titre de la page */ ?></title>
</head>


<body>
<?php
if (isset($_GET['page'])) {
    $page = htmlentities($_GET['page']);
    if ($page == "personnes" || $page == "jeux" || $page == "emprunts" || $page == "parametres") {
        ?>
	<nav>
        <?php
        include ('menu.php');
        ?>
	</nav>
        <?php
    }
    switch ($_GET['page']) {
        case "personnes":
            include ('../controleur/personnes/accueilPersonnes.php');
            break;
        case "jeux":
            include ('../controleur/jeux/accueilJeux.php');
            break;
        case "emprunts":
            include ('../controleur/emprunts/accueilEmprunts.php');
            break;
        case "parametres":
            include ('../controleur/parametres/accueilParametres.php');
            break;
        default:
            include ('accueil.php');
            break;
    }
} else {
    include ('accueil.php');
}

?>

</body>

</html>