<?php

class LlistaOfertes{
    private static $llista_ofertes = array();

    public static function getLlista(){
        return self::$llista_ofertes;
    }
    
    public static function getAllOfertes(){
        self::$llista_ofertes = array();

        $query = "SELECT o.id, d.pais, o.preupersona, o.datainici, o.datafi FROM ofertes o LEFT JOIN destinacions d ON d.id = o.iddesti";

        Connexio::connect();
        $stmt = Connexio::execute($query);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $oferta = new Oferta($row['pais'],$row['preupersona'],$row['datainici'],$row['datafi'],$row['id']);

                array_push(self::$llista_ofertes, $oferta);
            }
        }
    }

    public static function oferta_find($id){
        $query = "SELECT id, iddesti, preupersona, datainici, datafi FROM ofertes WHERE id = :id ;";
        $params = array(':id' => $id);

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $oferta = new Oferta($row['iddesti'],$row['preupersona'],$row['datainici'],$row['datafi'],$row['id']);

        return $oferta;
    }

    public static function createOferta($data){
        $oferta = new Oferta($data['desti'], $data['preupersona'], $data['datainici'], $data['datafi']);

        return $oferta->create();
    }

    public static function delete_oferta($id){
        $oferta = self::oferta_find($id);

        if($oferta === null){
            return false;
        }
        return $oferta->delete();
    }
}
?>