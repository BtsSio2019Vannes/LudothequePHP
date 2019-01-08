<?php
namespace DAO
{

    use DB\Connexion\Connexion;
    include ("Connexion.php");

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
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }

        function getLastKey()
        {
            return Connexion::getInstance()->lastInsertId();

            /*
             * Version Ã  la main qui rÃ©cupÃ¨re le max de la clÃ©, qui n'assure pas que ce soit la bonne clÃ© !
             * $sql = "SELECT Max($this->key) as max FROM $this->table";
             * $stmt = Connexion::getInstance()->prepare($sql);
             * $stmt->execute();
             *
             * $row = $stmt->fetch();
             * $newKey = $row["max"];
             * return $newKey;
             */
        }
    }
}
// les espaces de noms ne peuvent Ãªtre imbriquÃ©s, alors on simule
namespace DAO\Personne
{

    use Connexion\Connexion;
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
            $stmt = Connexion::getInstance()->prepare($sql);
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

            $rep = new \Adherent\Personne($idPersonne, $nom, $prenom, $dateNaissance, $idCoordonnees, $mel, $numeroTelephone, $idAdherent);
            return $rep;
        }

        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idPersonne = :idPersonne, nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, idCoordonnees = :idCoordonnees, mel = :mel, numeroTelephone = :numeroTelephone  WHERE $this->key=:idPersonne";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idPersonne = $objet->getIdPersonne();
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();

            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->supprimerBeneficiaire($idPersonne);
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom,prenom,dateNaissance,idCoordonnees,mel,numeroTelephone) VALUES (:nom, :prenom, :dateNaissance, :idCoordonnees, :mel, :numeroTelephone)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            foreach (Connexion::getInstance()->query($sql) as $row) {
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

    use DB\Connexion\Connexion;
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->execute();

            $row = $stmt->fetch();
            $idAdherent = $row["idAdherent"];
            $idReglement = $row["idReglement"];
            $datePremiereAdhesion = $row["datePremiereAdhesion"];
            $dateFinAdhesion = $row["dateFinAdhesion"];
            $valeurCaution = $row["valeurCaution"];

            $adherent = new \Adherent\Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution);

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
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idAdherent = $objet->getIdPersonne();
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->execute();

            $daoPersonne = new \DAO\Personne\PersonneDAO();
            $daoPersonne->delete($objet);
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idAdherent,idReglement,datePremiereAdhesion,dateFinAdhesion,valeurCaution) VALUES (:idAdherent, :idReglement, :datePremiereAdhesion, :dateFinAdhesion, :valeurCaution)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            foreach (Connexion::getInstance()->query($sql) as $row) {
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

    use DB\Connexion\Connexion;

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
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();

            $row = $stmt->fetch();
            $idCoordonnees = $row["idCoordonnees"];
            $rue = $row["rue"];
            $codePostal = $row["codePostal"];
            $ville = $row["ville"];

            $coordonnees = new \Adherent\Coordonnees($idCoordonnees, $rue, $codePostal, $ville);

            return $coordonnees;
        }

        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idCoordonnees = :idCoordonnees, rue = :rue, codePostal = :codePostal, ville = :ville WHERE $this->key=:idCoordonnees";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idCoordonnees = $objet->getIdCoordonnees();
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idCoordonnees,rue,codePostal,ville) VALUES (:idCoordonnees, :rue, :codePostal, :ville)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
    }
}
namespace DAO\Reglement
{
    
    use DB\Connexion\Connexion;
    
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
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $stmt->bindParam(':idCoordonnees', $idReglement);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idReglement,nbrJeux,duree,retardTolere,valeurCaution,coutAdhesion) VALUES (:idReglement, :nbrJeux, :duree, :retardTolere, :valeurCaution, :coutAdhesion)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
    }
}
namespace DAO\Alerte
{
    
    use DB\Connexion\Connexion;
    
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idAlerte = $row["idAlerte"];
            $nom = $row["nom"];
            $dateRetour = $row["dateRetour"];
            $typeAlerte = $row["typeAlerte"];
            $commentaire = $row["commentaire"];
            
            $reglement = new \Emprunt\;
            
            return $reglement;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idReglement = :idReglement, nbrJeux = :nbrJeux, duree = :duree, retardTolere = :retardTolere, valeurCaution = :valeurCaution, coutAdhesion = :coutAdhesion WHERE $this->key=:idReglement";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $stmt->bindParam(':idCoordonnees', $idReglement);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idReglement,nbrJeux,duree,retardTolere,valeurCaution,coutAdhesion) VALUES (:idReglement, :nbrJeux, :duree, :retardTolere, :valeurCaution, :coutAdhesion)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
    }
}
?>
