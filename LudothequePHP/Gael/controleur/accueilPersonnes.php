<?php
use Personne\Personne;
?>
<section>
	<h1>Gérer les Personnes</h1>
<?php
include ("Personne.php");
include ("formulaire.php");

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

/* Affichage des formulaires en fonction des variables POST reçues */

/* Après clic sur bouton ajouter */
if (htmlspecialchars(isset($_POST['ajouter']))) {
    $personne = new \Personne\Personne("", "", "", "", "", "", "", "");
    afficherFormulaireAjout($personne);
} /* Après clic sur bouton supprimer */
else if (htmlspecialchars(isset($_POST['supprimer'])) && htmlspecialchars(isset($_POST['personne']))) {
    $idPersonne = htmlspecialchars($_POST['personne']);
    $personne = new \Personne\Personne($idPersonne, "", "", "", "", "", "", "");
    $personne->supprimerPersonne();
    echo "<p><b>Personne bien supprimée !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
} /* Après clic sur bouton maj */
else if (htmlspecialchars(isset($_POST['maj'])) && htmlspecialchars(isset($_POST['personne']))) {
    $idPersonne = htmlspecialchars($_POST['personne']);
    $personne = Personne::identifierPersonne($idPersonne);

    if ($personne->retrouverAdherentAssocie() == "") {
        $adherent = Personne::identifierAdherent($idPersonne);
    } else {
        $listeAdherents = $personne->retrouverAdherentAssocie();
    }

    afficherFormulaireMaj($personne);
} /* Après validation du formulaire d'ajout */
else if (htmlspecialchars(isset($_POST['formulaireAjout']))) {
    $messageErreur = "ERREUR";

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $coordonnees = htmlspecialchars($_POST['coordonnees']);
    $mel = htmlspecialchars($_POST['mel']);
    $numero = htmlspecialchars($_POST['numero']);
    $idPersonneAssociee = htmlspecialchars($_POST['adherents']);

    $nom = isset($nom) && $nom != "" ? $nom : $messageErreur;
    $prenom = isset($prenom) && $prenom != "" ? $prenom : $messageErreur;
    $dateNaissance = isset($dateNaissance) && $dateNaissance != "" ? $dateNaissance : $messageErreur;
    $coordonnees = isset($coordonnees) && $coordonnees != "" ? $coordonnees : $messageErreur;
    $mel = isset($mel) && $mel != "" ? $mel : $messageErreur;
    $numero = isset($numero) && $numero != "" ? $numero : $messageErreur;
    $personne = new \Personne\Personne("", $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numero);

    if ($nom != $messageErreur && $prenom != $messageErreur && $dateNaissance != $messageErreur && $mel != $messageErreur && $coordonnees != $messageErreur && $numero != $messageErreur) {
        $personne->ajouterPersonne();

        if ($idPersonneAssociee == "") {
            $idReglement = 1;
            $date = new DateTime();
            $datePremiereAdhesion = $date->format('Y-m-d');
            $date->modify('+1 year');
            $dateFinAdhesion = $date->format('Y-m-d');
            $valeurCaution = 15;
            $adherent = new \Personne\Adherent\Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution);
            $adherent->setIdPersonne($personne->getIdPersonne());
            $adherent->passerAdherent();
        } else {
            $idAdherent = htmlspecialchars($_POST['adherents']);
            $personne->associerAdherent($idAdherent);
        }
        echo "<p><b>Personne bien ajoutée !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
    } else {
        echo $messageErreur;
        afficherFormulaireAjout($personne);
    }
} /* Après validation du formulaire maj */
else if (htmlspecialchars(isset($_POST['formulaireMaj']))) {
    $messageErreur = "ERREUR";

    $idPersonne = htmlspecialchars($_POST['idPersonne']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $coordonnees = htmlspecialchars($_POST['coordonnees']);
    $mel = htmlspecialchars($_POST['mel']);
    $numero = htmlspecialchars($_POST['numero']);
    $idPersonneAssociee = htmlspecialchars($_POST['adherents']);

    $nom = isset($nom) && $nom != "" ? $nom : $messageErreur;
    $prenom = isset($prenom) && $prenom != "" ? $prenom : $messageErreur;
    $dateNaissance = isset($dateNaissance) && $dateNaissance != "" ? $dateNaissance : $messageErreur;
    $coordonnees = isset($coordonnees) && $coordonnees != "" ? $coordonnees : $messageErreur;
    $mel = isset($mel) && $mel != "" ? $mel : $messageErreur;
    $numero = isset($numero) && $numero != "" ? $numero : $messageErreur;

    $personne = new \Personne\Personne($idPersonne, $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numero);

    if ($nom != $messageErreur && $prenom != $messageErreur && $dateNaissance != $messageErreur && $mel != $messageErreur && $coordonnees != $messageErreur) {
        $personne->mettreAJourPersonne();
        $personne->supprimerBeneficiaire();
        $personne->associerAdherent($idPersonneAssociee);

        if (htmlspecialchars(isset($_POST['passerAdherent']))) {
            $idReglement = 1;
            $date = new DateTime();
            $datePremiereAdhesion = $date->format('Y-m-d');
            $date->modify('+1 year');
            $dateFinAdhesion = $date->format('Y-m-d');
            $valeurCaution = 15;
            $adherent = new \Personne\Adherent\Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution);
            $adherent->setIdPersonne($idPersonne);
            $adherent->passerAdherent();
        } else if (htmlspecialchars(isset($_POST['renouvelerAdhesion']))) {
            $adherent = Personne::identifierAdherent($personne->getIdPersonne());
            $adherent->renouvelerAdhesion();
        }
        echo "<p><b>Personne bien mise à jour !</b><br/><a href=\"index.php?page=personnes\">Retour</a></p>";
    } else {
        echo $messageErreur;

        afficherFormulaireMaj($personne);
    }
} /* Sinon afficher liste personnes */
else {
    echo afficherGestionPersonne();
}

?>
</section>