<?php
use Jeu\Jeu;
use DAO\Jeu\JeuDAO;
include '../vue/jeux/formulaireJeux.php';

if (htmlspecialchars(isset($_POST['ajouter un jeu']))) {
    
    $idRegle = htmlspecialchars($_POST['idRegle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);
    
    $jeu = new Jeu("", $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $dao = new JeuDAO();
    $dao->create($jeu);
    
    $messageErreur = "Erreur";
    $idRegle = isset($idRegle) && $idRegle != " " ? $idRegle : $messageErreur;
    $titre = isset($titre) && $titre != "" ? $titre : $messageErreur;
    $anneeSortie = isset($anneeSortie) && $anneeSortie != "" ? $anneeSortie : $messageErreur;
    $auteur = isset($auteur) && $auteur != "" ? $auteur : $messageErreur;
    $idEditeur = isset($idEditeur) && $idEditeur != "" ? $idEditeur : $messageErreur;
    $categorie = isset($categorie) && $categorie != "" ? $categorie : $messageErreur;
    $univers = isset($univers) && $univers != "" ? $univers : $messageErreur;
    $contenuInitial = isset($contenuInitial) && $contenuInitial != "" ? $contenuInitial : $messageErreur;
    
    echo "Le Jeu" . $titre . " " . "à bien été ajouté <a href =\"../vue/index.php?page=jeux\">Retour</a> ";
}
elseif (htmlspecialchars(isset($_POST['mettre à jour un jeu'])))
{
    formulaireMaj();
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $idRegle = htmlspecialchars($_POST['idRegle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);
    
    $jeu = new Jeu($idJeu, $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $dao = new JeuDAO();
    $dao->update($jeu);
    echo "Le jeu à bien été mis à jour <a href=\"../vue/index.php?page=jeux\">Retour</a></p>";
}
elseif (htmlspecialchars(isset($_POST['supprimer un jeu'])))
{
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $idRegle = htmlspecialchars($_POST['idRegle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);
    
    $jeu = new Jeu($idJeu, $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $jeu->setIdJeu($idJeu);
    $dao = new JeuDAO();
    $dao->delete($jeu);
    
    echo "Le jeu à bien été supprimé <a href=\"../vue/index.php?page=jeux\">Retour</a></p>";
}
else
{
    afficherJeu();
}


?>
		
