<?php
use Adherent\Personne;
use DAO\Personne\PersonneDAO;
use Adherent\Coordonnees;
use DAO\Coordonnees\CoordonneesDAO;

include ("../../db/Daos.php");
include ("../../metier/adherent/adherents.php");
include ("../../db/Requetes.php");

/*
 * TODO
 * Voir les personnes de la ludo ainsi que les adhérents
 * Pouvoir ajouter une nouvelle personne et le passer adhérent
 * Modifier les infos d'une personne
 * Lier des personnes à un adhérent
 * Supprimer une personne
 */

// Condition ajouter personne
if (htmlspecialchars(isset($_POST['ajouter']))) {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $numeroTelephone = htmlspecialchars($_POST['numTel']);
    $mel = htmlspecialchars($_POST['mel']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);

    
    $coordonnees = new Coordonnees("", $rue , $codePostal, $ville);
    $daoCoordonnees = new CoordonneesDAO();
    $daoCoordonnees->create($coordonnees);

    if ($nom != "" && $prenom != "" && $dateNaissance != "" && $numeroTelephone != "" && $mel != "" && $rue != "" && $codePostal!= "" && $ville !="") {
        $personne = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $coordonnees);
        $daoPersonne = new PersonneDAO();
        $daoPersonne->create($personne);

        echo " <p><b>" . $nom ." ". $prenom . " a bien été ajouté!<a href=\"vue\adherent.php\">Retour</a></p>";
    }

    if ($nom = "" || $prenom = "" || $dateNaissance = "" || $numeroTelephone = "" || $mel = "" || $rue = "" || $codePostal= "" || $ville ="") {
        echo "Champs mal renseigné";
    }
}

if(htmlspecialchars(isset ($_POST['supprimer'])) && isset ($_POST['personne'])){
    $idPersonne = htmlspecialchars($_POST['personne']);
    $personne->read($idPersonne);
    $daoPersonne->delete($personne);
    echo "La personne a bien été supprimée";
}

if (htmlspecialchars(isset($_POST['Modifier Peronne'])) && isset ($_POST['personne'])) {
    $idPersonne = htmlspecialchars($_POST['personne']);
    $personne->read($idPersonne);
    $daoPersonne->update($personne);
    echo "La personne a bien été modifiée";
}

?>