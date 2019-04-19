<?php
include_once ("../metier/jeux.php");
include_once ("../db/Daos.php");
include_once ("../vue/jeux/formulaireJeuxPhysiques.php");
include_once ("../vue/jeux/formulaireJeux.php");
include_once ("../vue/jeux/formulaireEditeur.php");

use DAO\Jeu\JeuDAO;
use DAO\JeuPhysique\JeuPhysiqueDAO;
use DAO\Editeur\EditeurDAO;
use DAO\Coordonnees\CoordonneesDAO;
use Jeu\Jeu;
use Jeu\JeuPhysique;
use Jeu\Editeur;
use Adherent\Coordonnees;
?>

<h1>Gérer les Jeux</h1>
<?php

$daoJeu = new JeuDAO();
$daoJeuPhysique = new JeuPhysiqueDAO();
$daoEditeur = new EditeurDAO();
$daoCoordonnees = new CoordonneesDAO();
$messageErreur = "<button class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-remove-sign\"></span> Erreur de saisie !</button>";

/* Création de la liste des jeux */
$listeJeux = JeuDAO::getJeux();
$listeJeuxPhysiquesTries = JeuPhysiqueDAO::getJeuxPhysiquesTries();
$listeEditeurs = EditeurDAO::getEditeurs();

/* Affichage des formulaires en fonction des variables POST reçues */

/* Après clic sur bouton ajouter jeuPhysique */
if (htmlspecialchars(isset($_POST['nouveauJeuPhysique']))) {
    $jeuPhysique = new JeuPhysique("", "");
    afficherFormulaireJeuPhysique($jeuPhysique);
} /* Après clic sur bouton supprimer jeuPhysique */
else if (htmlspecialchars(isset($_POST['supprimerJeuPhysique'])) && htmlspecialchars(isset($_POST['idJeuPhysique']))) {
    $idJeuPhysique = htmlspecialchars($_POST['idJeuPhysique']);
    $jeuPhysique = $daoJeuPhysique->read($idJeuPhysique);
    $daoJeuPhysique->delete($jeuPhysique);
    echo "<p><b>Jeu bien supprimé !</b><br /><a href=\"index.php?page=jeux\">Retour</a></p>";
} /* Après clic sur bouton maj jeuPhysique */
else if (htmlspecialchars(isset($_POST['modifierJeuPhysique'])) && htmlspecialchars(isset($_POST['idJeuPhysique']))) {
    $idJeuPhysique = htmlspecialchars($_POST['idJeuPhysique']);
    $jeuPhysique = $daoJeuPhysique->read($idJeuPhysique);
    afficherFormulaireJeuPhysique($jeuPhysique);
} /* Après validation du formulaire jeuPhysique */
else if (htmlspecialchars(isset($_POST['formulaireAjoutJeuPhysique'])) || htmlspecialchars(isset($_POST['formulaireMajJeuPhysique']))) {

    $idJeuPhysique = htmlspecialchars(isset($_POST['idJeuPhysique'])) ? htmlspecialchars($_POST['idJeuPhysique']) : "";
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $contenuActuel = htmlspecialchars($_POST['contenuActuel']);
    $jeuPhysique = new JeuPhysique($idJeuPhysique, $contenuActuel);
    
    if (htmlspecialchars(isset($_POST['formulaireAjoutJeuPhysique']))) {
        $jeuPhysique->setIdJeu($idJeu);
    } else if (htmlspecialchars(isset($_POST['formulaireMajJeuPhysique']))) {
        $jeuPhysique = $daoJeuPhysique->read($idJeuPhysique);
        $jeuPhysique->setIdJeu($idJeu);
        $jeuPhysique->setContenuActuel($contenuActuel);
    }

    if ($idJeu != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjoutJeuPhysique']))) {
            $daoJeuPhysique->create($jeuPhysique);
            echo "<p><b>Jeu bien ajouté !</b><br /><a href=\"index.php?page=jeux\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMajJeuPhysique']))) {
            $daoJeuPhysique->update($jeuPhysique);
            echo "<p><b>Jeu bien mis à jour !</b><br /><a href=\"index.php?page=jeux\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireJeuPhysique($jeuPhysique);
    }
} /* Après clic sur bouton ajouter jeu */
else if (htmlspecialchars(isset($_POST['nouveauJeu']))) {
    $jeu = new Jeu("", "", "", "", new Editeur("", "", new Coordonnees("", "", "", "")), "", "", "");
    afficherFormulaireJeu($jeu);
} /* Après clic sur bouton supprimer jeu */
else if (htmlspecialchars(isset($_POST['supprimerJeu'])) && htmlspecialchars(isset($_POST['idJeu']))) {
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $jeu = $daoJeu->read($idJeu);
    $daoJeu->delete($jeu);
    echo "<p><b>Jeu bien supprimé !</b><br /><a href=\"index.php?page=jeux\">Retour</a></p>";
} /* Après clic sur bouton maj jeu */
else if (htmlspecialchars(isset($_POST['modifierJeu'])) && htmlspecialchars(isset($_POST['idJeu']))) {
    $idJeu = htmlspecialchars($_POST['idJeu']);
    $jeu = $daoJeu->read($idJeu);
    afficherFormulaireJeu($jeu);
} /* Après validation du formulaire jeu */
else if (htmlspecialchars(isset($_POST['formulaireAjoutJeu'])) || htmlspecialchars(isset($_POST['formulaireMajJeu']))) {
    
    $titre = htmlspecialchars($_POST['titre']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $univers = htmlspecialchars($_POST['univers']);
    $regle = htmlspecialchars($_POST['regle']);
    $contenuInitial = htmlspecialchars($_POST['contenuInitial']);
    $idJeu = htmlspecialchars(isset($_POST['idJeu'])) ? htmlspecialchars($_POST['idJeu']) : "";
    $auteur = htmlspecialchars($_POST['auteur']);
    $idEditeur = htmlspecialchars(isset($_POST['idEditeur'])) ? htmlspecialchars($_POST['idEditeur']) : "";
    $anneeSortie = htmlspecialchars($_POST['anneeSortie']);
    
    $editeur = $daoEditeur->read($idEditeur);

    $jeu = new Jeu($regle, $titre, $anneeSortie, $auteur, $editeur, $categorie, $univers, $contenuInitial);

    if ($titre != "" && $categorie != "" && $univers != "" && $regle != "" && $contenuInitial != "" && $auteur != "" && $idEditeur != "" && $anneeSortie != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjoutJeu']))) {
            $daoJeu->create($jeu);
            echo "<p><b>Jeu bien ajouté !</b><br /><a href=\"index.php?page=jeux&action=gererJeux\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMajJeu']))) {
            $daoJeu->update($jeu);
            echo "<p><b>Jeu bien mis à jour !</b><br /><a href=\"index.php?page=jeux&action=gererJeux\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireJeu($jeu);
    }
} /* Après clic sur bouton ajouter editeur */
else if (htmlspecialchars(isset($_POST['nouvelEditeur']))) {
    $editeur = new Editeur("", "", new Coordonnees("", "", "", ""));
    afficherFormulaireEditeur($editeur);
} /* Après clic sur bouton supprimer editeur */
else if (htmlspecialchars(isset($_POST['supprimerEditeur'])) && htmlspecialchars(isset($_POST['idEditeur']))) {
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $editeur = new Editeur($idEditeur, "", new Coordonnees("", "", "", ""));
    $daoEditeur->delete($editeur);
    echo "<p><b>Editeur bien supprimé !</b><br /><a href=\"index.php?page=jeux\">Retour</a></p>";
} /* Après clic sur bouton maj editeur */
else if (htmlspecialchars(isset($_POST['modifierEditeur'])) && htmlspecialchars(isset($_POST['idEditeur']))) {
    $idEditeur = htmlspecialchars($_POST['idEditeur']);
    $editeur = $daoEditeur->read($idEditeur);
    afficherFormulaireEditeur($editeur);
} /* Après validation du formulaire editeur */
else if (htmlspecialchars(isset($_POST['formulaireAjoutEditeur'])) || htmlspecialchars(isset($_POST['formulaireMajEditeur']))) {

    $idEditeur = htmlspecialchars(isset($_POST['idEditeur'])) ? htmlspecialchars($_POST['idEditeur']) : "";
    $nom = htmlspecialchars($_POST['nom']);
    $rue = htmlspecialchars($_POST['rue']);
    $codePostal = htmlspecialchars($_POST['codePostal']);
    $ville = htmlspecialchars($_POST['ville']);
    
    $coordonnees = new Coordonnees("", $rue, $codePostal, $ville);
    $editeur = new Editeur($idEditeur, $nom, $coordonnees);

    if ($nom != "" && $rue != "" && $codePostal != "" && $ville != "") {
        if (htmlspecialchars(isset($_POST['formulaireAjoutEditeur']))) {
            $daoCoordonnees->create($coordonnees);
            $daoEditeur->create($editeur);
            echo "<p><b>Editeur bien ajouté !</b><br /><a href=\"index.php?page=jeux&action=gererEditeur\">Retour</a></p>";
        } else if (htmlspecialchars(isset($_POST['formulaireMajEditeur']))) {
            $editeurBdd = $daoEditeur->read($idEditeur);
            $coordonneesBdd = $editeurBdd->getCoordonnees();
            if ($coordonneesBdd->getRue() == $coordonnees->getRue() && $coordonneesBdd->getCodePostal() == $coordonnees->getCodePostal() && $coordonneesBdd->getVille() == $coordonnees->getVille()) {
                $editeur->setCoordonnees($coordonneesBdd);
            } else {
                $daoCoordonnees->create($coordonnees);
            }
                $daoEditeur->update($editeur);
            echo "<p><b>Editeur bien mis à jour !</b><br /><a href=\"index.php?page=jeux&action=gererEditeur\">Retour</a></p>";
        }
    } else {
        echo $messageErreur;
        afficherFormulaireEditeur($editeur);
    }
} /* Accès liste jeux ou editeurs */
else if (htmlspecialchars(isset($_GET['action']))) {
    $action = htmlspecialchars($_GET['action']);
    if ($action == "gererJeux") {
        afficherGestionJeu($listeJeux);
    }   else if ($action == "gererEditeurs") {
        afficherGestionEditeur($listeEditeurs);
    } else {
        afficherGestionJeuPhysique($listeJeuxPhysiquesTries);
    }
} /*
   * Sinon afficher
   * liste jeux physiques
   */
else {
    afficherGestionJeuPhysique($listeJeuxPhysiquesTries);
}
?>
