<?php
use Adherent\Personne;
use Adherent\Coordonnees;

use DAO\Personne\PersonneDAO;
use DAO\Coordonnees\CoordonneesDAO;
use DAO\Adherent\AdherentDAO;


// Condition ajouter personne
if (htmlspecialchars(isset($_POST['ajouter']))) {
    print_r($_POST);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $numeroTelephone = htmlspecialchars($_POST['numTel']);
    $mel = htmlspecialchars($_POST['mel']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);

    $coordonnees = new Coordonnees("", $rue, $codePostal, $ville);
    $daoCoordonnees = new CoordonneesDAO();
    $daoCoordonnees->create($coordonnees);

    if ($nom != "" && $prenom != "" && $dateNaissance != "" && $numeroTelephone != "" && $mel != "" && $rue != "" && $codePostal != "" && $ville != "") {
        $personne = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $coordonnees);
        $daoPersonne = new PersonneDAO();
        $daoPersonne->create($personne);

        echo " <p><b>" . $nom . " " . $prenom . " a bien été ajouté!<a href=\"..\..\vue\adherent.php\">Retour</a></p>";
    }

    if ($nom = "" || $prenom = "" || $dateNaissance = "" || $numeroTelephone = "" || $mel = "" || $rue = "" || $codePostal = "" || $ville = "") {
        echo "Veuillez saisir les champs vides";
    }
}

//Condition pour supprimer une personne
if (htmlspecialchars(isset($_POST['supprimer']))) {
    $idPersonne = htmlspecialchars($_POST['idPersonne']);
    $idCoordonnees = htmlspecialchars($_POST['idCoordonnees']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $mel = htmlspecialchars($_POST['mel']);
    $numeroTelephone = htmlspecialchars($_POST['numTel']);

    $personne = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $idCoordonnees);
    $personne->setIdPersonne($idPersonne);
    $daoPersonne = new PersonneDAO();
    $daoPersonne->delete($personne);
    echo "La personne a bien été supprimée <a href=\"..\\..\\vue\\adherent.php\">Retour</a></p>";
}

//Condition pour modifier une personne
if (htmlspecialchars(isset($_POST['maj']))) {
    print_r($_POST);
    formulaireModifPersonnes();
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
    echo "La personne a bien été modifiée <a href=\"..\\..\\vue\\adherent.php\">Retour</a></p>";
}

if (htmlspecialchars(isset($_POST['passerAdh']))){
    
}

else {
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

function estAdherent($idPersonne){
    $daoAdherent = new AdherentDAO();
    if($daoAdherent->getAdherent($idPersonne)){
        $daoAdherent->read($idPersonne);
    }
}

?>