<?php
use Jeu\Jeu;
use DAO\Jeu\JeuDAO;
include_once '../vue/jeux/formulaireJeux.php';

if (htmlspecialchars(isset($_POST['ajouter']))) {
    afficherFormulaireAjout();
    
} elseif (htmlspecialchars(isset($_POST['ajouter']))) {

    $Regle = htmlspecialchars($_POST['Regle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);

    $jeu = new Jeu("", $Regle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $dao = new JeuDAO();
    $dao->create($jeu);

    $messageErreur = "Erreur";
    $Regle = isset($Regle) && $Regle != " " ? $Regle : $messageErreur;
    $titre = isset($titre) && $titre != "" ? $titre : $messageErreur;
    $anneeSortie = isset($anneeSortie) && $anneeSortie != "" ? $anneeSortie : $messageErreur;
    $auteur = isset($auteur) && $auteur != "" ? $auteur : $messageErreur;
    $idEditeur = isset($idEditeur) && $idEditeur != "" ? $idEditeur : $messageErreur;
    $categorie = isset($categorie) && $categorie != "" ? $categorie : $messageErreur;
    $univers = isset($univers) && $univers != "" ? $univers : $messageErreur;
    $contenuInitial = isset($contenuInitial) && $contenuInitial != "" ? $contenuInitial : $messageErreur;

    echo "Le Jeu" . $titre . " " . "à bien été ajouté <a href =\"../vue/index.php?page=jeux\">Retour</a> ";
} elseif (htmlspecialchars(isset($_POST['miseaJour']))) {
    formulaireMaj();
    
} elseif (htmlspecialchars(isset($_POST['maj']))){
    
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $Regle = htmlspecialchars($_POST['Regle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneeSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);
    
    $jeu = new Jeu($idJeu, $Regle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $dao = new JeuDAO();
    $dao->update($jeu);
    echo "Le jeu à bien été mis à jour <a href=\"../vue/index.php?page=jeux\">Retour</a></p>";
}
    
 elseif (htmlspecialchars(isset($_POST['supprimer']))) {
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $Regle = htmlspecialchars($_POST['Regle']);
    $titre = htmlspecialchars($_POST['titre']);
    $anneeSortie = htmlspecialchars($_POST['anneSortie']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);

    $jeu = new Jeu($idJeu, $Regle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $jeu->setIdJeu($idJeu);
    $dao = new JeuDAO();
    $dao->delete($jeu);

    echo "Le jeu à bien été supprimé <a href=\"../vue/index.php?page=jeux\">Retour</a></p>";
} else {
    afficherJeu();
}

?>
		
