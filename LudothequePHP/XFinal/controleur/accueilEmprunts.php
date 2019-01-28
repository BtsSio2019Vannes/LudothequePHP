<?php
use DAO\Adherent\AdherentDAO;
use DAO\Alerte\AlerteDAO;
use DAO\Emprunt\EmpruntDAO;
use DAO\Jeu\JeuDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use Emprunt\Emprunt;
use Jeu\Alerte;
?>

<h1>Gérer les Emprunts</h1>
<?php
include ("../vue/emprunt/formulaireEmprunts.php");
include ("../vue/emprunt/formulaireAlertes.php");

$daoAdherent = new AdherentDAO();
$daoEmprunt = new EmpruntDAO();
$daoAlerte = new AlerteDAO();
$daoJeu = new JeuDAO();
$daoJeuPhysique = new JeuPhysiqueDAO();
$messageErreur = "<button class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-remove-sign\"></span> Erreur de saisie !</button>";

/* Création de la liste des emprunts */
$listeEmprunts = array();
$index = 0;
foreach (EmpruntDAO::getEmprunts() as $emprunt) {
    $jeuPhysique = $daoJeuPhysique->read($emprunt->getIdJeuPhysique());
    $jeu = $daoJeu->read($jeuPhysique->getIdJeu());
    $adherent = $daoAdherent->read($emprunt->getIdAdherent());
    $dateEmprunt = $emprunt->getDateEmprunt();
    $dateRetourEffectif = $emprunt->getDateRetourEffectif();
    $alerte = ($emprunt->getIdAlerte() != 0) ? $daoAlerte->read($emprunt->getIdAlerte()) : "Aucune";

    $listeEmprunts[$index] = array(
        'dateEmprunt' => $dateEmprunt,
        'dateRetourEffectif' => $dateRetourEffectif,
        'adherent' => $adherent,
        'jeu' => $jeu,
        'jeuPhysique' => $jeuPhysique,
        'alerte' => $alerte
    );

    $index ++;
}

/* Affichage des formulaires en fonction des variables POST reçues */

/* Après clic sur bouton ajouter */
if (htmlspecialchars(isset($_POST['nouvelEmprunt']))) {
    $date = new DateTime();
    $emprunt = new Emprunt("", "", $date->format('Y-m-d'), "", "");
    afficherFormulaireEmprunt($emprunt);
} /* Après clic sur bouton supprimer */
else if (htmlspecialchars(isset($_POST['supprimerEmprunt'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    list ($idJeuPhysique, $idAdherent, $dateEmprunt) = explode("/", htmlspecialchars($_POST['idEmprunt']));
    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, "", "");
    $daoEmprunt->delete($emprunt);
    echo "<p><b>Emprunt bien supprimé !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
} /* Après clic sur bouton maj */
else if (htmlspecialchars(isset($_POST['modifierEmprunt'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    list ($idJeuPhysique, $idAdherent, $dateEmprunt) = explode("/", htmlspecialchars($_POST['idEmprunt']));
    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, "", "");
    $emprunt = $daoEmprunt->read($emprunt);
    afficherFormulaireEmprunt($emprunt);
} /* Après validation du formulaire */
else if (htmlspecialchars(isset($_POST['formulaireAjout'])) || htmlspecialchars(isset($_POST['formulaireMaj']))) {

    $dateEmprunt = htmlspecialchars($_POST['dateEmprunt']);
    $dateRetourEffectif = htmlspecialchars($_POST['dateRetourEffectif']);
    $idAdherent = htmlspecialchars($_POST['adherent']);
    $idJeuPhysique = htmlspecialchars($_POST['jeuPhysique']);
    $idAlerte = "";

    $emprunt = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, $dateRetourEffectif, $idAlerte);

    if ($dateEmprunt != "" && $dateRetourEffectif != "" && $idAdherent != "" && $idJeuPhysique != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjout']))) {
            $daoEmprunt->create($emprunt);
            echo "<p><b>Emprunt bien ajoutée !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>"; 
        } else if (htmlspecialchars(isset($_POST['formulaireMaj']))) {
            $daoEmprunt->update($emprunt);
            echo "<p><b>Emprunt bien mise à jour !</b><br /><a href=\"index.php?page=emprunts\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireEmprunt($emprunt);
    }
} else if (htmlspecialchars(isset($_GET['action']))) {
    $action = htmlspecialchars($_GET['action']);
    if ($action == "ajouterAlerte") {
        $alerte = new Alerte("", "", "", "", "");
        afficherFormulaireAlerte($alerte);
    } else {
        $listeAlertes = AlerteDAO::getAlertes();
        afficherGestionAlerte($listeAlertes);
    }
} /*
 * Sinon afficher
 * liste emprunts
 */
else {
    echo afficherGestionEmprunt($listeEmprunts);
}
?>
