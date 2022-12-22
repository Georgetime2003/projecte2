<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
class LlistaOfertes{
    private static $llista_ofertes = array();
    
    // GETTER
    public static function getLlista(){
        return self::$llista_ofertes;
    }
    
    /**
    * Get All Ofertes
    *
    * @return void
    * 
    * Métode que retorna totes les ofertes de la BBDD
    */
    public static function getAllOfertes(){
        self::$llista_ofertes = array();

        $query = "SELECT o.id, d.pais, o.titol, o.preupersona, o.datainici, o.datafi FROM ofertes o LEFT JOIN destinacions d ON d.id = o.iddesti";

        Connexio::connect();
        $stmt = Connexio::execute($query);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $oferta = new Oferta($row['pais'],$row['titol'],$row['preupersona'],$row['datainici'],$row['datafi'],$row['id']);

                array_push(self::$llista_ofertes, $oferta);
            }
        }
    }

    public static function getAllOfertesnJ(){
        self::$llista_ofertes = array();

        $query = "SELECT o.id, o.iddesti, o.titol, o.preupersona, o.datainici, o.datafi FROM ofertes o";

        Connexio::connect();
        $stmt = Connexio::execute($query);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $oferta = new Oferta($row['iddesti'],$row['titol'],$row['preupersona'],$row['datainici'],$row['datafi'],$row['id']);

                array_push(self::$llista_ofertes, $oferta);
            }
        }
    }

    /**
    * Oferta Find
    * @param $id - id de la oferta
    * @return Oferta
    * 
    * Métode que retorna la oferta especificada de la BBDD
    */
    public static function oferta_find($id){
        $query = "SELECT id, iddesti, titol, preupersona, datainici, datafi FROM ofertes WHERE id = :id ;";
        $params = array(':id' => $id);

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $oferta = new Oferta($row['iddesti'],$row['titol'],$row['preupersona'],$row['datainici'],$row['datafi'],$row['id']);

        return $oferta;
    }

    /**
    * Create Oferta
    * @param data - Les dades de la oferta a crear
    * @return boolean
    * 
    * Métode que crea una oferta i la inserta a la BBDD
    */
    public static function createOferta($data){
        $oferta = new Oferta($data->pais, $data->titol, $data->preupersona, $data->datainici, $data->datafinal);

        return $oferta->create();
    }

    /**
    * Delete Oferta
    * @param $id - id de la oferta a eliminar
    * @return boolean
    * 
    * Métode que elimina la oferta de la BBDD
    */
    public static function delete_oferta($id){
        $oferta = self::oferta_find($id);

        if($oferta === null){
            return false;
        }
        return $oferta->delete();
    }
}
?>