<?php

namespace DB\Connexion {
    
    use PDOException;
    
    class Connexion {
        static function getInstance() {
            static $dbh = NULL;
            if ($dbh==NULL) {
                $dsn = "mysql:host=localhost;dbname=promo19_aurelien";
                $username = "promo19";
                $password = "user@sio19";
                //Goto project -> properties -> Project Facets and enable both facets
                //pour expliciter le namespace, on préfixe la classe avec \
                $options = array (
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                );
                try {
                    $dbh = new \PDO ( $dsn, $username, $password, $options );
                } catch ( PDOException $e ) {
                    echo "Problème de connexion", $e;
                }
            }
            return $dbh;
        }
        
    }
}
?>