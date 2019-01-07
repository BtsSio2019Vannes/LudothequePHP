<?php



namespace Dao{
    include '../dao/Connexion.php';
    use Connexion\Connexion;
    
                    
    
    abstract class Dao {
        abstract function read($id);
        
        abstract function update($objet);
        
        abstract function delete($objet);
        
        abstract function create($objet);
        
        protected $key;
        
        protected $table;
        
        function __construct($key,$table) {
            $this->key = $key;
            $this->table = $table;
        }
        
        function getLastKey() {
            return Connexion::getInstance()->lastInsertId();
        }
        
        
    }
       
}
namespace Dao\Adherent {

    use Connexion\Connexion;
    use AdherentCS;
                
                                                
                                     
       
    class AdherentDAO extends \Dao\Dao {
        function __construct() 
        {
            parent::__construct("idAdherent", "adherent");
        }
        public function read($id)
        {
          $sql = "SELECT * FROM $this->table WHERE $this->key=:id";   
          $stmt = Connexion::get_instance()->prepare($sql);
          $stmt ->bindParam(':id', $id);
          $stmt->execute();
          
          
          $row = $stmt->fetch();
          $idA = $row["idAdherent"];
          $idReglement = $row["idRèglement"];
          $datePremiereAdh = $row["datePremiereAdhésion"];
          $dateFinAdh = $row["dateFinAdhésion"];
          $valeurCaution = $row["valeurCaution"];
          
          
          $rep = new AdherentCS\Adherent\Adherent($valeurCaution, $idReglement, $dateFinAdh, $datePremiereAdh);
          $rep -> setId($idA);
          return $rep;
          
        }
    
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idReglement = :idR, datePremiereAdhesion = :daPreAdh, dateFinAdhesion = :daFinAdh, valeurCaution = :caution WHERE $this->key=:id";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idA = $objet->getidAdherent();
            $idR = $objet->getidReglement();
            $daPreAdh = $objet->getdatePremiereAdhesion();
            $dateFiAdh = $objet->getdateFinAdhesion();
            $caution = $objet->getvaleurCaution();
            
            $stmt->bindParam(':idA', $idA);
            $stmt->bindParam(':idR', $idR);
            $stmt->bindParam(':daPreAdh', $daPreAdh);
            $stmt->bindParam(':daFiAdh', $dateFiAdh);
            $stmt->bindParam(':caution', $caution);
            $stmt->execute();
        }
    
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idReglement,datePremiereAdhesion,dateFinAdhesion,valeurCaution) VALUES (:idReglement, :datePremiereAdhesion, :dateFinAdhesion :valeurCaution)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idR = $objet->getidReglement();
            $daPreAdh = $objet->getdatePremiereAdhesion();
            $daFiAdh = $objet->getdateFinAdhesion();
            $caution = $objet->getvaleurCaution();
            $stmt->bindParam(':idReglement', $idR);
            $stmt->bindParam(':datePremiereAdhesion', $daPreAdh);
            $stmt->bindParam(':dateFinAdhesion', $daFiAdh);
            $stmt->bindParam(':chequeCaution', $caution);
            $stmt->execute();
            $objet->setidBeneficiaire(parent::getLastKey());
        }
    
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idB = $objet->getidAdherent();
            $stmt->bindParam(':id', $idB);
            $stmt->execute();
        }
        
        static function getAdherents() {
            $sql = "SELECT * FROM adherent;";
            $rep = "<table class=\"table table-striped\">";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>"  . $row["idAdherent"] .  "&nbsp;";
                $rep .= "</td><td>" . $row["idRèglement"] . "&nbsp;";
                $rep .= "</td><td>" . $row["datePremiereAdhésion"] . "&nbsp;";
                $rep .= "</td><td>" . $row["dateFinAdhésion"] . "&nbsp;";
                $rep .= "</td><td>" . $row["valeurCaution"] . "</td></tr><br/>";
            }
            return $rep . "<table>";
        }
        static function getDatePremiereAdhesion() {
            $sql = "SELECT idAdherent, datePremiereAdhesion FROM adherent WHERE datePremiereAdhesion = > 01/01/2015;";
            $rep = "<table class=\"table table-striped\">";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idAdherent"];
                $rep .= "</td><td>" .$row["datePremiereAdhésion"]. "</td></tr><br/>";
            }
            return $rep;
        }
    
    }
    
    
    
}

namespace Dao\Personne{

    use Connexion\Connexion;
    use AdherentCS;
                
                                

                                    
    
    class PersonneDAO extends \Dao\Dao{
        function __construct() 
        {
            parent::__construct("idP", "personne"); 
        }
        
        
        
        
        public function read($id)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idPersonne = $row["idPersonne"];
            $nomPersonne = $row["nom"];
            $prenomPersonne = $row["prenom"];
            $dateNaissance = $row["dateNaissance"];
            $idCoordonnees = $row["idCoordonnees"];
            $mel = $row["mel"];
            $numTelephone = $row["numTelephone"];
            
            
            
            $rep = new AdherentCS\Personne\Personne($idPersonne, $nomPersonne, $idCoordonnees, $dateNaissance, $prenomPersonne, $mel, $numTelephone);
            $rep->setidPersonne($idPersonne);
            return $rep;
        }
    
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET Nom = :nom, Prenom = :pre, dateNaissance = :dateN, idCoordonnes = :idC, mel = :mel, numTelephone = :num  WHERE $this->key=:id";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idP = $objet->getidPersonne();
            $nom = $objet->getNom();
            $pre = $objet->getPrenom();
            $dateN = $objet->getDateNaissance();
            $idC = $objet->getCoordonnees()->getidCoordonnees();
            $mel = $objet->getMel();
            $num = $objet->getNumTelephone();
            
            $stmt->bindParam(':idP', $idP);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':pre', $pre);
            $stmt->bindParam(':dateN', $dateN);
            $stmt->bindParam(':idC', $idC);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':num', $num);
            
            $stmt->execute();
            
        }
    
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom, prenom, dateNaissance, idCoordonnes, mel, numeroTelephone) VALUES(:nom, :prenom, :dateNaissance, :idCoordonnees, :mel, :numeroTelephone)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $nom = $objet->getNom();
            $pre = $objet->getPrenom();
            $dateN =$objet->getdateNaissance();
            $idC = $objet->getCoordonnees()->getidCoordonnees();
            $mel = $objet->getMel();
            $num = $objet->getNumTelephone();
            
            $stmt ->bindParam(':nom', $nom);
            $stmt ->bindParam(':prenom', $pre);
            $stmt ->bindParam(':dateNaissance', $dateN);
            $stmt ->bindParam(':idCoordonnees', $idC);
            $stmt ->bindParam(':mel', $mel);
            $stmt ->bindParam(':numeroTelephone', $num);
            
            $stmt->execute();
            $objet->setidPersonne(parent::getLastKey());
            
            
            
        }
    
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idB = $objet->getidPersonne();
            $stmt->bindParam(':id', $idB);
            $stmt->execute();
        }
        
        static function getPersonne() {
            $sql = "SELECT * FROM personne";
            $rep = "";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>"  . $row["idPersonne"];
                $rep .= "</td><td>" . $row["nom"];
                $rep .= "</td><td>" . $row["prenom"];
                $rep .= "</td><td>" . $row["dateNaissance"];
                $rep .= "</td><td>" . $row["idCoordonnees"];
                $rep .= "</td><td>" . $row["mel"];
                $rep .= "</td><td>" . $row["numeroTelephone"] ;
                $rep .= "</td><td> <input type=\"checkbox\" name=\"personne\" value=\"" . $row['idPersonne'] . "\"></td></tr>";              
               
            }
            return $rep .""; 
        }
    
    }
    
}


