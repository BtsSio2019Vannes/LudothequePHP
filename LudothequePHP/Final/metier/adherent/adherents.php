<?php
namespace Adherent
{
           
    class Personne
    {
        private $idPersonne;

        private $nom = "";

        private $prenom = "";

        private $dateNaissance;

        private $numeroTelephone;

        private $mel = "";

        private $idCoordonnees;

        function __construct($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $idCoordonnees)
        {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->date_naissance = $date_naissance;
            $this->numero_telephone = $numero_telephone;
            $this->mel = $mel;
            $this->idCoordonnees = $idCoordonnees;
        }

        public function getNom()
        {
            return $this->nom;
        }

        public function setNom()
        {
            $this->nom = $nom;
            return $this;
        }

        public function getPrenom()
        {
            return $this->prenom;
        }

        public function setPrenom()
        {
            $this->prenom = $prenom;
            return $this;
        }

        public function getDateNaissance()
        {
            return $this->date_naissance;
        }

        public function setDateNaissance()
        {
            $this->date_naissance = $date_naissance;
            return $this;
        }

        public function getNumeroTelephone()
        {
            return $this->numero_telephone;
        }

        public function setNumeroTelephone()
        {
            $this->numero_telephone = $numero_telephone;
            return $this;
        }

        public function getMel()
        {
            return $this->mel;
        }

        public function setMel()
        {
            $this->mel = $mel;
            return $this;
        }

        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }

        public function setIdCoordonnees()
        {
            $this->idCoordonnees = $idCoordonnees;
            return $this;
        }
    }

    class Adherent extends Personne
    {

        private $idReglement;

        private $date_adhesion;

        // private $date_creation_groupe;
        private $date_fin_adhesion;

        private $beneficiaire_associe = array();

        private $isAdherent = false;

        function __contruct($idReglement, $date_adhesion, $date_fin_adhesion, $beneficiaire_associe, $isAdherent)
        {
            $this->idReglement = $idReglement;
            $this->date_adhesion = $date_adhesion;
            $this->date_fin_adhesion = $date_fin_adhesion;
            $this->beneficiaire_associe = $beneficiaire_associe;
            $this->isAdherent = $isAdherent;
        }

        public function getIdReglement(){
            return $this->idReglement;
        }
        
        public function setIdReglement(){
            $this->idReglement = $idReglement;
            return $this;
        }
        
        public function getDateAdhesion(){
            return $this->date_adhesion;
        }
        
        public function setDateAdhesion(){
            $this -> date_adhesion = $date_adhesion;
            return $this;
        }
        
        public function getDateFinAdhesion(){
            return $this->date_fin_adhesion;
        }
            
        public function setDateFinAdhesion(){
          $this->date_fin_adhesion = $date_fin_adhesion;
          return  $this;
        }
        
        public function getBeneficiaireAssocie(){
            return $this->beneficiaire_associe;
        }
            
        public function setBeneficiaireAssocie(){
            $this->beneficiaire_associe = $beneficiaire_associe;
            return $this;
        }
       
        function isAdherent()
        {
            return $isAdherent = true;
        }
    }

    class Coordonnees extends Personne
    {

        private $idCoordonnees;

        private $rue;

        private $codePostal;

        private $ville;

        function __construct($idCoordonnees, $rue, $codePostal, $ville)
        {
            $this->idCoordonnees = $idCoordonnees;
            $this->rue = $rue;
            $this->codePostal = $codePostal;
            $this->ville = $ville;
        }

        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }

        public function setIdCoordonnees()
        {
            $this->idCoordonnees = $idCoordonnees;
            return $this;
        }

        public function getRue()
        {
            return $this->rue;
        }

        public function setRue()
        {
            $this->rue = $rue;
            return $this;
        }

        public function getCodePostal()
        {
            return $this->codePostal;
        }

        public function setCodePostal()
        {
            $this->codePostal = $codePostal;
            return $this;
        }

        public function getVille()
        {
            return $this->ville;
        }

        public function setVille()
        {
            $this->ville = $ville;
            return $this;
        }
    }
}

?>