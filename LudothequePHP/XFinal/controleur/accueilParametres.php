<?php 
use DAO\Reglement\ReglementDAO;
use Parametre\Reglement;


?>

<section>
		<h1>Gérer les Paramètres</h1>
		
</section>

<?php
/*
 * Traitement des demandes affichage (GET) et des envois de formulaire (POST)
 * en relation avec le métier
 */

// parametres
if (htmlspecialchars(isset($_POST['parametres']))) {
    print_r($_POST);
 
    $nbrJeux = htmlspecialchars($_POST['nombre de jeux']);
    $duree = htmlspecialchars($_POST['duree']);
    $retardTolere = htmlspecialchars($_POST['retard']);
    $valeurCaution = htmlspecialchars($_POST['Caution']);
    $coutAdhesion = htmlspecialchars($_POST['cout']);
    
    
    $Reglement = new Reglement("", $nbrJeux, $duree, $retardTolere,$valeurCaution,$coutAdhesion);
    $daoReglement = new ReglementDAO();
    $daoReglement->create($Reglement);
    
    if ($nbrJeux && $duree  && $retardTolere  && $valeurCaution && $coutAdhesion ) {
        
        
        echo " <p><b>" . $nbrJeux . " " . $retardTolere . " " . $valeurCaution . " " . $coutAdhesion . " pas d'alerte!<a href=\"..\..\vue\jeux\">Retour</a></p>";
    }       
}

//Condition pour modifier les parametres

if (htmlspecialchars(isset($_POST['modifier']))) {
    print_r($_POST);    
    formModifParametres();
    $idReglement = htmlspecialchars($_POST['idReglement']);
    $nbrJeux = htmlspecialchars($_POST['nombre de jeux']);
    $retardTolere = htmlspecialchars($_POST['retard']);
    $valeurCaution = htmlspecialchars($_POST['Caution']);
    $coutAdhesion = htmlspecialchars($_POST['cout']);
        
    $Reglement = new Reglement($idReglement, $nbrJeux, $retardTolere, $valeurCaution,$coutAdhesion);
    
    $daoReglement = new ReglementDAO();
    $reglement = new Reglement($nbrJeux, $retardTolere, $valeurCaution, $coutAdhesion);
    $reglement->setIdReglement($idReglement);
    $daoReglement->update($reglement);
    
    echo "les parametres ont bien été modifiées <a href=\"..\\..\\vue\\formulaireParametres.php\">Retour</a></p>";
}


else {
    afficherParametres();
}


?>
