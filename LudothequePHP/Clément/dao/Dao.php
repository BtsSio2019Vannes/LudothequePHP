<?php
namespace Dao
{
    
    include '../dao/Connexion.php';
    use Connexion\Connexion;
    
    abstract class Dao
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
            return Connexion::getInstance()->lastInsertId();
        }
    }
}
namespace Dao\Adherent
{
    
    use Adherent\Adherent\Adherent;
    use Connexion\Connexion;
    
    class AdherentDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idAdherent", "adherent");
        }
        
        public function read($idAdherent)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idAdherent";
            $stmt = Connexion::get_instance()->prepare($sql);
            $stmt->bindParam(':id', $idAdherent);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idAdherent = $row["idAdherent"];
            $idReglement = $row["idRèglement"];
            $datePremiereAdh = $row["datePremiereAdhésion"];
            $dateFinAdh = $row["dateFinAdhésion"];
            $valeurCaution = $row["valeurCaution"];
            
            $rep = new Adherent($valeurCaution, $idReglement, $dateFinAdh, $datePremiereAdh, $idAdherent);
            $rep->setIdAdherent($idAdherent);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idAdherent = :idAdherent ,idReglement = :idR, datePremiereAdhesion = :daPreAdh, dateFinAdhesion = :daFinAdh, valeurCaution = :caution WHERE $this->key=:idAdherent";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idA = $objet->getidAdherent();
            $idR = $objet->getidReglement();
            $daPreAdh = $objet->getdatePremiereAdhesion();
            $dateFiAdh = $objet->getdateFinAdhesion();
            $caution = $objet->getvaleurCaution();
            
            $stmt->bindParam(':idAdherent', $idA);
            $stmt->bindParam(':idR', $idR);
            $stmt->bindParam(':daPreAdh', $daPreAdh);
            $stmt->bindParam(':daFiAdh', $dateFiAdh);
            $stmt->bindParam(':caution', $caution);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idReglement,datePremiereAdhesion,dateFinAdhesion,valeurCaution)
            VALUES (:idReglement, :datePremiereAdhesion, :dateFinAdhesion :valeurCaution)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idR = $objet->getidReglement();
            $daPreAdh = $objet->getdatePremiereAdhesion();
            $daFiAdh = $objet->getdateFinAdhesion();
            $caution = $objet->getvaleurCaution();
            $stmt->bindParam(':idReglement', $idR);
            $stmt->bindParam(':datePremiereAdhesion', $daPreAdh);
            $stmt->bindParam(':dateFinAdhesion', $daFiAdh);
            $stmt->bindParam(':valeurCaution', $caution);
            $stmt->execute();
            $objet->setidBeneficiaire(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idAdherent";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idA = $objet->getidAdherent();
            $stmt->bindParam(':idAdherent', $idA);
            $stmt->execute();
        }
        
        static function getAdherents()
        {
            $sql = "SELECT * FROM adherent;";
            $rep = "<table class=\"table table-striped\">";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idAdherent"] . "&nbsp;";
                $rep .= "</td><td>" . $row["idRèglement"] . "&nbsp;";
                $rep .= "</td><td>" . $row["datePremiereAdhésion"] . "&nbsp;";
                $rep .= "</td><td>" . $row["dateFinAdhésion"] . "&nbsp;";
                $rep .= "</td><td>" . $row["valeurCaution"] . "</td></tr><br/>";
            }
            return $rep . "<table>";
        }
        
        static function getDatePremiereAdhesion()
        {
            $sql = "SELECT idAdherent, datePremiereAdhesion FROM adherent WHERE datePremiereAdhesion = > 01/01/2015;";
            $rep = "<table class=\"table table-striped\">";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idAdherent"];
                $rep .= "</td><td>" . $row["datePremiereAdhésion"] . "</td></tr><br/>";
            }
            return $rep;
        }
    }
}
namespace Dao\Personne
{
    
    use Adherent\Personne\Personne;
    use Connexion\Connexion;
    
    class PersonneDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idP", "personne");
        }
        
        public function read($idPersonne)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idPersonne";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idPersonne', $idPersonne);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idPersonne = $row["idPersonne"];
            $nomPersonne = $row["nom"];
            $prenomPersonne = $row["prenom"];
            $dateNaissance = $row["dateNaissance"];
            $idCoordonnees = $row["idCoordonnees"];
            $mel = $row["mel"];
            $numeroTelephone = $row["numTelephone"];
            
            $rep = new Personne($idPersonne, $nomPersonne, $idCoordonnees, $dateNaissance, $prenomPersonne, $mel, $numeroTelephone);
            $rep->setIdPersonne($idPersonne);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idPersonne = :idPersonne, nom = :nom, Prenom = :pre, dateNaissance = :dateN, idCoordonnes = :idC, mel = :mel, numTelephone = :num  WHERE $this->key=:idPersonne";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idP = $objet->getIdPersonne();
            $nom = $objet->getNom();
            $pre = $objet->getPrenom();
            $dateN = $objet->getDateNaissance();
            $idC = $objet->getCoordonnees()->getidCoordonnees();
            $mel = $objet->getMel();
            $num = $objet->getNumTelephone();
            
            $stmt->bindParam(':idPersonne', $idP);
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
            $dateN = $objet->getdateNaissance();
            $idC = $objet->getCoordonnees()->getidCoordonnees();
            $mel = $objet->getMel();
            $num = $objet->getNumTelephone();
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $pre);
            $stmt->bindParam(':dateNaissance', $dateN);
            $stmt->bindParam(':idCoordonnees', $idC);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':numeroTelephone', $num);
            
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
        
        static function getPersonne()
        {
            $sql = "SELECT * FROM personne";
            $rep = "";
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idPersonne"];
                $rep .= "</td><td>" . $row["nom"];
                $rep .= "</td><td>" . $row["prenom"];
                $rep .= "</td><td>" . $row["dateNaissance"];
                $rep .= "</td><td>" . $row["idCoordonnees"];
                $rep .= "</td><td>" . $row["mel"];
                $rep .= "</td><td>" . $row["numeroTelephone"];
                $rep .= "</td><td> <input type=\"checkbox\" name=\"personne\" value=\"" . $row['idPersonne'] . "\"></td></tr>";
            }
            return $rep . "";
        }
    }
}
namespace Dao\Coordonnees
{
    
    use Adherent\Personne\Coordonnees;
    use Connexion\Connexion;
    
    class CoordonneesDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idCoordonnees", "coordonnees");
        }
        
        public function read($idCoordonnees)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idCoordonnees";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $idCoordonnees);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idCoordonnees = $row["idCoordonnees"];
            $rue = $row["rue"];
            $codePostal = $row["codePostal"];
            $ville = $row["ville"];
            
            $rep = new Coordonnees($idCoordonnees, $rue, $codePostal, $ville);
            $rep->setIdCoordonnees($idCoordonnees);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET rue = :rue, Code Postal = :codePostal, ville = :ville, WHERE $this->key=:idCoordonnees";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idC = $objet->getIdCoordonnees();
            $rue = $objet->getRue();
            $codeP = $objet->getCodePostal();
            $ville = $objet->getVille();
            
            $stmt->bindParam(':idC', $idC);
            $stmt->bindParam(':rue', $rue);
            $stmt->bindParam(':codePostal', $codeP);
            $stmt->bindParam(':ville', $ville);
            
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (rue, codePostal, ville) VALUES(:rue, :codePostal, :ville)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $nom = $objet->getCoordonnees();
            $pre = $objet->getRue();
            $dateN = $objet->getCodePostal();
            $idC = $objet->getVille();
            $mel = $objet->getMel();
            $num = $objet->getNumTelephone();
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $pre);
            $stmt->bindParam(':dateNaissance', $dateN);
            $stmt->bindParam(':idCoordonnees', $idC);
            $stmt->bindParam(':mel', $mel);
            $stmt->bindParam(':numeroTelephone', $num);
            
            $stmt->execute();
            $objet->setidPersonne(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idC = $objet->getIdCoordonnees();
            $stmt->bindParam(':id', $idC);
            $stmt->execute();
        }
    }
}
namespace Dao\Jeu
{
    
    use Connexion\Connexion;
    use Jeu\Jeu;
    
    class JeuDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idJeu", "jeu");
        }
        
        public function read($idJeu)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idJeu";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idJeu = $row["idJeu"];
            $idRegle = $row["idRègle"];
            $titre = $row["titre"];
            $anneeSortie = $row["anneeSortie"];
            $auteur = $row["auteur"];
            $idEditeur = $row["idEditeur"];
            $categorie = $row["categorie"];
            $univers = $row["univers"];
            $contenuInitial = $row["contenuInitial"];
            
            $rep = new Jeu($idJeu, $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);
            $rep->setId($idJeu);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeu = :idJeu, idRegle = :idRegle, titre = :titre, AnneeSortie = :anneeSortie,
            auteur = :auteur, idEditeur = :idEditeur, catégorie = :categorie, univeers = :univers, contenuInitial = :contenuInitial  WHERE $this->key=:idJeu";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idJeu = $objet->getidJeu();
            $idRegle = $objet->getidRegle();
            $titre = $objet->getTitre();
            $anneeSortie = $objet->getAnneeSortie();
            $auteur = $objet->getauteur();
            $idEditeur = $objet->getEditeur()->getIdEditeur();
            $categorie = $objet->getCategorie();
            $univers = $objet->getUnivers();
            $contenu = $objet->getContenuInitial();
            
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->bindParam(':idRegle', $idRegle);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':anneeSortie', $anneeSortie);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam('univers', $univers);
            $stmt->bindParam('contenuInitial', $contenu);
            
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idRegle, titre, anneSortie, auteur, idEditeur, categorie, univers, contenuInitial)
            VALUES(:idRegle, :titre, :anneeSortie, :auteur, :idEditeur, :categorie, :univers, :contenuInitial)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idRegle = $objet->getIdRegle();
            $titre = $objet->getTitre();
            $anneeSortie = $objet->getAnneeSortie();
            $auteur = $objet->getAuteur();
            $idEditeur = $objet->getEditeur()->getIdEditeur();
            $categorie = $objet->getCategorie();
            $univers = $objet->getUnivers();
            $contenu = $objet->getContenuInitial();
            
            $stmt->bindParam(':idRegle', $idRegle);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':anneeSortie', $anneeSortie);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':univers', $univers);
            $stmt->bindParam(':contenuInitial', $contenu);
            
            $stmt->execute();
            $objet->setidJeu(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJ = $objet->getidJeu();
            $stmt->bindParam(':id', $idJ);
            $stmt->execute();
        }
        
        static function getJeu()
        {
            $sql = "SELECT * FROM jeu";
            $rep = "";
            
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idJeu"];
                $rep .= "</td><td>" . $row["idRegle"];
                $rep .= "</td><td>" . $row["titre"];
                $rep .= "</td><td>" . $row["anneeSortie"];
                $rep .= "</td><td>" . $row["auteur"];
                $rep .= "</td><td>" . $row["idEditeur"];
                $rep .= "</td><td>" . $row["categorie"];
                $rep .= "</td><td>" . $row["univers"];
                $rep .= "</td><td>" . $row["contenuInitial"];
                $rep .= "</td><td> <input type=\"checkbox\" name=\"jeu\" value=\"" . $row['idJeu'] . "\"></td></tr>";
            }
            return $rep . "";
        }
    }
}
namespace Dao\Emprunt
{
    
    use Connexion\Connexion;
    use Emprunt\Emprunt;
    
    class EmpruntDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idJeuPhysique, idAdherent, dateEmprunt", "emprunt");
        }
        
        public function read($idJeuPhysique)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idJeuPhysique = $row["idJeuPhysique"];
            $idAdherent = $row["idAdherent"];
            $dateEmprunt = $row["dateEmprunt"];
            $dateRetourEffectif = $row["dateRetourEffectif"];
            $idAlerte = $row["idAlerte"];
            
            $rep = new Emprunt($idJeuPhysique, $idAdherent, $dateEmprunt, $dateRetourEffectif, $idAlerte);
            $rep->setIdJeuPhysique($idJeuPhysique);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeuPhysique = :idJeuPhysique, idAdherent = :idAdherent, dateEmprunt = :dateEmprunt, dateRetourEffectif = :dateRetourEffectif, idAlerte = :idAlerte";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            $dateRetourEffectif = $objet->getDateRetourEffectif();
            $idAlerte = $objet->getIdAlerte();
            
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam('idAdherent', $idAdherent);
            $stmt->bindParam('dateEmprunt', $dateEmprunt);
            $stmt->bindParam('dateRetourEffectif', $dateRetourEffectif);
            $stmt->bindParam('idAlerte', $idAlerte);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idAdherent, dateEmprunt, dateRetourEffectif, idAlerte)
            VALUES(:idAdherent, :dateEmprunt, :dateRetourEffectif, :idAlerte";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            $dateRetourEffectif = $objet->getDateRetourEffectif();
            $idAlerte = $objet->getIdAlerte();
            
            $stmt->bindParam('idAdherent', $idAdherent);
            $stmt->bindParam('dateEmprunt', $dateEmprunt);
            $stmt->bindParam('dateRetourEffectif', $dateRetourEffectif);
            $stmt->bindParam('idAlerte', $idAlerte);
            $stmt->execute();
            $objet->setIdJeuPhysique(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJP = $objet->getidJeuPhysique();
            $stmt->bindParam(':id', $idJP);
            $stmt->execute();
        }
        
        static function getEmprunt()
        {
            $sql = "SELECT * FROM emprunt";
            $rep = "";
            
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idJeuPhysique"];
                $rep .= "</td><td>" . $row["idAdherent"];
                $rep .= "</td><td>" . $row["dateEmprunt"];
                $rep .= "</td><td>" . $row["dateRetourEffectif"];
                $rep .= "</td><td>" . $row["idAlerte"];
                $rep .= "</td><td> <input type=\"checkbox\" name=\"emprunt\" value=\"" . $row['idJeuPhysique'] . "\"></td></tr>";
            }
            return $rep . "";
        }
    }
}
namespace Dao\Editeur
{
    
    use Connexion\Connexion;
    use Jeu\Editeur;
    
    class EditeurDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idEditeur", "editeur");
        }
        
        public function read($idEditeur)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idEditeur = $row["idEditeur"];
            $nom = $row["nom"];
            $idCoordonnees = $row["idCoordonnees"];
            
            $rep = new Editeur($idEditeur, $nom, $idCoordonnees);
            $rep->setIdEditeur($idEditeur);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idEditeur = :idEditeur, nom = :nom, idCoordonnees= :idCoordonnees";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idEditeur = $objet->getIdEditeur();
            $nom = $objet->getNom();
            $idCoordonnees = $objet->getIdCoordonnees();
            
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":idCooordonnees", $idCoordonnees);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table(nom, idCoordonnees) VALUES(:nom, :idCoordonnees)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $nom = $objet->getNom();
            $idCoordonnees = $objet->getIdCoordonnees();
            
            $stmt->bindParam('nom', $nom);
            $stmt->bindParam("idCoordonnees", $idCoordonnees);
            $stmt->execute();
            $objet->setIdEditeur(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idEditeur";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idE = $objet->getIdEditeur();
            $stmt->bindParam(':idEditeur', $idE);
            $stmt->execute();
        }
    }
}
namespace Dao\Reglement
{
    
    use Connexion\Connexion;
    use Reglement\Reglement;
    
    class ReglementDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idReglement", "reglement");
        }
        
        public function read($idReglement)
        {
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
            
            $rep = new Reglement($idReglement, $nbrJeux, $duree, $retardTolere, $valeurCaution, $coutAdhesion);
            $rep->setIdReglement($idReglement);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idReglement = :idreglement, nbrJeux = :nbrJeux, duree= :duree retardTolere= :retardTolere,
            valeurCaution = :valeurCaution, coutAdhesion = :coutAdhesion";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $nbrJeux = $objet->getNbrJeux();
            $duree = $objet->getDuree();
            $retardTolere = $objet->getRetardTolere();
            $valeurCaution = $objet->getValeurCaution();
            $coutAdhesion = $objet->getCoutAdhesion();
            
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->bindParam(":nbrJeux", $nbrJeux);
            $stmt->bindParam(":duree", $duree);
            $stmt->bindParam(":retardTolere", $retardTolere);
            $stmt->bindParam(":valeurCaution", $valeurCaution);
            $stmt->bindParam(":coutAdhesion", $coutAdhesion);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table(nbrJeux, duree, retardTolere, valeurCaution, coutAdhesion)
            VALUES(:nbrJeux, :duree, :retardTolere, :valeurCaution, :coutAdhesion)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $nbrJeux = $objet->getNbrJeux();
            $duree = $objet->getDuree();
            $retardTolere = $objet->getRetardTolere();
            $valeurCaution = $objet->getValeurCaution();
            $coutAdhesion = $objet->getCoutAdhesion();
            
            $stmt->bindParam('nbrJeux', $nbrJeux);
            $stmt->bindParam("duree", $duree);
            $stmt->bindParam("retardTolere", $retardTolere);
            $stmt->bindParam("valeurCaution", $valeurCaution);
            $stmt->bindParam("coutAdhesion", $coutAdhesion);
            $stmt->execute();
            $objet->setIdReglement(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idReglement";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idReglement = $objet->getIdReglement();
            $stmt->bindParam(':idReglement', $idReglement);
            $stmt->execute();
        }
        
        static function getReglement()
        {
            $sql = "SELECT * FROM reglement";
            $rep = "";
            
            foreach (Connexion::get_instance()->query($sql) as $row) {
                $rep .= "<tr><td>" . $row["idReglement"];
                $rep .= "</td><td>" . $row["nbrJeux"];
                $rep .= "</td><td>" . $row["duree"];
                $rep .= "</td><td>" . $row["retardTolere"];
                $rep .= "</td><td>" . $row["valeurCaution"];
                $rep .= "</td><td>" . $row["coutAdhesion"];
                $rep .= "</td><td> <input type=\"checkbox\" name=\"reglement\" value=\"" . $row['idReglement'] . "\"></td></tr>";
            }
            return $rep . "";
        }
    }
}
namespace Dao\Alerte
{
    
    use Connexion\Connexion;
    use Jeu\Alerte;
    
    class AlerteDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idAlerte", "alerte");
        }
        
        public function read($idAlerte)
        {
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
            
            $rep = new Alerte($idAlerte, $nom, $dateRetour, $typeAlerte, $commentaire);
            $rep->setIdAlerte($idAlerte);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idAlerte = :idAlerte nom = :nom, dateRetour= :dateRetour typeAlerte= :typeAlerte,
            commentaire = :commentaire";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idAlerte = $objet->getIdAlerte();
            $nom = $objet->getNom();
            $dateRetour = $objet->getDateRetour();
            $typeAlerte = $objet->getTypeAlerte();
            $commentaire = $objet->getCommentaire();
            
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":dateRetour", $dateRetour);
            $stmt->bindParam(":typeAlerte", $typeAlerte);
            $stmt->bindParam(":commentaire", $commentaire);
            
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table(nom, dateRetour, typeAlerte, commentaire)
            VALUES(:nom, :dateRetour, :typeAlerte, :commentaire)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $nom = $objet->getNom();
            $dateRetour = $objet->getDateRetour();
            $typeAlerte = $objet->getTypeAlerte();
            $commentaire = $objet->getCommentaire();
            
            $stmt->bindParam("nom", $nom);
            $stmt->bindParam("dateRetour", $dateRetour);
            $stmt->bindParam("typeAlerte", $typeAlerte);
            $stmt->bindParam("commentaire", $commentaire);
            $stmt->execute();
            $objet->setIdAlerte(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idAlerte";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idAlerte = $objet->getIdAlerte();
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
        }
    }
}
namespace Dao\JeuPhysique
{
    
    use Connexion\Connexion;
    use JeuPhysique\JeuPhysique;
    
    class JeuPhysiqueDAO extends \Dao\Dao
    {
        
        function __construct()
        {
            parent::__construct("idJeuPhysique", "jeuphysique");
        }
        
        public function read($idJeuPhysique)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idJeuPhysique";
            $stmt = Connexion::get_instance()->prepare($sql);
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idJeuPhysique = $row["idJeuPhysique"];
            $idJeu = $row["idJeu"];
            $contenuActuel = $row["contenuActuel"];
            
            $rep = new JeuPhysique($idJeuPhysique, $idJeu, $contenuActuel);
            $rep->setIdJeuPhysique($idJeuPhysique);
            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeuPhysique = :idJeuPhysique idJeu = :idJeu, contenuActuel= :contenuActuel";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idJeu = $objet->getIdJeu();
            $contenuActuel = $objet->getContenuActuel();
            
            $stmt->bindParam("idJeuPhysique", $idJeuPhysique);
            $stmt->bindParam("idJeu", $idJeu);
            $stmt->bindParam("contenuActuel", $contenuActuel);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table(idJeu, contenuActuel) VALUES(:idJeu, :contenuActuel)";
            $stmt = Connexion::get_instance()->prepare($sql);
            $idJeu = $objet->getIdJeu();
            $contenuActuel = $objet->getContenuActuel();
            
            $stmt->bindParam("idJeu", $idJeu);
            $stmt->bindParam("contenuActuel", $contenuActuel);
            $stmt->execute();
            $objet->setIdJeuPhysique(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idJeuPhysique";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->execute();
        }
    }
}
