<?php
namespace Ludotheque\Adherent{

    class Personne
{

        private $idPersonne;

        private $nom;

        private $prenom;

        private $dateNaissance;

        private $idCoordonnees;

        private $mel;

        private $numeroTelephone;
        
        
        function __construct($idPersonne, $nom, $prenom, $dateNaissance, $idCoordonnees, $mel, $numeroTelephone)
        {
            $this->idPersonne = $idPersonne;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->dateNaissance = $dateNaissance;
            $this->idCoordonnees = $idCoordonnees;
            $this->mel = $mel;
        }

        /**
         *
         * @return mixed
         */
        public function getIdPersonne()
        {
            return $this->idPersonne;
        }

        /**
         *
         * @return mixed
         */
        public function getNom()
        {
            return $this->nom;
        }

        /**
         *
         * @return mixed
         */
        public function getPrenom()
        {
            return $this->prenom;
        }

        /**
         *
         * @return mixed
         */
        public function getDateNaissance()
        {
            return $this->dateNaissance;
        }

        /**
         *
         * @return mixed
         */
        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }

        /**
         *
         * @return mixed
         */
        public function getMel()
        {
            return $this->mel;
        }

        /**
         *
         * @return mixed
         */
        public function getNumeroTelephone()
        {
            return $this->numeroTelephone;
        }

        /**
         *
         * @param mixed $idPersonne
         */
        public function setIdPersonne($idPersonne)
        {
            $this->idPersonne = $idPersonne;
        }

        /**
         *
         * @param mixed $nom
         */
        public function setNom($nom)
        {
            $this->nom = $nom;
        }

        /**
         *
         * @param mixed $prenom
         */
        public function setPrenom($prenom)
        {
            $this->prenom = $prenom;
        }

        /**
         *
         * @param mixed $dateNaissance
         */
        public function setDateNaissance($dateNaissance)
        {
            $this->dateNaissance = $dateNaissance;
        }

        /**
         *
         * @param mixed $idCoordonnees
         */
        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }

        /**
         *
         * @param mixed $mel
         */
        public function setMel($mel)
        {
            $this->mel = $mel;
        }

        /**
         *
         * @param mixed $numeroTelephone
         */
        public function setNumeroTelephone($numeroTelephone)
        {
            $this->numeroTelephone = $numeroTelephone;
        }

       
    }

    class Adherent extends Personne
    {

        private $idReglement;

        private $dateAdhesion;

        // private $date_creation_groupe;
        private $dateFinAdhesion;

        private $beneficiaireAassocie = array();

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