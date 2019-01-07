<?php

namespace BDD\ConnexionLudotheque {

    use PDOException;

	class ConnexionLudotheque {
		static function getInstance() {
			static $data = NULL;
			if ($data==NULL) {
			    
				$dsn = "mysql:host=localhost:3306;dbname=ludotheque";
				$username = "root";
				$password = "";
				//Goto project -> properties -> Project Facets and enable both facets
				//pour expliciter le namespace, on préfixe la classe avec \
				$options = array (
						\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" 
				);
				try {
					$data = new \PDO ( $dsn, $username, $password, $options );
				} catch ( PDOException $e ) {
					echo "Problème de connexion", $e;
				}
			}
			return $data;
		}
		
	}
}
?>