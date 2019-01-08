<?php

namespace Jeu
{
    
    class Jeu {
        
        private $idJeu =0;
        
        private $idRegle = 0;
        
        private $titre = "";
        
        private $anneeSortie;
        
        private $auteur;
        
        private $idEditeur=0;
        
        private $categorie;
        
        private $univers;
        
        private $contenuInitial;
        
        
        function __construct($idJeu,$idRegle,$titre,$anneeSortie,$auteur,$idEditeur,$categorie,$univers,$contenuInitial) {
            $this->idJeu= $idJeu;
            $this->idRegle= $idRegle;
            $this->titre= $titre;
            $this->anneeSortie= $anneeSortie;
            $this->auteur=$auteur;
            $this->idEditeur=$idEditeur;
            $this->categorie=$categorie;
            $this->univers=$univers;
            $this->contenuInitial=$contenuInitial;
        }
        
        public function getIdJeu()
        {
            return $this->idJeu;
        }
    
        
        public function getIdRegle()
        {
            return $this->idRegle;
        }
    
        
        public function getTitre()
        {
            return $this->titre;
        }
    
        
        public function getAnneeSortie()
        {
            return $this->anneeSortie;
        }
    
        
        public function getAuteur()
        {
            return $this->auteur;
        }
    
        
        public function getIdEditeur()
        {
            return $this->idediteur;
        }
    
        public function getCategorie()
        {
            return $this->categorie;
        }
    
        
        public function getUnivers()
        {
            return $this->univers;
        }
    
        
        public function getContenuInitial()
        {
            return $this->contenuInitial;
        }
    
        
        public function setIdJeu($idJeu)
        {
            $this->idJeu = $idJeu;
        }
        
        public function setIdRegle($idRegle)
        {
            $this->idRegle = $idRegle;
        }
    
        
        public function setTitre($titre)
        {
            $this->titre = $titre;
        }
    
        
        public function setAnneeSortie($anneeSortie)
        {
            $this->anneeSortie = $anneeSortie;
        }
    
        
        public function setAuteur($auteur)
        {
            $this->auteur = $auteur;
        }
    
        
        public function setIdEditeur($idEditeur)
        {
            $this->idEditeur = $idEditeur;
        }
    
        
        public function setCategorie($categorie)
        {
            $this->categorie = $categorie;
        }
    
        
        public function setUnivers($univers)
        {
            $this->univers = $univers;
        }
    
        
        public function setContenuInitial($contenuInitial)
        {
            $this->contenuInitial = $contenuInitial;
        }
    
    
                   
        
    }
    class Editeur {
        private $idEditeur=0;
        private $nom;
        private $idCoordonnees;
        
        function __construct($idEditeur,$nom,$idCoordonnees) {
            $this->idEditeur=$idEditeur;
            $this->nom=$nom;
            $this->idCoordonnees=$idCoordonnees;
        }
        
        public function getIdEditeur()
        {
            return $this->idEditeur;
        }
    
        
        public function getNom()
        {
            return $this->nom;
        }
    
        
        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }
    
        
        public function setIdEditeur($idEditeur)
        {
            $this->idEditeur = $idEditeur;
        }
    
        
        public function setNom($nom)
        {
            $this->nom = $nom;
        }
    
        
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }
    
        
    }
    class Alerte {
        private $idAlerte=0;
        private $nom;
        private $dateRetour;
        private $typeAlerte;
        private $commentaire;
        
        
        function __construct($idAlerte,$nom,$dateRetour,$typeAlerte,$commentaire) {
            $this->idAlerte=$idAlerte;
            $this->nom=$nom;
            $this->dateRetour=$dateRetour;
            $this->typeAlerte=$typeAlerte;
            $this->commentaire=$commentaire;
        }
        
        public function getIdAlerte()
        {
            return $this->idAlerte;
        }
    
        
        public function getNom()
        {
            return $this->nom;
        }
    
        
        public function getDateRetour()
        {
            return $this->dateRetour;
        }
    
        
        public function getTypeAlerte()
        {
            return $this->typeAlerte;
        }
    
        
        public function getCommentaire()
        {
            return $this->commentaire;
        }
    
        
        public function setIdAlerte($idAlerte)
        {
            $this->idAlerte = $idAlerte;
        }
    
        
        public function setNom($nom)
        {
            $this->nom = $nom;
        }
    
        
        public function setDateRetour($dateRetour)
        {
            $this->dateRetour = $dateRetour;
        }
    
        
        public function setTypeAlerte($typeAlerte)
        {
            $this->typeAlerte = $typeAlerte;
        }
    
        
        public function setCommentaire($commentaire)
        {
            $this->commentaire = $commentaire;
        }
    
        
    }
    class TypeAlerte {
        private $designation;
        
        function __construct($designation) {
            $this->designation=$designation;
        }
        
        public function getDesignation()
        {
            return $this->designation;
        }
    
        
        public function setDesignation($designation)
        {
            $this->designation = $designation;
        }
    
        
    }
      
}
namespace JeuPhysique
{
    use Jeu\Jeu;
    
    class JeuPhysique extends Jeu {
        
        private $idJeuPhysique=0;
        private $idJeu = 0;
        private $contenuActuel;
        
        function __construct($idJeuPhysique,$idJeu,$contenuActuel) {
            $this->idJeuPhysique=$idJeuPhysique;
            $this->idJeu=$idJeu;
            $this->contenuActuel=$contenuActuel;
        }
        
        public function getIdJeuPhysique()
        {
            return $this->idJeuPhysique;
        }
    
        
        public function getIdJeu()
        {
            return $this->idJeu;
        }
    
        
        public function getContenuActuel()
        {
            return $this->contenuActuel;
        }
    
        
        public function setIdJeuPhysique($idJeuPhysique)
        {
            $this->idJeuPhysique = $idJeuPhysique;
        }
        
        public function setIdJeu($idJeu)
        {
            $this->idJeu = $idJeu;
        }
    
        
        public function setContenuActuel($contenuActuel)
        {
            $this->contenuActuel = $contenuActuel;
        }
    
        
        
        
        
    }
}

?>