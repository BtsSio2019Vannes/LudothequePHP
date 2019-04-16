<?php
include_once ("../metier/emprunts.php");
include_once ("../db/Daos.php");
include_once ("../vue/emprunt/formulaireEmprunts.php");
include_once ("../vue/emprunt/formulaireAlertes.php");

use DAO\Adherent\AdherentDAO;
use DAO\Alerte\AlerteDAO;
use DAO\Emprunt\EmpruntDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use Emprunt\Emprunt;
use Jeu\Alerte;
?>

<h1>Gérer les Emprunts</h1>
<?php

$daoAdherent = new AdherentDAO();
$daoEmprunt = new EmpruntDAO();
$daoAlerte = new AlerteDAO();
$daoJeuPhysique = new JeuPhysiqueDAO();
$messageErreur = "<button class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-remove-sign\"></span> Erreur de saisie !</button>";

/* Création de la liste des emprunts */
$listeEmprunts = array();
$index = 0;
foreach (EmpruntDAO::getEmprunts() as $emprunt) {
    $jeuPhysique = $daoJeuPhysique->read($emprunt->getIdJeuPhysique());
    $adherent = $daoAdherent->read($emprunt->getIdAdherent());
    $dateEmprunt = $emprunt->getDateEmprunt();
    $dateRetourEffectif = $emprunt->getDateRetourEffectif();
    $alerte = ($emprunt->getIdAlerte() != 0) ? $daoAlerte->read($emprunt->getIdAlerte()) : "Aucune";
 
    $listeEmprunts[$index] = array(
        'dateEmprunt' => $dateEmprunt,
        'dateRetourEffectif' => $dateRetourEffectif,
        'adherent' => $adherent,
        'jeuPhysique' => $jeuPhysique,
        'alerte' => $alerte
    );
    $index ++;
}

/* Affichage des formulaires en fonction des variables POST reçues */

/* Après clic sur bouton ajouter emprunt */
if (htmlspecialchars(isset($_POST['nouvelEmprunt']))) {
    $date = new DateTime();
    $emprunt = new Emprunt("", "", $date->format('Y-m-d'), "", "");
    afficherFormulaireEmprunt($emprunt);
} /* Après clic sur bouton supprimer emprunt */
else if (htmlspecialchars(isset($_POST['supprimerEmprunt'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    list ($idJeuPhysique, $idAdherent, $dateEmprunt) = explode("/", htmlspecialchars($_POST['idEmprunt']));
    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, "", "");
    $daoEmprunt->delete($emprunt);
    echo "<p><b>Emprunt bien supprimé !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
} /* Après clic sur bouton maj emprunt */
else if (htmlspecialchars(isset($_POST['modifierEmprunt'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    list ($idJeuPhysique, $idAdherent, $dateEmprunt) = explode("/", htmlspecialchars($_POST['idEmprunt']));
    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, "", "");
    $emprunt = $daoEmprunt->read($emprunt);
    afficherFormulaireEmprunt($emprunt);
} /* Après validation du formulaire emprunt */
else if (htmlspecialchars(isset($_POST['formulaireAjoutEmprunt'])) || htmlspecialchars(isset($_POST['formulaireMajEmprunt']))) {

    $dateEmprunt = htmlspecialchars($_POST['dateEmprunt']);
    $dateRetourEffectif = htmlspecialchars($_POST['dateRetourEffectif']);
    $idAdherent = htmlspecialchars($_POST['adherent']);
    $idJeuPhysique = htmlspecialchars($_POST['jeuPhysique']);
    $idAlerte = htmlspecialchars($_POST['alerte']);

    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, $dateRetourEffectif, $idAlerte);

    if ($dateEmprunt != "" && $dateRetourEffectif != "" && $idAdherent != "" && $idJeuPhysique != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjoutEmprunt']))) {
            $daoEmprunt->create($emprunt);
            echo "<p><b>Emprunt bien ajouté !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMajEmprunt']))) {
            $daoEmprunt->update($emprunt);
            echo "<p><b>Emprunt bien mis à jour !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireEmprunt($emprunt);
    }
} /* Après clic sur bouton ajouter alerte */
else if (htmlspecialchars(isset($_POST['nouvelleAlerte']))) {
    $alerte = new Alerte("", "", "", "", "");
    afficherFormulaireAlerte($alerte);
} /* Après clic sur bouton supprimer alerte */
else if (htmlspecialchars(isset($_POST['supprimerAlerte'])) && htmlspecialchars(isset($_POST['idAlerte']))) {
    $idAlerte = htmlspecialchars($_POST['idAlerte']);
    $alerte = new Alerte($idAlerte, "", "", "", "");
    $daoAlerte->delete($alerte);
    echo "<p><b>Alerte bien supprimée !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
} /* Après clic sur bouton maj alerte */
else if (htmlspecialchars(isset($_POST['modifierAlerte'])) && htmlspecialchars(isset($_POST['idAlerte']))) {
    $idAlerte = htmlspecialchars($_POST['idAlerte']);
    $alerte = $daoAlerte->read($idAlerte);
    afficherFormulaireAlerte($alerte);
} /* Après validation du formulaire alerte */
else if (htmlspecialchars(isset($_POST['formulaireAjoutAlerte'])) || htmlspecialchars(isset($_POST['formulaireMajAlerte']))) {
    
    $idAlerte = htmlspecialchars(isset($_POST['idAlerte'])) ? htmlspecialchars($_POST['idAlerte']) : "";
    $nom = htmlspecialchars($_POST['nom']);
    $dateRetour = htmlspecialchars($_POST['dateRetour']);
    $typeAlerte = htmlspecialchars($_POST['typeAlerte']);
    $commentaire =  htmlspecialchars($_POST['commentaire']);
    
    $alerte= new Alerte($idAlerte, $nom, $dateRetour, $typeAlerte, $commentaire);
    
    if ($nom != "" && $dateRetour != "" && $typeAlerte != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjoutAlerte']))) {
            $daoAlerte->create($alerte);
            echo "<p><b>Alerte bien ajoutée !</b><br /><a href=\"index.php?page=emprunts&action=gererAlerte\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMajAlerte']))) {
            $daoAlerte->update($alerte);
            echo "<p><b>Alerte bien mise à jour !</b><br /><a href=\"index.php?page=emprunts&action=gererAlerte\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireAlerte($alerte);
    }
} /* Accès liste alertes */
else if (htmlspecialchars(isset($_GET['action']))) {
    $action = htmlspecialchars($_GET['action']);
    if ($action == "gererAlerte") {
        $listeAlertes = AlerteDAO::getAlertes();
        afficherGestionAlerte($listeAlertes);
    } else {
        afficherGestionEmprunt($listeEmprunts);
    }
} /*
   * Sinon afficher
   * liste emprunts
   */
else {
    afficherGestionEmprunt($listeEmprunts);
}
?>
