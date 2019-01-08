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
    use AdherentCS\Adherent\Adherent;

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
            $sql = "UPDATE $this->table SET idPersonne = :idPersonne, nom = :nom, prenom = :prenom,
            dateNaissance = :dateNaissance, idCoordonnees = :idCoordonnees, mel = :mel,
            numeroTelephone = :numeroTelephone  WHERE $this->key=:idPersonne";
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

        public function ajouterBeneficiaire($idAdherent, $idPersonne)
        {
            $sql = "INSERT INTO beneficiaire (idAdherent,idPersonne) VALUES (:idAdherent, :idPersonne)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
        }

        public function retrouverAdherentAssocie($idPersonne)
        {
            $sql = "SELECT * FROM adherent, personne, beneficiaire WHERE beneficiaire.idPersonne = " . $idPersonne . " AND beneficiaire.idAdherent = personne.idPersonne GROUP BY personne.idPersonne";
            $listeAdherents = new \ArrayObject();
            foreach (Connexion::getInstance()->query($sql) as $row) {
                $adherent = new Adherent($row['valeurCaution'], $row['idReglement'], $row['dateFinAdhesion'], $row['datePremiereAdhesion']);
                $adherent->setIdPersonne($row['idPersonne']);
                $adherent->setgetNom($row['nom']);
                $adherent->setPrenom($row['prenom']);
                $adherent->setDateNaissance($row['dateNaissance']);
                $adherent->setIdCoordonnees($row['idCoordonnees']);
                $adherent->setMel($row['mel']);
                $adherent->setNumeroTelephone($row['numeroTelephone']);
                $listeAdherents->append($adherent);
            }
            return $listeAdherents;

            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
            $rep = $stmt->fetch();

            $idAdherent = $rep[0];

            return $idAdherent;
        }

        public function supprimerBeneficiaire($idPersonne)
        {
            $sql = "DELETE FROM beneficiaire WHERE idPersonne = :idPersonne";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
        }
    }
}
namespace DAO\Adherent
{

    use DB\Connexion\Connexion;

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

            $adherent = new \Personne\Adherent\Adherent($idReglement, $datePremiereAdhesion, $dateFinAdhesion, $valeurCaution);

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
                $adherent = new \Personne\Personne($row["idPersonne"], $row["nom"], $row["prenom"], $row["dateNaissance"], $row["idCoordonnees"], $row["mel"], $row["numeroTelephone"]);
                $listeAdherents->append($adherent);
            }
            return $listeAdherents;
        }

        public function retrouverBeneficiaire($idAdherent)
        {
            $sql = "SELECT * FROM personne, beneficiaire WHERE idAdherent = " . $idAdherent . " AND beneficiaire.idPersonne = personne.idPersonne GROUP BY personne.idPersonne";
            $listeBeneficiaires = new \ArrayObject();
            foreach (Connexion::getInstance()->query($sql) as $row) {
                $beneficiaire = new \Personne\Personne($row["idPersonne"], $row["nom"], $row["prenom"], $row["dateNaissance"], $row["idCoordonnees"], $row["mel"], $row["numeroTelephone"]);
                $listeBeneficiaires->append($beneficiaire);
            }
            return $listeBeneficiaires;
        }

        public function supprimerAdherentEtBeneficiaire($idAdherent)
        {
            $sql = "DELETE FROM beneficiaire WHERE idAdherent = :idAdherent";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->execute();
        }
    }
}

?>