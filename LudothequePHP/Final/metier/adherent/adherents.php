<?php
namespace Adherent
{
           
    class Personne
    {
        private $idPersonne;

        private $nom;

        private $prenom;

        private $dateNaissance;

        private $numeroTelephone;

        private $mel;

        private $idCoordonnees;

        function __construct($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $idCoordonnees)
        {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->dateNaissance = $dateNaissance;
            $this->numeroTelephone = $numeroTelephone;
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

        private $dateAdhesion;

        // private $date_creation_groupe;
        private $dateFinAdhesion;

        private $beneficiaireAssocie;

       

        function __contruct($idReglement, $dateAdhesion, $dateFinAdhesion, $beneficiaireAssocie)
        {
            $this->idReglement = $idReglement;
            $this->dateAdhesion = $dateAdhesion;
            $this->dateFinAdhesion = $dateFinAdhesion;
            $this->beneficiaireAssocie = $beneficiaireAssocie;
            
        }
        
        public function getIdReglement()
        {
            return $this->idReglement;
        }
    
        public function getDateAdhesion()
        {
            return $this->dateAdhesion;
        }
    
        public function getDateFinAdhesion()
        {
            return $this->dateFinAdhesion;
        }
    
        public function getBeneficiaireAassocie()
        {
            return $this->beneficiaireAassocie;
        }
    
        public function setIdReglement($idReglement)
        {
            $this->idReglement = $idReglement;
        }
    
        public function setDateAdhesion($dateAdhesion)
        {
            $this->dateAdhesion = $dateAdhesion;
        }
    
        public function setDateFinAdhesion($dateFinAdhesion)
        {
            $this->dateFinAdhesion = $dateFinAdhesion;
        }
    
        public function setBeneficiaireAassocie($beneficiaireAassocie)
        {
            $this->beneficiaireAassocie = $beneficiaireAassocie;
        }
    
    }

    class Coordonnees
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