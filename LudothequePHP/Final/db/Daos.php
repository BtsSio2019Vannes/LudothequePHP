<?php
namespace DAO
{

    use DB\Connexion\Connexion;
    include ("../metier/Aero.php");

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
            
            /* Version à la main qui récupère le max de la clé, qui n'assure pas que ce soit la bonne clé !
            $sql = "SELECT Max($this->key) as max FROM $this->table";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->execute();

            $row = $stmt->fetch();
            $newKey = $row["max"];
            return $newKey;*/
        }
    }
}
// les espaces de noms ne peuvent être imbriqués, alors on simule
namespace DAO\Pilote
{

    use DB\Connexion\Connexion;

    class PiloteDAO extends \DAO\DAO
    {

        function __construct()
        {
            parent::__construct("NumPil", "PILOTE");
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
            $num = $row["NumPil"];
            $nom = $row["NomPil"];
            $adr = $row["ADR"];
            $sal = $row["sal"];
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new \Aero\Pilote\Pilote($nom, $adr, $sal);
            $rep->setNumPil($num);
            return $rep;
        }

        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET nomPil = :nom, Adr = :adr, sal = :sal  WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getNumPil();
            $nom = $objet->getNomPil();
            $adr = $objet->getAdr();
            $sal = $objet->getSal();
            $stmt->bindParam(':id', $num);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':adr', $adr);
            $stmt->bindParam(':sal', $sal);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getNumPil();
            $stmt->bindParam(':id', $num);
            $stmt->execute();
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nomPil,adr,sal) VALUES (:nom, :adr, :sal)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $nom = $objet->getNomPil();
            $adr = $objet->getAdr();
            $sal = $objet->getSal();
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':adr', $adr);
            $stmt->bindParam(':sal', $sal);
            $stmt->execute();
            $objet->setNumPil(parent::getLastKey());
        }

        static function getPilotes()
        {
            $sql = "SELECT * FROM PILOTE;";
            $rep = "<table class=\"table table-striped\">";
            foreach (Connexion::getInstance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["NumPil"] . "&nbsp;";
                $rep .= "</td><td>" . $row["NomPil"] . "&nbsp;";
                $rep .= "</td><td>" . $row["sal"] . "&nbsp;";
                $rep .= "</td><td>" . $row["ADR"] . "</td></tr><br/>";
            }
            return $rep . "</table>";
        }
    }
}
namespace DAO\Avion
{

    use DB\Connexion\Connexion;

    class AvionDAO extends \DAO\DAO
    {

        function __construct()
        {
            parent::__construct("id", "AVION");
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
            $num = $row["id"];
            $nom = $row["nom"];
            $cap = $row["cap"];
            $loc = $row["loc"];
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new \Aero\Avion\Avion($nom, $loc, $cap);
            $rep->setNumAv($num);
            return $rep;
        }

        public function update($objet)
        {}

        public function delete($objet)
        {}

        public function create($objet)
        {}
    }
}
namespace DAO\Vol
{

    use DB\Connexion\Connexion;

    class VolDAO extends \DAO\DAO
    {

        function __construct()
        {
            parent::__construct("NumVol", "VOL");
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
            $num = $row["numVol"];
            $numPil = $row["numPil"];
            $numAv = $row["numAv"];
            $vDep = $row["villeDep"];
            $vArr = $row["villeArr"];
            $dateDep = $row["dateDep"];
            $dateArr = $row["dateArr"];
            // echo "contenu de la base $num $nom $adr $sal ";
            $daoPilote = new \DAO\Pilote\PiloteDAO();
            $pil = $daoPilote->read($numPil);
            $daoAvion = new \DAO\Avion\AvionDAO();
            $av = $daoAvion->read($numAv);
            $rep = new \Aero\Vol\Vol($pil, $av, $dateDep, $dateArr, $vDep, $vArr);
            $rep->setNumVol($num);
            return $rep;
        }

        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET numPil = :numPil, numAv = :numAv, villeDep = :vDep, villeArr = :vArr,
			dateDep = :dDep, dateArr = :dArr WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getNumVol();
            $numPil = $objet->getPilote()->getNumPil();
            $numAv = $objet->getAvion()->getNumAv();
            $vDep = $objet->getVilleDep();
            $vArr = $objet->getVilleArr();
            $dDep = $objet->getDateDep();
            $dArr = $objet->getDateArr();
            $stmt->bindParam(':id', $num);
            $stmt->bindParam(':numPil', $numPil);
            $stmt->bindParam(':numAv', $numAv);
            $stmt->bindParam(':vDep', $vDep);
            $stmt->bindParam(':vArr', $vArr);
            $stmt->bindParam(':dArr', $dArr);
            $stmt->bindParam(':dDep', $dDep);
            $stmt->execute();
        }

        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $num = $objet->getNumVol();
            $stmt->bindParam(':id', $num);
            $stmt->execute();
        }

        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (numPil, numAv , villeDep, villeArr, dateDep, dateArr)
			VALUES (:numPil, :numAv, :vDep, :vArr, :dDep, :dArr)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $numPil = $objet->getPilote()->getNumPil();
            $numAv = $objet->getAvion()->getNumAv();
            $vDep = $objet->getVilleDep();
            $vArr = $objet->getVilleArr();
            $dDep = $objet->getDateDep();
            $dArr = $objet->getDateArr();
            $stmt->bindParam(':numPil', $numPil);
            $stmt->bindParam(':numAv', $numAv);
            $stmt->bindParam(':vDep', $vDep);
            $stmt->bindParam(':vArr', $vArr);
            $stmt->bindParam(':dArr', $dArr);
            $stmt->bindParam(':dDep', $dDep);
            $stmt->execute();
            $stmt->execute();
            $objet->setNumVol(parent::getLastKey());
        }
    }
}

?>