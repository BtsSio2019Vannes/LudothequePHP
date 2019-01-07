<?php
namespace AdherentCS\Adherent
{

    use function AdherentCS\Adherent\Adherent\renouvelerAdhesion;
    use function AdherentCS\Adherent\Adherent\supprimerAdherent;
    use AdherentCS\Personne\Personne;
                                                                   
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

        /**
         *
         * @return number
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         *
         * @return mixed
         */
        public function getDatePremiereAdh()
        {
            return $this->datePremiereAdh;
        }

        /**
         *
         * @return mixed
         */
        public function getDateFinAdh()
        {
            return $this->dateFinAdh;
        }

        /**
         *
         * @return mixed
         */
        public function getValeurCaution()
        {
            return $this->valeurCaution;
        }

        /**
         *
         * @return mixed
         */
        public function getIdReglement()
        {
            return $this->idReglement;
        }

        /**
         *
         * @param number $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        function ajoutAdherent($id)
        {
            $adherent = new \Dao\Adherent\AdherentDAO($key, $table);
            
            
        }

        function supprimerAdherent()
        {
            foreach ($adh as $ad) {
                if (! $ad == renouvelerAdhesion()) {
                    echo "";
                }
                ;
            }
            echo "L'adherent a ete supprime";
        }

        function renouvelerAdhesion()
        {
            if ($adh == supprimerAdherent()) {
                echo "Ne pas proposer de renouvellement d'adhésion";
            } elseif (! $adh == supprimerAdh�rent()) {
                echo "Proposer une nouvellle adhésion";
            }
        }

        function __toString()
        {}
    }
}
namespace AdherentCS\Personne
{

   
use Dao;
                                
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
        
        
        /**
         * @return  <boolean, unknown>
         */
        public function getIsBenef()
        {
            return $this->isBenef;
        }
    
        /**
         * @return mixed
         */
        public function getIdPersonne()
        {
            return $this->IdPersonne;
        }
    
        /**
         * @return mixed
         */
        public function getNomPersonne()
        {
            return $this->nomPersonne;
        }
    
        /**
         * @return mixed
         */
        public function getPrenomPersonne()
        {
            return $this->prenomPersonne;
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
        public function getDateNaissance()
        {
            return $this->dateNaissance;
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
         * @param mixed $IdPersonne
         */
        public function setIdPersonne($IdPersonne)
        {
            $this->IdPersonne = $IdPersonne;
        }
    
        function ajouterPersonne()
        {
            $personne = new Dao\Personne\PersonneDAO($key, $table);
            
            
        }

        function proposerAdhesion()
        {
            ;
        }
        
    }
    
}




