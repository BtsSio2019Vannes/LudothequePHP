<?php
namespace Connexion
{

    use PDOException;

    class Connexion
    {

        static function get_instance()
        {
            static $db = NULL;
            if ($db == NULL) {
                $dsn = "mysql:host=localhost:3306;dbname=ludotheque";
                $usernane = "root";
                $password = "";
                $option = array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"
                );

                try {
                    $db = new \PDO($dsn, $usernane, $password, $option);
                } catch (PDOException $e) {
                    echo "Probleme de connexion", $e;
                }
                return $db;
            }
        }
    }
}
