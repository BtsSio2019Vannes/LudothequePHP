<?php
use Adherent\Personne;
use Adherent\Adherent;
use Adherent\Coordonnees;
use DAO\Personne\PersonneDAO;
use DAO\Adherent\AdherentDAO;
?>

	<h1>Gérer les Personnes</h1>
<?php
include ("../vue/personne/formulairePersonnes.php");

/*
 * Gérer les personnes :
 * ......- Créer un personnes.
 * ......- Identifier les personnes dans une liste :
 * ............# BOUTON Supprimer la personne de la liste.
 * ............# BOUTON Mettre à jour le profil de la personne => nouveau formulaire :
 * ..................+ Mettre à jour les coordonnées. => OK retour Gérer les personnes.
 * ..................+ Renouveler adhésion (si adhérent) SINON Passer adhérent.
 * ..................+ BOUTON retour Gérer les Personnes.
 */

$daoAdherent = new AdherentDAO();
$daoPersonne = new PersonneDAO();

/* Affichage des formulaires en fonction des variables POST reçues */

/* Après clic sur bouton ajouter */
if (htmlspecialchars(isset($_POST['ajouter']))) {
    $coordonnees = new Coordonnees("", "", "", "");
    $personne = new Personne("", "", "", "", $coordonnees, "", "");
    afficherFormulaire($personne);
} /* Après clic sur bouton supprimer */
else if (htmlspecialchars(isset($_POST['supprimer'])) && htmlspecialchars(isset($_POST['idPersonne']))) {
    $adherent = $daoAdherent->read(htmlspecialchars($_POST['idPersonne']));
    $daoAdherent->delete($adherent);

    echo "<p><b>Personne bien supprimée !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
} /* Après clic sur bouton maj */
else if (htmlspecialchars(isset($_POST['maj'])) && htmlspecialchars(isset($_POST['idPersonne']))) {
    $personne = $daoPersonne->read(htmlspecialchars($_POST['idPersonne']));
    afficherFormulaire($personne);
} /* Après validation du formulaire */
else if (htmlspecialchars(isset($_POST['formulaireAjout'])) || htmlspecialchars(isset($_POST['formulaireMaj']))) {
    $messageErreur = "ERREUR";

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);
    $mel = htmlspecialchars($_POST['mel']);
    $numeroTelephone = htmlspecialchars($_POST['numeroTelephone']);

    $idPersonne = htmlspecialchars(isset($_POST['idPersonne'])) ? htmlspecialchars($_POST['idPersonne']) : "";
    $nom = isset($nom) && $nom != "" ? $nom : $messageErreur;
    $prenom = isset($prenom) && $prenom != "" ? $prenom : $messageErreur;
    $dateNaissance = isset($dateNaissance) && $dateNaissance != "" ? $dateNaissance : $messageErreur;
    $rue = isset($rue) && $rue != "" ? $rue : $messageErreur;
    $codePostal = isset($codePostal) && $codePostal != "" ? $codePostal : $messageErreur;
    $ville = isset($ville) && $ville != "" ? $ville : $messageErreur;
    $coordonnees = new Coordonnees("", $rue, $codePostal, $ville);
    $mel = isset($mel) && $mel != "" ? $mel : $messageErreur;
    $numeroTelephone = isset($numeroTelephone) && $numeroTelephone != "" ? $numeroTelephone : $messageErreur;

    $idAdherentAssocie = htmlspecialchars(isset($_POST['adherents'])) ? htmlspecialchars($_POST['adherents']) : "";
    $date = new DateTime();
    $datePremiereAdhesion = htmlspecialchars(isset($_POST['datePremiereAdhesion'])) ? htmlspecialchars($_POST['datePremiereAdhesion']) : $date->format('Y-m-d');
    $date->modify('+1 year');
    $dateFinAdhesion = htmlspecialchars(isset($_POST['dateFinAdhesion'])) ? htmlspecialchars($_POST['dateFinAdhesion']) : $date->format('Y-m-d');
    $idReglement = htmlspecialchars(isset($_POST['reglement'])) ? htmlspecialchars($_POST['reglement']) : 1;

    $adherentAssocie = ($idAdherentAssocie != "") ? $daoAdherent->read($idAdherentAssocie) : null;
    $adherent = new ArrayObject();
    $adherent->append($adherentAssocie);
    $personne = new Personne($idPersonne, $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numeroTelephone);

    if ($nom != $messageErreur && $prenom != $messageErreur && $dateNaissance != $messageErreur && $mel != $messageErreur && $rue != $messageErreur && $codePostal != $messageErreur && $ville != $messageErreur && $numeroTelephone != $messageErreur) {

        if (htmlspecialchars(isset($_POST['formulaireAjout']))) {
            $daoPersonne->create($personne);
            echo "<p><b>Personne bien ajoutée !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMaj']))) {
            $daoPersonne->update($personne);
            echo "<p><b>Personne bien mise à jour !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
        }
        
        if ($idAdherentAssocie == "passerAdherent") {

            $adherent = new Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion);
            $adherent->setIdPersonne($idPersonne);
            $adherent->setNom($nom);
            $adherent->setPrenom($prenom);
            $adherent->setDateNaissance($dateNaissance);
            $adherent->setCoordonnees($coordonnees);
            $adherent->setMel($mel);
            $adherent->setNumeroTelephone($numeroTelephone);
            if ($idPersonne == "") {
                $daoAdherent->create($adherent);
            }
            else {
                $daoAdherent->update($adherent);
            }
        } else if ($idAdherentAssocie != "") {

            $daoAdherent->ajouterBeneficiaire($idAdherentAssocie, $idPersonne);
        }

        // if (htmlspecialchars(isset($_POST['renouvelerAdhesion']))) {
        // $adherent = $daoPersonne->read($personne->getIdPersonne());
        // $dateARenouveler = $adherent->getDateFinAdhesion();
        // $dateRenouvelee = date('Y-m-d', strtotime('+12 month', strtotime($dateARenouveler)));
        // $adherent->setDateFinAdhesion($dateRenouvelee);
        // }
    } else {
        echo $messageErreur;
        afficherFormulaire($personne);
    }
} /* Sinon afficher liste personnes */
else {
    echo afficherGestionPersonne();
}

?>