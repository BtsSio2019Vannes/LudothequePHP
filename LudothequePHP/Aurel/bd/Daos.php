<?php
namespace DAO
{

    use DB\Connexion\Connexion;
    include ("../metier/adherent/adherentsAB.php");

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
             * Version à la main qui récupère le max de la clé, qui n'assure pas que ce soit la bonne clé !
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

// les espaces de noms ne peuvent être imbriqués, alors on simule
namespace DAO\Personne
{

    use DB\Connexion\Connexion;
    use Adherent\Personne;

    class PersonneDAO extends \DAO\DAO
    {

        function __construct()
        {
            parent::__construct("idPersonne", "personne");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }

        public function read($id)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idPersonne = $row["idPersonne"];
            $nom = $row["nom"];
            $prenom = $row["prenom"];
            $dateNaissance = $row["dateNaissance"];
            $idCoordonnees = $row["idCoordonnees"];
            $mel = $row["mel"];
            $numeroTelephone = $row["numeroTelephone"];
            
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new Personne($nom, $prenom, $dateNaissance, $numeroTelephone, $mel, $idCoordonnees);
            $rep->setidPersonne($idPersonnes);
            return $rep;
        }

        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idPersonne = :idPersonne, nom = :nom, prenom = :prenom,
            dateNaissance = :dateNaissance, idCoordonnees = :idCoordonnees, mel = :mel, numeroTelephone = :numeroTelephone
            WHERE $this->key=:id";
            
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getIdPersonne();
            $nom = $objet->getIdAdhrent();
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
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getIdPersonne();
            $stmt->bindParam(':id', $idPersonne);
            $stmt->execute();
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idPersonne,nom,prenom,dateNaissance,idCoordonnees,mel,numeroTelephone)
             VALUES (:idPersonne, :nom, :prenom, :dateNaissance, :idCoordonnees, :mel, :numeroTelephone)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $nom = $objet->getNomPil();
            $adr = $objet->getAdr();
            $sal = $objet->getSal();
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':dateNaissance', $dateNaissance);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':numeroTelephone', $numeroTelephone);
            $stmt->execute();
            $objet->setNumPil(parent::getLastKey());
        }

        static function getPersonne()
        {
            $sql = "SELECT * FROM personne ORDER BY idPersonne ASC LIMIT 0, 25;";
            $rep = "<table class=\"table table-striped\">";
            //$rep = "<table>";
            foreach (Connexion::getInstance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idPersonne"] . "&nbsp;";
                $rep .= "</td><td>" . $row["nom"] . "&nbsp;";
                $rep .= "</td><td>" . $row["prenom"] . "&nbsp;";
                $rep .= "</td><td>" . $row["dateNaissance"] . "&nbsp;";
                $rep .= "</td><td>" . $row["mel"] . "&nbsp;";
                $rep .= "</td><td>" . $row["numeroTelephone"] . "&nbsp;";
                $rep .= "</td><td> <input type='radio' name= 'selection' value=" . $row["idPersonne"] ."/> </td></tr>";
            }
            return $rep . "</table>";
        }
    }
}

?>