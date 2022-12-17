<?php

class LlistaDestinacions{
    private static $llista_destinacions = array();

    public static function getLlista(){
        return self::$llista_destinacions;
    }
    
    public static function getAllDestinacions(){
        self::$llista_destinacions = array();

        $query = "SELECT d.id, c.continent, d.pais, d.imatges FROM destinacions d LEFT JOIN continents c ON c.id = d.continent";

        Connexio::connect();
        $stmt = Connexio::execute($query);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $destinacio = new Destinacio($row['continent'], $row['pais'], $row['imatges'],  $row['id']);

                array_push(self::$llista_destinacions, $destinacio);
            }
        }
    }

    public static function getContinents(){
        self::$llista_destinacions = array();

        $query = "SELECT continent FROM continents";

        Connexio::connect();
        $stmt = Connexio::execute($query);
        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);

                array_push(self::$llista_destinacions, $row['continent']);
            }
        }
    }

    public static function getPaisos($continent){
        self::$llista_destinacions = array();

        $query = "SELECT d.id, c.continent, d.pais, d.imatges FROM destinacions d LEFT JOIN continents c ON c.id = d.continent WHERE c.id = :id";
        $params = array(
            ':id' => $continent
        );

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $destinacio = new Destinacio($row['continent'], $row['pais'], $row['imatges'],  $row['id']);

                array_push(self::$llista_destinacions, $destinacio);
            }
        }
    }
}

?>