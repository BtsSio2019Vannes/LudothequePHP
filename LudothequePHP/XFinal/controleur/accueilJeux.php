<?php
use Jeu\Jeu;
use DAO\Jeu\JeuDAO;
?>
<section>
		<h1>Gérer les Jeux</h1>

<?php
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
}
elseif (htmlspecialchars(isset($_POST['mettre à jour un jeu'])))
{
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
}
elseif (htmlspecialchars(isset($_POST['supprimer un jeu'])))
{
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $jeu = new Jeu($idJeu, $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
    $jeu->setIdJeu($idJeu);
    $dao = new JeuDAO();
    $dao->delete($jeu);
}
else
{
    afficherJeu();
}


?>
		
</section>