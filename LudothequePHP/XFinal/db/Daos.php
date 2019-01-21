<?php
namespace DAO
{

    use Connexion\Connexion;

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
        }
    }
}
// les espaces de noms ne peuvent Ãªtre imbriquÃ©s, alors on simule
namespace DAO\Personne
{

    use Connexion\Connexion;
    use DAO\DAO;
    use DAO\Coordonnees\CoordonneesDAO;
                
    class PersonneDAO extends DAO
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
            
            $daoCoordonnees = new CoordonneesDAO();
            $coordonnees = $daoCoordonnees->read($idCoordonnees);
            
            $mel = $row["mel"];
            $numeroTelephone = $row["numeroTelephone"];

            $rep = new \Adherent\Personne($idPersonne, $nom, $prenom, $dateNaissance, $coordonnees, $mel, $numeroTelephone);
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
            $idCoordonnees = $objet->getCoordonnees()->getIdCoordonnees();
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
            $idCoordonnees = $objet->getCoordonnees()->getIdCoordonnees();
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
            $adherent->setCoordonnees($personne->getCoordonnees());
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
            $sql = "INSERT INTO $this->table (rue,codePostal,ville) VALUES (:rue, :codePostal, :ville)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $sql = "INSERT INTO $this->table (nbrJeux,duree,retardTolere,valeurCaution,coutAdhesion) VALUES (:nbrJeux, :duree, :retardTolere, :valeurCaution, :coutAdhesion)";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            
            $alerte = new \Jeu\Alerte($idAlerte, $nom, $dateRetour, $typeAlerte, $commentaire);
            
            return $alerte;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idAlerte = :idAlerte, nom = :nom, dateRetour = :dateRetour, typeAlerte = :typeAlerte, commentaire = :commentaire WHERE $this->key=:idAlerte";
            $stmt = Connexion::getInstance()->prepare($sql);
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
            $stmt = Connexion::getInstance()->prepare($sql);
            $idAlerte = $objet->getIdAlerte();
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom,dateRetour,typeAlerte,commentaire) VALUES (:nom, :dateRetour, :typeAlerte, :commentaire)";
            $stmt = Connexion::getInstance()->prepare($sql);
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

namespace DAO\Editeur
{
    
    use DB\Connexion\Connexion;
    use Jeu\Editeur;
    
    class EditeurDAO extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idEditeur", "editeur");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idEditeur)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idEditeur = $row["idEditeur"];
            $nom = $row["nom"];
            $idCoordonnees = $row["idCoordonnees"];
            
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new Editeur($idEditeur, $nom, $idCoordonnees);
            return $rep;
        }
        
        public function update($objet)
        {
            // On utilise le prepared statemet qui simplifie les typages
            $sql = "UPDATE $this->table SET idEditeur = :idEditeur, nom = :nom, idCoordonnees = :idCoordonnees WHERE $this->key=:idEditeur";
            
            $stmt = Connexion::getInstance()->prepare($sql);
            $idEditeur = $objet->getIdEditeur();
            $nom = $objet->getNom();
            $idCoordonnees = $objet->getIdCoordonnees();
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idEditeur";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idEditeur = $objet->getIdEditeur();
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (nom,idCoordonnees) VALUES (:nom, idCoordonnees)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $nom = $objet->getNom();
            $idCoordonnees = $objet->getIdCoordonnees();
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':idCoordonnees', $idCoordonnees);
            $stmt->execute();
            $objet->setIdEditeur(parent::getLastKey());
        }
    }
}
namespace DAO\Emprunt
{
    
    use DB\Connexion\Connexion;
    use Emprunt\Emprunt;
    
    class EmpruntDAO extends \DAO\DAO
    {
        function __construct()
        {
            parent::__construct("idJeuPhysique", "emprunt");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($objet)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idJeuPhysique AND idAdherent = :idAdherent AND dateEmprunt = :dateEmprunt";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':dateEmprunt', $dateEmprunt);
            $stmt->execute();
            
            $row = $stmt->fetch();

            $dateRetourEffetif = $row["dateRetourEffectif"];
            $idAlerte = $row["idAlerte"];
            
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new Emprunt($idAdherent, $dateEmprunt, $dateRetourEffetif, $idAlerte);

            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeuPhysique = :idJeuPhysique, idAdherent = :idAdherent, dateEmprunt = :dateEmprunt,
            dateRetourEffectif = :dateRetourEffectif, idAlerte = :idAlerte
            WHERE $this->key=:idJeuPhysique";
            
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            $dateRetourEffectif = $objet->getDateRetourEffectif();
            $idAlerte = $objet->getIdAlerte();
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':dateEmprunt', $dateEmprunt);
            $stmt->bindParam(':dateRetourEffectif', $dateRetourEffectif);
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idJeuPhysique, idAdherent, dateEmprunt, dateRetourEffectif, idAlerte)
             VALUES (:idAdherent, :dateEmprunt, :dateRetourEffectif, :idAlerte)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            $dateRetourEffectif = $objet->getDateRetourEffectif();
            $idAlerte = $objet->getIdAlerte();
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':dateEmprunt', $dateEmprunt);
            $stmt->bindParam(':dateRetourEffectif', $dateRetourEffectif);
            $stmt->bindParam(':idAlerte', $idAlerte);
            $stmt->execute();
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idJeuPhysique AND idAdherent = :idAdherent AND dateEmprunt = :dateEmprunt";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idAdherent = $objet->getIdAdherent();
            $dateEmprunt = $objet->getDateEmprunt();
            
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam(':idAdherent', $idAdherent);
            $stmt->bindParam(':dateEmprunt', $dateEmprunt);
            $stmt->execute();
        } 
    }
}

namespace DAO\JeuPhysique{
    
    use DB\Connexion\Connexion;
    use Jeu\JeuPhysique;
    
    class JeuPhysiqueDAO extends  \DAO\DAO{
        
        function __construct()
        {
            parent::__construct("idJeuPhysique", "jeuphysique");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($idJeuPhysique)
        {
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idJeuPhysique";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idJeuPhysique = $row["idJeuPhysique"];
            $idJeu = $row["idJeu"];
            $contenuActuel = $row["contenuActuel"];
            
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new JeuPhysique($idJeuPhysique, $idJeu, $contenuActuel);

            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeuPhysique = :idJeuPhysique, idJeu = :idJeu,
            contenuActuel = :contenuActuel
            WHERE $this->key=:idJeuPhysique";
            
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeuPhysique = $objet->getIdJeuPhysique();
            $idJeu = $objet->getIdJeu();
            $contenuActuel = $objet->getContenuActuel();
            $stmt->bindParam(':idJeuPhysique', $idJeuPhysique);
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->bindParam(':contenuActuel', $contenuActuel);
            
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idJeu,contenuActuel)
             VALUES (:idJeu, :contenuActuel)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeu = $objet->getIdJeu();
            $contenuActuel = $objet->getContenuActuel();
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->bindParam(':contenuActuel', $contenuActuel);
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

namespace DAO\Jeu {
    
    use DB\Connexion\Connexion;
    use Jeu\Jeu;
    
    class JeuDAO extends \DAO\DAO{
        
        function __construct()
        {
            parent::__construct("idJeu", "jeu");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        
        public function read($idJeu)
        {
            
            $sql = "SELECT * FROM $this->table WHERE $this->key=:idJeu";
            $stmt = Connexion::getInstance()->prepare($sql);
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $idJeu = $row["idJeu"];
            $idRegle = $row["idRegle"];
            $titre = $row["titre"];
            $anneeSortie =$row["anneeSortie"];
            $auteur = $row["auteur"];
            $idEditeur = $row["editeur"];
            $categorie = $row["categorie"];
            $univers = $row["univers"];
            $contenuInitial = $row["contenuInitial"];
            
            // echo "contenu de la base $num $nom $adr $sal ";
            $rep = new Jeu($idJeu, $idRegle, $titre, $anneeSortie, $auteur, $idEditeur, $categorie, $univers, $contenuInitial);

            return $rep;
        }
        
        public function update($objet)
        {
            $sql = "UPDATE $this->table SET idJeu = :idJeu, idRegle = :idRegle, titre= :titre,
            anneeSortie = :anneeSortie, auteur = :auteur, idEditeur = :idEditeur, categorie = :categorie
            univers = :univers, contenuInitial = :contenuInitial
            WHERE $this->key=:idJeu";
            
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeu = $objet->getIdJeu();
            $idRegle = $objet->getIdRegle();
            $titre = $objet->getTitre();
            $anneeSortie = $objet->getAnneeSortie();
            $auteur = $objet->getAuteur();
            $idEditeur = $objet->getIdEditeur();
            $categorie = $objet->getCategorie();
            $univers = $objet->getunivers();
            $contenuInitial = $objet->getContenuInitial();
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->bindParam(':idRegle', $idRegle);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':anneeSortie', $anneeSortie);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':univers', $univers);
            $stmt->bindParam(':contenuInitial', $contenuInitial);
            
            $stmt->execute();
        }
        
        public function create($objet)
        {
            $sql = "INSERT INTO $this->table (idRegle,titre, anneeSortie, auteur, idEditeur,
            categorie, univers, contenuInitial)
            VALUES (:idRegle, :titre, :anneeSortie, :auteur, :idEditeur,:categorie, :univers,
            :contenuInitial)";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idRegle = $objet->getIdRegle();
            $titre = $objet->getTitre();
            $anneeSortie = $objet->getAnneeSortie();
            $auteur = $objet->getAuteur();
            $idEditeur = $objet->getIdEditeur();
            $categorie = $objet->getCategorie();
            $univers = $objet->getunivers();
            $contenuInitial = $objet->getContenuInitial();
            $stmt->bindParam(':idRegle', $idRegle);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':anneeSortie', $anneeSortie);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':idEditeur', $idEditeur);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':univers', $univers);
            $stmt->bindParam(':contenuInitial', $contenuInitial);
            $stmt->execute();
            
            $objet->setIdJeu(parent::getLastKey());
        }
        
        public function delete($objet)
        {
            $sql = "DELETE FROM $this->table WHERE $this->key=:idJeu";
            $stmt = Connexion::getInstance()->prepare($sql);
            $idJeu = $objet->getIdJeu();
            $stmt->bindParam(':idJeu', $idJeu);
            $stmt->execute();
        }
    }
    
}
?>
