<?php
include_once ("../metier/adherents.php");
include_once ("../metier/parametres.php");
include_once ("../db/Daos.php");
include_once ('../vue/formulaireAdherent.php');


use Adherent\Personne;
use Adherent\Coordonnees;

use DAO\Personne\PersonneDAO;
use DAO\Coordonnees\CoordonneesDAO;
use DAO\Adherent\AdherentDAO;
use Adherent\Adherent;

// Condition ajouter personne
if (htmlspecialchars(isset($_POST['ajouter']))) {
    // print_r($_POST);
    formulaireAjoutPersonne();
} elseif (htmlspecialchars(isset($_POST['ajouterPersonne']))) {
    
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $numeroTelephone = htmlspecialchars($_POST['numTel']);
    $mel = htmlspecialchars($_POST['mel']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);
    
    $coordonnees = new Coordonnees(- 1, $rue, $codePostal, $ville);
    $daoCoordonnees = new CoordonneesDAO();
    $daoCoordonnees->create($coordonnees);
    
    if ($nom != "" && $prenom != "" && $dateNaissance != "" && $numeroTelephone != "" && $mel != "" && $rue != "" && $codePostal != "" && $ville != "") {
        $personne = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $coordonnees);
        $daoPersonne = new PersonneDAO();
        $daoPersonne->create($personne);
        
        echo " <p><b>" . $nom . " " . $prenom . " a bien été ajouté!<a href=\"..\\vue\\index.php?page=adherents\">Retour</a></p>";
    }
    
    if ($nom = "" || $prenom = "" || $dateNaissance = "" || $numeroTelephone = "" || $mel = "" || $rue = "" || $codePostal = "" || $ville = "") {
        echo "Veuillez saisir les champs vides";
    }
} // Condition pour supprimer une personne
elseif (htmlspecialchars(isset($_POST['supprimer']))) {
    
    afficheMessageDeConfirmation();
} elseif (htmlspecialchars(isset($_POST['supprimerPersonne']))) {
    $daoAdherent = new AdherentDAO();
    $daoAdherent->deleteFromKey($_POST['idPersonne']);
    $daoPersonne = new PersonneDAO();
    $daoPersonne->deleteFromKey($_POST['idPersonne']);
    
    echo "La personne a bien été supprimée! <a href=\"..\\vue\\index.php?page=adherents\">Retour</a></p>";
} // Condition pour modifier une personne
elseif (htmlspecialchars(isset($_POST['maj']))) {
    // print_r($_POST);
    formulaireModifPersonnes();
} elseif (htmlspecialchars(isset($_POST['modifier']))) {
    
    $idPersonne = htmlspecialchars($_POST['idPersonne']);
    $idCoordonnees = htmlspecialchars($_POST['idCoordonnees']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);
    $mel = htmlspecialchars($_POST['mel']);
    $numeroTelephone = htmlspecialchars($_POST['numTel']);
    
    $coordonnees = new Coordonnees($idCoordonnees, $rue, $codePostal, $ville);
    adresseUtilisee($coordonnees);
    $daoPersonne = new PersonneDAO();
    $personne = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $coordonnees);
    $personne->setIdPersonne($idPersonne);
    $daoPersonne->update($personne);
    echo "La personne a bien été modifiée <a href=\"..\\vue\\index.php?page=adherents\">Retour</a></p>";
} elseif (htmlspecialchars(isset($_POST['passerAdh']))) {
    // print_r($_POST);
    /*
     * $idPersonne = htmlspecialchars($_POST['idPersonne']);
     *
     * $daoPersonne = new PersonneDAO();
     * $personne = $daoPersonne->read($idPersonne);
     *
     * if (! AdherentDAO::isAdherent($personne)) {
     */
    // if ( (new AdherentDAO())->isAdherent($pers)){
    formulaireAjoutAdherent();
    // }
}
elseif (htmlspecialchars(isset($_POST['validerAdh']))) {
    //print_r($_POST);
    
    $daoPersonne = new PersonneDAO();
    $personne = $daoPersonne->read($_POST['idPersonne']);
    $datePremiereAdhesion = htmlspecialchars($_POST['datePremiereAdhesion']);
    $dateFinAdhesion = htmlspecialchars($_POST['DateFinAdhesion']);
    $designationReglement = htmlspecialchars($_POST['reglement']);
    
    $daoAdherent = new AdherentDAO();
    $adherent = new Adherent($personne->getNom(), $personne->getPrenom(), $personne->getDateNaissance(), $personne->getNumeroTelephone(), $personne->getMel(), $personne->getCoordonnees(), $designationReglement, $datePremiereAdhesion, $dateFinAdhesion);
    
    $adherent->setIdPersonne($_POST['idPersonne']);
    echo $adherent;
    $daoAdherent->create($adherent);
    echo "La personne a bien été ajoutée dans la liste des adhérents <a href=\"..\\vue\\index.php?page=adherents\">Retour</a></p>";
}
elseif (htmlspecialchars(isset($_POST['retour']))) {}
else {
    // print_r($_POST);
    afficherPersonnes();
}

function adresseUtilisee($coordonnees)
{
    $daoCoordonnees = new CoordonneesDAO();
    if ($daoCoordonnees->nbLignesCoordonnees($coordonnees) > 1) {
        $daoCoordonnees->create($coordonnees);
    } else {
        $daoCoordonnees->update($coordonnees);
    }
}

function estAdherent($idPersonne)
{
    $daoAdherent = new AdherentDAO();
    if ($daoAdherent->getAdherent($idPersonne)) {
        $daoAdherent->read($idPersonne);
    }
}


?>