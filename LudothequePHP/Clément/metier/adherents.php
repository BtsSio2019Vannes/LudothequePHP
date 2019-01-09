<?php

namespace Adherent\Personne
{
    
    
    
    class Personne
    {
        
        private $isBenef = FALSE;
        
        private $IdPersonne;
        
        private $nomPersonne;
        
        private $prenomPersonne;
        
        private $idCoordonnees;
        
        private $dateNaissance;
        
        private $mel;
        
        private $numeroTelephone;
        
        function __construct($idPersonne, $isBenef, $nomPersonne, $idCoordonnees, $dateNaissance, $prenomPersonne, $mel, $numeroTelephone)
        {
            $this->IdPersonne = $idPersonne;
            $this->isBenef = $isBenef;
            $this->nomPersonne = $nomPersonne;
            $this->prenomPersonne = $prenomPersonne;
            $this->coordonnees = $idCoordonnees;
            $this->dateNaissance = $dateNaissance;
            $this->mel = $mel;
            $this->numeroTelephone = $numeroTelephone;
        }
        
        
        
        public function getIsBenef()
        {
            return $this->isBenef;
        }
        
        
        public function getIdPersonne()
        {
            return $this->IdPersonne;
        }
        
        
        public function getNomPersonne()
        {
            return $this->nomPersonne;
        }
        
        
        public function getPrenomPersonne()
        {
            return $this->prenomPersonne;
        }
        
        
        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }
        
        
        public function getDateNaissance()
        {
            return $this->dateNaissance;
        }
        
        
        public function getMel()
        {
            return $this->mel;
        }
        
        
        public function getNumeroTelephone()
        {
            return $this->numeroTelephone;
        }
        
        
        public function setIdPersonne($IdPersonne)
        {
            $this->IdPersonne = $IdPersonne;
        }
        
        public function setNomPersonne($nomPersonne)
        {
            $this->nomPersonne = $nomPersonne;
        }
        
        
        public function setPrenomPersonne($prenomPersonne)
        {
            $this->prenomPersonne = $prenomPersonne;
        }
        
        
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }
        
        
        public function setDateNaissance($dateNaissance)
        {
            $this->dateNaissance = $dateNaissance;
        }
        
        
        public function setMel($mel)
        {
            $this->mel = $mel;
        }
        
        
        public function setNumeroTelephone($numeroTelephone)
        {
            $this->numeroTelephone = $numeroTelephone;
        }
        
        
        
    }
    class Coordonnees {
        
        private $idCoordonnees=0;
        private $rue;
        private $codePostal;
        private $ville;
        
        function __construct($idCoordonnees,$rue,$codePostal,$ville) {
            $this->idCoordonnees=$idCoordonnees;
            $this->rue=$rue;
            $this->codePostal=$codePostal;
            $this->ville=$ville;
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
namespace Adherent\Adherent
{

    use Adherent\Personne;
    
    
    
    class Adherent extends Personne
    {
        
        private $adh = array();
        
        private $nom = "";
        
        private $id = 0;
        
        private $datePremiereAdh;
        
        private $dateFinAdh;
        
        private $isAdh = False;
        
        private $valeurCaution;
        
        private $idReglement;
        
        function __construct($valeurCaution, $idReglement, $dateFinAdh, $datePremiereAdh)
        {
            $this->valeurCaution = $valeurCaution;
            $this->idReglement = $idReglement;
            $this->dateFinAdhAdh = $dateFinAdh;
            $this->datePremiereAdh = $datePremiereAdh;
        }
        
        
        public function getId()
        {
            return $this->id;
        }
        
        
        public function getDatePremiereAdh()
        {
            return $this->datePremiereAdh;
        }
        
        
        public function getDateFinAdh()
        {
            return $this->dateFinAdh;
        }
        
        
        public function getValeurCaution()
        {
            return $this->valeurCaution;
        }
        
        
        public function getIdReglement()
        {
            return $this->idReglement;
        }
        
        
        public function setId($id)
        {
            $this->id = $id;
        }
        
        public function setDatePremiereAdh($datePremiereAdh)
        {
            $this->datePremiereAdh = $datePremiereAdh;
        }
        
        
        public function setDateFinAdh($dateFinAdh)
        {
            $this->dateFinAdh = $dateFinAdh;
        }
        
        
        
        public function setValeurCaution($valeurCaution)
        {
            $this->valeurCaution = $valeurCaution;
        }
        
        
        public function setIdReglement($idReglement)
        {
            $this->idReglement = $idReglement;
        }
        
        
        
        
    }
}



