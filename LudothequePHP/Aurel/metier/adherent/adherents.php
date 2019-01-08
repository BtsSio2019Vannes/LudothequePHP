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
        
        public function getIdPersonne()
        {
            return $this->idPersonne;
        }
    
        public function getNom()
        {
            return $this->nom;
        }
    
        public function getPrenom()
        {
            return $this->prenom;
        }
    
        public function getDateNaissance()
        {
            return $this->dateNaissance;
        }
    
        public function getNumeroTelephone()
        {
            return $this->numeroTelephone;
        }
    
        public function getMel()
        {
            return $this->mel;
        }
    
        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }
    
        public function setIdPersonne($idPersonne)
        {
            $this->idPersonne = $idPersonne;
        }
    
        public function setNom($nom)
        {
            $this->nom = $nom;
        }
    
        public function setPrenom($prenom)
        {
            $this->prenom = $prenom;
        }
    
        public function setDateNaissance($dateNaissance)
        {
            $this->dateNaissance = $dateNaissance;
        }
    
        public function setNumeroTelephone($numeroTelephone)
        {
            $this->numeroTelephone = $numeroTelephone;
        }
    
        public function setMel($mel)
        {
            $this->mel = $mel;
        }
    
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
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
        
        public function getIdReglement()
        {
            return $this->idReglement;
        }
    
        public function getDate_adhesion()
        {
            return $this->date_adhesion;
        }
    
        public function getDate_fin_adhesion()
        {
            return $this->date_fin_adhesion;
        }
    
        public function getBeneficiaire_associe()
        {
            return $this->beneficiaire_associe;
        }
    
        public function getIsAdherent()
        {
            return $this->isAdherent;
        }
    
        public function setIdReglement($idReglement)
        {
            $this->idReglement = $idReglement;
        }
    
        public function setDate_adhesion($date_adhesion)
        {
            $this->date_adhesion = $date_adhesion;
        }
    
        public function setDate_fin_adhesion($date_fin_adhesion)
        {
            $this->date_fin_adhesion = $date_fin_adhesion;
        }
    
        public function setBeneficiaire_associe($beneficiaire_associe)
        {
            $this->beneficiaire_associe = $beneficiaire_associe;
        }
    
        public function setIsAdherent($isAdherent)
        {
            $this->isAdherent = $isAdherent;
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
    
        public function getRue()
        {
            return $this->rue;
        }
    
        public function getCodePostal()
        {
            return $this->codePostal;
        }
    
        public function getVille()
        {
            return $this->ville;
        }
    
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }
    
        public function setRue($rue)
        {
            $this->rue = $rue;
        }
    
        public function setCodePostal($codePostal)
        {
            $this->codePostal = $codePostal;
        }
    
        public function setVille($ville)
        {
            $this->ville = $ville;
        }
    
    }
}

?>