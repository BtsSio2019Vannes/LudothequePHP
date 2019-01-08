<?php
namespace DAO
{

    use BDD\ConnexionLudotheque\ConnexionLudotheque;   
    include ("ConnexionLudotheque.php");

    abstract class DAO
    {

        abstract function read($id);

        abstract function update($objet);

        abstract function delete($objet);

        abstract function create($objet);

        protected $key;

        protected $table;

        function __construct($key, $table)
        {
            $this->key = $key;
            $this->table = $table;
            
        }

        function getLastKey()
        {
            
            return ConnexionLudotheque::getInstance()->lastInsertId();
            
           
        }
    }
}

namespace DAO\Personne
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    use DAO;
    
    class PersonneDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idPersonne", "personne");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idPersonne)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idPersonne";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idPersonne = $row["idPersonne"];
            $nom = $row["nom"];
            $prenom = $row["prenom"];
            $dateNaissance = $row["dateNaissance"];
            $idCoordonnees = $row["idCoordonnees"];
            $mel = $row["mel"];
            $numeroTelephone = $row["numeroTelephone"];
            
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $idAdherent = $daoPersonne->retrouverAdherentAssocie($idPersonne);
            
            $rep = new \Ludotheque\Adherent\Personne($idPersonne, $nom, $prenom, $dateNaissance, $idCoordonnees, $mel, $numeroTelephone, $idAdherent);
            return $rep;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idPersonne = :idPersonne, nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, idCoordonnees = :idCoordonnees, mel = :mel, numeroTelephone = :numeroTelephone  WHERE $this->key=:idPersonne";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idPersonne = $objet->getIdPersonne();
            $nom = $objet->getNom();
            $prenom = $objet->getPrenom();
            $dateNaissance = $objet->getDateNaissance();
            $idCoordonnees = $objet->getIdCoordonnees();
            $mel = $objet->getMel();
            $numeroTelephone = $objet->getNumeroTelephone();
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':dateNaissance', $dateNaissance);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':numeroTelephone', $numeroTelephone);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idPersonne";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idPersonne = $objet->getIdPersonne();
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
            
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->supprimerBeneficiaire($idPersonne);
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom,prenom,dateNaissance,idCoordonnees,mel,numeroTelephone) VALUES (:nom, :prenom, :dateNaissance, :idCoordonnees, :mel, :numeroTelephone)";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $nom = $objet->getNom();
            $prenom = $objet->getPrenom();
            $dateNaissance = $objet->getDateNaissance();
            $idCoordonnees = $objet->getIdCoordonnees();
            $mel = $objet->getMel();
            $numeroTelephone = $objet->getNumeroTelephone();
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':dateNaissance', $dateNaissance);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':numeroTelephone', $numeroTelephone);
            $stmt->execute();
            $objet->setIdPersonne(parent::getLastKey());
        }
        
        static function getPersonnes()
        {
            $sql = "SELECT * FROM personne";
            $listePersonnes = new \ArrayObject();
            foreach (ConnexionLudotheque::getInstance()->query($sql) as $row) {
                $daoPersonne = new DAO\Personne\PersonneDAO();
                $personne = $daoPersonne->read($row["idPersonne"]);
                $listePersonnes->append($personne);
            }
            return $listePersonnes;
        }
    }
}

namespace DAO\Adherent
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    use DAO;
    
    class AdherentDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idAdherent", "adherent");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idAdherent)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idAdherent";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idAdherent = $row["idAdherent"];
            $idReglement = $row["idReglement"];
            $datePremiereAdhesion = $row["datePremiereAdhesion"];
            $dateFinAdhesion = $row["dateFinAdhesion"];
            $valeurCaution = $row["valeurCaution"];
            
            $adherent = new \DAO\Adherent\AdherentDAO($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution);
            
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $personne = $daoPersonne->read($idAdherent);
            
            $adherent->setIdPersonne($personne->getIdPersonne());
            $adherent->setNom($personne->getNom());
            $adherent->setPrenom($personne->getPrenom());
            $adherent->setDateNaissance($personne->getDateNaissance());
            $adherent->setIdCoordonnees($personne->getIdCoordonnees());
            $adherent->setMel($personne->getMel());
            $adherent->setNumeroTelephone($personne->getNumeroTelephone());
            
            return $adherent;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idAdherent = :idAdherent, idReglement = :idReglement, datePremiereAdhesion = :datePremiereAdhesion, dateFinAdhesion = :dateFinAdhesion, valeurCaution = :valeurCaution WHERE $this->key=:idAdherent";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idAdherent = $objet->getIdPersonne();
            $idReglement = $objet->getIdReglement();
            $datePremiereAdhesion = $objet->getDatePremiereAdhesion();
            $dateFinAdhesion = $objet->getDateFinAdhesion();
            $valeurCaution = $objet->getValeurCaution();
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->bindParam(':datePremiereAdhesion', $datePremiereAdhesion);
            $stmt->bindParam(':dateFinAdhesion', $dateFinAdhesion);
            $stmt->bindParam(':valeurCaution', $valeurCaution);
            $stmt->execute();
            
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->update($objet);
        }
        
        public function delete($objet)
        {
            $daoAdherent = new \DAO\Adherent\AdherentDAO();
            $idAdherent = $objet->getIdPersonne();
            $daoAdherent->supprimerAdherentEtBeneficiaire($idAdherent);
            
            $sql = "DELETE FROM $this->table WHERE $this->key=:idAdherent";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idAdherent = $objet->getIdPersonne();
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->execute();
            
            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->delete($objet);
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idAdherent,idReglement,datePremiereAdhesion,dateFinAdhesion,valeurCaution) VALUES (:idAdherent, :idReglement, :datePremiereAdhesion, :dateFinAdhesion, :valeurCaution)";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idAdherent = $objet->getIdPersonne();
            $idReglement = $objet->getIdReglement();
            $datePremiereAdhesion = $objet->getDatePremiereAdhesion();
            $dateFinAdhesion = $objet->getDateFinAdhesion();
            $valeurCaution = $objet->getValeurCaution();
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->bindParam(':datePremiereAdhesion', $datePremiereAdhesion);
            $stmt->bindParam(':dateFinAdhesion', $dateFinAdhesion);
            $stmt->bindParam(':valeurCaution', $valeurCaution);
            $stmt->execute();
        }
        
        static function getAdherents()
        {
            $sql = "SELECT * FROM personne, adherent WHERE idPersonne = idAdherent";
            $listeAdherents = new \ArrayObject();
            foreach (ConnexionLudotheque::getInstance()->query($sql) as $row) {
                $daoAdherent = new DAO\Adherent\AdherentDAO();
                $adherent = $daoAdherent->read($row["idAdherent"]);
                $listeAdherents->append($adherent);
            }
            return $listeAdherents;
        }
    }
}

namespace DAO\Coordonnees
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    
    class CoordonneesDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idCoordonnees", "coordonnees");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idCoordonnees)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idCoordonnees";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idCoordonnees = $row["idCoordonnees"];
            $rue = $row["rue"];
            $codePostal = $row["codePostal"];
            $ville = $row["ville"];
            
            $coordonnees = new \DAO\Coordonnees\CoordonneesDAO($idCoordonnees, $rue, $codePostal, $ville);
            
            return $coordonnees;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idCoordonnees = :idCoordonnees, rue = :rue, codePostal = :codePostal, ville = :ville WHERE $this->key=:idCoordonnees";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idCoordonnees = $objet->getIdCoordonnees();
            $rue = $objet->getRue();
            $codePostal = $objet->getCodePostal();
            $ville = $objet->getVille();
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->bindParam(':rue', $rue);
            $stmt->bindParam(':codePostal', $codePostal);
            $stmt->bindParam(':ville', $ville);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idAdherent";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idCoordonnees = $objet->getIdCoordonnees();
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (rue,codePostal,ville) VALUES (:rue, :codePostal, :ville)";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $rue = $objet->getRue();
            $codePostal = $objet->getCodePostal();
            $ville = $objet->getVille();
            $stmt->bindParam(':rue', $rue);
            $stmt->bindParam(':codePostal', $codePostal);
            $stmt->bindParam(':ville', $ville);
            $stmt->execute();
            $objet->setIdCoordonnees(parent::getLastKey());
        }
    }
}

namespace DAO\Reglement
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    
    class ReglementDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idReglement", "reglement");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idReglement)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idReglement";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idReglement = $row["idReglement"];
            $nbrJeux = $row["nbrJeux"];
            $duree = $row["duree"];
            $retardTolere = $row["retardTolere"];
            $valeurCaution = $row["valeurCaution"];
            $coutAdhesion = $row["coutAdhesion"];
            
            $reglement = new \Parametre\Reglement($idReglement, $nbrJeux, $duree, $retardTolere, $valeurCaution, $coutAdhesion);
            
            return $reglement;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idReglement = :idReglement, nbrJeux = :nbrJeux, duree = :duree, retardTolere = :retardTolere, valeurCaution = :valeurCaution, coutAdhesion = :coutAdhesion WHERE $this->key=:idReglement";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $nbrJeux = $objet->getNbrJeux();
            $duree = $objet->getDuree();
            $retardTolere = $objet->getRetardTolere();
            $valeurCaution = $objet->getValeurCaution();
            $coutAdhesion = $objet->getCoutAdhesion();
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->bindParam(':nbrJeux', $nbrJeux);
            $stmt->bindParam(':duree', $duree);
            $stmt->bindParam(':retardTolere', $retardTolere);
            $stmt->bindParam(':valeurCaution', $valeurCaution);
            $stmt->bindParam(':coutAdhesion', $coutAdhesion);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idReglement";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $stmt->bindParam(':idCoordonnees', $idReglement);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nbrJeux,duree,retardTolere,valeurCaution,coutAdhesion) VALUES (:nbrJeux, :duree, :retardTolere, :valeurCaution, :coutAdhesion)";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $nbrJeux = $objet->getNbrJeux();
            $duree = $objet->getDuree();
            $retardTolere = $objet->getRetardTolere();
            $valeurCaution = $objet->getValeurCaution();
            $coutAdhesion = $objet->getCoutAdhesion();
            $stmt->bindParam(':nbrJeux', $nbrJeux);
            $stmt->bindParam(':duree', $duree);
            $stmt->bindParam(':retardTolere', $retardTolere);
            $stmt->bindParam(':valeurCaution', $valeurCaution);
            $stmt->bindParam(':coutAdhesion', $coutAdhesion);
            $stmt->execute();
            $objet->setIdReglement(parent::getLastKey());
        }
    }
}

namespace DAO\Alerte
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    
    class AlerteDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idAlerte", "alerte");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idAlerte)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idAlerte";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idAlerte = $row["idAlerte"];
            $nom = $row["nom"];
            $dateRetour = $row["dateRetour"];
            $typeAlerte = $row["typeAlerte"];
            $commentaire = $row["commentaire"];
            
            $alerte = new \Jeu\Alerte($idAlerte, $nom, $dateRetour, $typeAlerte, $commentaire);
            
            return $alerte;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idAlerte = :idAlerte, nom = :nom, dateRetour = :dateRetour, typeAlerte = :typeAlerte, commentaire = :commentaire WHERE $this->key=:idAlerte";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idAlerte = $objet->getIdAlerte();
            $nom = $objet->getNom();
            $dateRetour = $objet->getDateRetour();
            $typeAlerte = $objet->getTypeAlerte();
            $commentaire = $objet->getCommentaire();
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':dateRetour', $dateRetour);
            $stmt->bindParam(':typeAlerte', $typeAlerte);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idAlerte";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $idAlerte = $objet->getIdAlerte();
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom,dateRetour,typeAlerte,commentaire) VALUES (:nom, :dateRetour, :typeAlerte, :commentaire)";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $nom = $objet->getNom();
            $dateRetour = $objet->getDateRetour();
            $typeAlerte = $objet->getTypeAlerte();
            $commentaire = $objet->getCommentaire();
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':dateRetour', $dateRetour);
            $stmt->bindParam(':typeAlerte', $typeAlerte);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->execute();
            $objet->setIdAlerte(parent::getLastKey());
        }
    }
}

?>