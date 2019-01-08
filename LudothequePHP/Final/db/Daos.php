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
    
    use DB\Connexion\Connexion;
    use Personne\Personne;
    
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
            
            $rep = new \Personne\Personne($idPersonne, $nom, $prenom, $dateNaissance, $idCoordonnees, $mel, $numeroTelephone, $idAdherent);
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
                $personne = new Personne($row["idPersonne"], $row["nom"], $row["prenom"], $row["dateNaissance"], $row["idCoordonnees"], $row["mel"], $row["numeroTelephone"]);
                $listePersonnes->append($personne);
            }
            return $listePersonnes;
        }
    }
}

?>