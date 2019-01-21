<?php
use Adherent\Personne;
use DAO\Personne\PersonneDAO;
use Adherent\Coordonnees;
use DAO\Coordonnees\CoordonneesDAO;
use Jeu\Jeu;

include ("../../db/Daos.php");
include ("../../metier/jeux/jeux.php");
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

    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneeSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $editeur= htmlspecialchars($_POST['editeur']);
    $contenuInitial='Complet';
    
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);
    
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    
    

    
    $coordonnees = new Coordonnees("", $rue , $codePostal, $ville);
    $daoCoordonnees = new CoordonneesDAO();
    $daoCoordonnees->create($coordonnees);

    if ($titre != "" && $anneeSortie != "" && $auteur != "" && $editeur != "" && $categorie != "" && $univers != ""  && $rue != "" && $codePostal!= "" && $ville !="") {
        $jeu = new Jeu($idRegle, $titre, $anneeSortie, $auteur, $editeur, $categorie, $univers, $coordonnees, $contenuInitial);
        $daoPersonne = new PersonneDAO();
        $daoPersonne->create($jeu);

        echo " <p><b> Le jeu " . $titre . " a bien été ajouté!<a href=\"vue\jeux.php\">Retour</a></p>";
    }

    if ($titre = "" || $anneeSortie = "" || $auteur = "" || $editeur = "" || $categorie =  "" ||  $univers = ""  || $rue = "" || $codePostal!= "" || $ville ="") {
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