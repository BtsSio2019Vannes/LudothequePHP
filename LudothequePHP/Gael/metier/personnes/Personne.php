<?php
namespace Personne
{

    include ("../db/Daos.php");

    class Personne
    {

        private $idPersonne = "";

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
            $this->numeroTelephone = $numeroTelephone;
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

        public function getIdCoordonnees()
        {
            return $this->idCoordonnees;
        }
        
        public function getMel()
        {
            return $this->mel;
        }

        public function getNumeroTelephone()
        {
            return $this->numeroTelephone;
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

        public function setIdCoordonnees($idCoordonnees)
        {
            $this->idCoordonnees = $idCoordonnees;
        }
        
        public function setMel($mel)
        {
            $this->mel = $mel;
        }

        public function setNumeroTelephone($numeroTelephone)
        {
            $this->numeroTelephone = $numeroTelephone;
        }

        public function identifierPersonne()
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $personne = $daoPersonne->read($this->idPersonne);

            return $personne;
        }

        public function ajouterPersonne()
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->create($this);
        }

        public function supprimerPersonne()
        {
            $adherent = $this->identifierAdherent();
            if ($adherent->getIdPersonne() == $this->getIdPersonne()) {
                $daoAdherent = new \DAO\Adherent\AdherentDAO();
                $daoAdherent->delete($this);
            }
            else {
                $daoPersonne = new \DAO\Personne\PersonneDAO();
                $daoPersonne->delete($this);
            }
            
        }

        public function mettreAJourPersonne()
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->update($this);
        }
        
        public function identifierAdherent()
        {
            $daoAdherent = new \DAO\Adherent\AdherentDAO();
            $adherent = $daoAdherent->read($this->idPersonne);
            return $adherent;
        }
        
        public function passerAdherent()
        {
            $daoAdherent = new \DAO\Adherent\AdherentDAO();
            $daoAdherent->create($this);
        }
        
        public function associerAdherent($idAdherent)
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->ajouterBeneficiaire($idAdherent, $this->getIdPersonne());
        }
        
        public function retrouverAdherentAssocie()
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $adherent = $daoPersonne->retrouverAdherentAssocie($this->getIdPersonne());
            return $adherent;
        }
        
        public function supprimerBeneficiaire()
        {
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->supprimerBeneficiaire($this->getIdPersonne());
        }
    }
}
namespace Personne\Adherent
{

    use Personne\Personne;

    class Adherent extends Personne
    {

        private $idReglement;

        private $datePremiereAdhesion;
        
        private $dateFinAdhesion;

        private $valeurCaution;

        
        function __construct($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution)
        {
            $this->idReglement = $idReglement;
            $this->datePremiereAdhesion = $datePremiereAdhesion;
            $this->dateFinAdhesion = $dateFinAdhesion;
            $this->valeurCaution = $valeurCaution;
        }

        public function getIdReglement()
        {
            return $this->idReglement;
        }

        public function getDatePremiereAdhesion()
        {
            return $this->datePremiereAdhesion;
        }
        
        public function getDateFinAdhesion()
        {
            return $this->dateFinAdhesion;
        }

        public function getValeurCaution()
        {
            return $this->valeurCaution;
        }

        public function setIdReglement($idReglement)
        {
            $this->idReglement = $idReglement;
        }

        public function setDatePremiereAdhesion($datePremiereAdhesion)
        {
            $this->datePremiereAdhesion = $datePremiereAdhesion;
        }
        
        public function setDateFinAdhesion($dateFinAdhesion)
        {
            $this->dateFinAdhesion = $dateFinAdhesion;
        }
        
        public function setValeurCaution($valeurCaution)
        {
            $this->valeurCaution = $valeurCaution;
        }
        
        public function retrouverBeneficiaire()
        {
            $daoAdherent = new \DAO\Adherent\AdherentDAO();
            $personne = $daoAdherent->retrouverBeneficiaire($this->getIdPersonne());
            return $personne;
        }
        
        public function renouvelerAdhesion()
        {
            $daoAdherent = new \DAO\Adherent\AdherentDAO();
            $adherent = $daoAdherent->read($this->idAdherent);
            $dateFinAdhesion = $adherent->getDateFinAdhesion();
            $dateFinAdhesion = date('Y-m-d', strtotime("$dateFinAdhesion +1 year"));
            $adherent->setDateFinAdhesion($dateFinAdhesion);
            $daoAdherent->update($adherent);
        }
        
    }
}
?>