<?php
use Adherent\Adherent;
use Adherent\Coordonnees;
use DAO\Adherent\AdherentDAO;
use DAO\Alerte\AlerteDAO;
use DAO\Editeur\EditeurDAO;
use DAO\Emprunt\EmpruntDAO;
use DAO\Jeu\JeuDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use Emprunt\Emprunt;
?>

<h1>Gérer les Emprunts</h1>
<?php
include ("../vue/emprunt/formulaireEmprunts.php");

$daoAdherent = new AdherentDAO();
$daoEmprunt = new EmpruntDAO();
$daoAlerte = new AlerteDAO();
$daoJeu = new JeuDAO();
$daoJeuPhysique = new JeuPhysiqueDAO();
$daoEditeur = new EditeurDAO();

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
    $coordonnees = new Coordonnees("", "", "", "");
    $emprunt = new Emprunt("", "", "", "", $coordonnees, "", "");
    afficherFormulaire($emprunt);
} /*
   * Après clic sur
   * bouton supprimer
   */
else if (htmlspecialchars(isset($_POST['supprimer'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    $adherent = $daoAdherent->read(htmlspecialchars($_POST['idEmprunt']));
    $daoAdherent->delete($adherent);
    echo "
<p>
	<b>Emprunt bien supprimée !</b><br />
	<a href=\"index.php?page=emprunts\">Retour</a>
</p>
";
} /* Après clic sur bouton maj */
else if (htmlspecialchars(isset($_POST['maj'])) && htmlspecialchars(isset($_POST['idEmprunt']))) {
    $emprunt = $daoEmprunt->read(htmlspecialchars($_POST['idEmprunt']));
    afficherFormulaire($emprunt);
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
    $idEmprunt = htmlspecialchars(isset($_POST['idEmprunt'])) ? htmlspecialchars($_POST['idEmprunt']) : "";
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
    $emprunt = new Emprunt($idEmprunt, $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numeroTelephone);
    if ($nom != $messageErreur && $prenom != $messageErreur && $dateNaissance != $messageErreur && $mel != $messageErreur && $rue != $messageErreur && $codePostal != $messageErreur && $ville != $messageErreur && $numeroTelephone != $messageErreur) {
        if (htmlspecialchars(isset($_POST['formulaireAjout']))) {
            $daoEmprunt->create($emprunt);
            echo "
<p>
	<b>Emprunt bien ajoutée !</b><br />
	<a href=\"index.php?page=emprunts\">Retour</a>
</p>
";
        } else if (htmlspecialchars(isset($_POST['formulaireMaj']))) {
            $daoEmprunt->update($emprunt);
            echo "
<p>
	<b>Emprunt bien mise à jour !</b><br />
	<a href=\"index.php?page=emprunts\">Retour</a>
</p>
";
        }
        if ($idAdherentAssocie == "passerAdherent") {
            $adherent = new Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion);
            $adherent->setIdEmprunt($idEmprunt);
            $adherent->setNom($nom);
            $adherent->setPrenom($prenom);
            $adherent->setDateNaissance($dateNaissance);
            $adherent->setCoordonnees($coordonnees);
            $adherent->setMel($mel);
            $adherent->setNumeroTelephone($numeroTelephone);
            if ($idEmprunt == "") {
                $daoAdherent->create($adherent);
            } else {
                $daoAdherent->update($adherent);
            }
        } else if ($idAdherentAssocie != "") {
            $daoAdherent->ajouterBeneficiaire($idAdherentAssocie, $idEmprunt);
        }

        // if (htmlspecialchars(isset($_POST['renouvelerAdhesion']))) { //
        $adherent = $daoEmprunt->read($emprunt->getIdEmprunt()); //
        $dateARenouveler = $adherent->getDateFinAdhesion(); // $dateRenouvelee =
        date('Y-m-d', strtotime('+12 month', strtotime($dateARenouveler))); //
        $adherent->setDateFinAdhesion($dateRenouvelee); // } } else { echo
        $messageErreur;
        afficherFormulaire($emprunt);
    }
} /*
   * Sinon afficher
   * liste emprunts
   */
else {
    echo afficherGestionEmprunt($listeEmprunts);
}
?>
