<?php
namespace DAO
{

    use BDD\ConnexionLudotheque\ConnexionLudotheque;   
    include ("../metier/adherent.php");

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


namespace DAO\adherent
{
    
    use BDD\ConnexionLudotheque\ConnexionLudotheque;
    
    class Adherent extends \DAO\DAO
    {
        
        function __construct()
        {
            parent::__construct("idPersonne", "Personne");
            // echo "constructeur de DAO ", __NAMESPACE__,"<br/>";
        }
        
        public function read($id)
        {
            
            $sql = "SELECT * FROM $this->table WHERE $this->key=:id";
            $stmt = ConnexionLudotheque::getInstance()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $row = $stmt->fetch();
            $num = $row["nom"];
            $nom = $row["prenom"];
            $adr = $row["dateNaissance"];
            $sal = $row["mel"];
            

?>