<?php

    /**
    *
    * @author: Sergi Triadó <s.triado@sapalomera.cat>
    * @author: Jordi Palomino <j.palomino@sapalomera.cat>
    *
    **/
    
    /**
     * Database
     * Clase per instanciar quan es vol fer una connexió
     */
    class Database {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'projecte2';
        private $username = 'root';
        private $pwd = '';
        private $conn;

        // DB Connect
        public function connect(){
            $this->conn = null;

            try{
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->pwd);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }
    
    /**
     * Connexio
     * Clase que instancia a la clase anterior i gestiona les connexions
     */
    class Connexio {
        private static $conn;

        public static function connect(){
            // Connect nomes si no hi ha connexio previa
            if (!isset(self::$conn)) {
                $db = new Database();
                self::$conn = $db->connect();
            }
        }

        public static function getConn(){
            return self::$conn;
        }

        public static function execute($query, $params = array()){
            // Prepare
            $stmt = self::$conn->prepare($query);

            // Execute query
            if($stmt->execute($params)){
                return $stmt;
            } else {
                return false;
            }
        }

        public static function execute_int_params($query, $params){
            // Prepare
            $stmt = self::$conn->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $params[$key], PDO::PARAM_INT);
            }

            // Execute query
            if($stmt->execute()){
                return $stmt;
            } else {
                return false;
            }
        }

        // Tancar connexió
        public static function close(){
            self::$conn = null;
        }
    }

?>