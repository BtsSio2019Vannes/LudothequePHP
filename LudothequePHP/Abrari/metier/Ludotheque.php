<?php
namespace Ludotheque\Personne {
    
    class Personne {
        private $idPersonne;
        private $nom;
        private $prenom;
        private $dateNaissance;
        private $idCoordonnees;
        private $mel;
        private $numeroTelephone;
        
        /**
         * @return mixed
         */
        public function getIdPersonne()
        {
            return $this->idPersonne;
        }
    
        /**
         * @return mixed
         */
        public function getNom()
        {
            return $this->nom;
        }
    
        /**
         * @return mixed
         */
        public function getPrenom()
        {
            return $this->prenom;
        }
    
        /**
         * @return mixed
         */
        public function getDateNaissance()
        {
            return $this->dateNaissance;
        }
    
        /**
         * @return mixed
         */
        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }
    
        /**
         * @return mixed
         */
        public function getMel()
        {
            return $this->mel;
        }
    
        /**
         * @return mixed
         */
        public function getNumeroTelephone()
        {
            return $this->numeroTelephone;
        }
    
        /**
         * @param mixed $idPersonne
         */
        public function setIdPersonne($idPersonne)
        {
            $this->idPersonne = $idPersonne;
        }
    
        /**
         * @param mixed $nom
         */
        public function setNom($nom)
        {
            $this->nom = $nom;
        }
    
        /**
         * @param mixed $prenom
         */
        public function setPrenom($prenom)
        {
            $this->prenom = $prenom;
        }
    
        /**
         * @param mixed $dateNaissance
         */
        public function setDateNaissance($dateNaissance)
        {
            $this->dateNaissance = $dateNaissance;
        }
    
        /**
         * @param mixed $idCoordonnees
         */
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }
    
        /**
         * @param mixed $mel
         */
        public function setMel($mel)
        {
            $this->mel = $mel;
        }
    
        /**
         * @param mixed $numeroTelephone
         */
        public function setNumeroTelephone($numeroTelephone)
        {
            $this->numeroTelephone = $numeroTelephone;
        }
    
        function __construct($idPersonne,$nom,$prenom,$dateNaissance,$idCoordonnees,$mel,$numeroTelephone) {
            $this->idPersonne = $idPersonne;
            $this->nom = $nom;
            $this->prenom= $prenom;
            $this->dateNaissance=$dateNaissance;
            $this->idCoordonnees=$idCoordonnees;
            $this->mel=$mel;
        }
        
        function __toString() {
            $rep = "<div class=\"personne\">$this->idPersonne $this->nom $this->prenom $this->dateNaissance $this->idCoordonnees $this->mel</div>";
            return $rep;
        }
       

    }
    
}
namespace Ludotheque\Emprunt {
    
    class Emprunt {
        private $dateEmprunt;
        private $dateRetour;
        
    }
    }

namespace Luudotheque\Jeux{
    
    class Jeux{
        private $titre;
        private $auteur;
        private $categorie;
        private $anneeSortie;
        
    }
        
        
        
    }
?>