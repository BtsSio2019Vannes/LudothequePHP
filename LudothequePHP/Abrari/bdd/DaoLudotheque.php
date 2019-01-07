<?php
namespace DAO
{

    use BDD\ConnexionLudotheque\ConnexionLudotheque;

    
    include ("../metier/Ludotheque.php");

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
            
            return ConnexionLudotheque::getInstance()->lastInsertId();
            
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



?>