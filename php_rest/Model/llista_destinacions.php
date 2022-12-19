<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
class LlistaDestinacions{
    private static $llista_destinacions = array();
    // GETTER
    public static function getLlista(){
        return self::$llista_destinacions;
    }

    /**
    * Get All Destinacions
    *
    * @return void
    * 
    * Métode que retorna totes les destinacions de la BBDD
    */
    public static function getAllDestinacions(){
        self::$llista_destinacions = array();

        $query = "SELECT id, continent, pais, imatges FROM destinacions ";

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

    /**
    * Get Continents
    *
    * @return void
    * 
    * Métode que crea un array amb els continents de la BBDD
    */
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
    /**
    * Get Paisos
    * @param $continent - l'id d'un continent
    * @return void
    * 
    * Métode que crea un array amb les destinacions del continent especificat de la BBDD
    */
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
    /**
    * Destinació find
    *
    * @param $id Id de la destinació
    * @return Destinacio
    * 
    * Métode per buscar una destinació per ID
    */
    public static function destinacio_find($id){
        $query = "SELECT id, continent, pais, imatges FROM destinacions WHERE id = :id ;";
        $params = array(':id' => $id);

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $destinacio = new Destinacio($row['continent'],$row['pais'],$row['imatges'],$row['id']);

        return $destinacio;
    }
    /**
    * update Destinacio
    *
    * @return boolean
    * 
    * Métode per actualitzar una destinació de la BBDD
    */
    public static function updateDestinacio($data, $imatge){
        $destinacio_original = self::destinacio_find($data['id']);

        $continent = (empty($data['continent'])) ? $destinacio_original->getContinent() : $data['continent'];
        $pais = (empty($data['pais'])) ? $destinacio_original->getPais() : $data['pais'];
        $imatges = (empty($imatge["imatge"]["name"])) ? $destinacio_original->getImatges() : basename($imatge["imatge"]["name"]);

        $destinacio = new Destinacio($continent, $pais, $imatges, $data['id']);

        return $destinacio->update();
    }
    /**
    * Create Destinacio
    * @param data - Les dades de la destinacio a crear
    * @return boolean
    * 
    * Métode que crea una destinacio i la inserta a la BBDD
    */
    public static function createDestinacio($data){
        $imatges = $data['imatges'] ?? null; 
        $destinacio = new Destinacio($data['continent'], $data['pais'], $imatges);

        return $destinacio->create();
    }
}

?>