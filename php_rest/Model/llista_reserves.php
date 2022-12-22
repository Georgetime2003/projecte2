<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
class LlistaReserves{
    private static $llista_reserves = array();

    // GETTER
    public static function getLlista(){
        return self::$llista_reserves;
    }
    
    /**
    * Get All Reserves
    *
    * @return void
    * 
    * Métode que retorna totes les reserves de la BBDD
    */
    public static function getAllReserves(){
        self::$llista_reserves = array();

        $query = "SELECT r.id, r.idoferta, r.nomclient, r.telefon, r.npersones, r.descompte, r.datareserva FROM reserves r;";

        Connexio::connect();
        $stmt = Connexio::execute($query);

        Connexio::close();

        $result = $stmt->fetchAll();

        $num = count($result);

        if ($num > 0) {
            foreach ($result as $row) {
                extract($row);
                
                $reserva = new Reserva($row['idoferta'],$row['nomclient'],$row['telefon'],$row['npersones'],$row['descompte'],$row['datareserva'],$row['id']);

                array_push(self::$llista_reserves, $reserva);
            }
        }
    }
    
    /**
    * Reserva Find
    * @param $id - id de la reserva
    * @return Reserva
    * 
    * Métode que retorna la reserva especificada de la BBDD
    */
    public static function reserva_find($id){
        $query = "SELECT id, idoferta, nomclient, telefon, npersones, descompte, datareserva FROM reserves WHERE id = :id ;";
        $params = array(':id' => $id);

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $reserva = new Reserva($row['idoferta'],$row['nomclient'],$row['telefon'],$row['npersones'],$row['descompte'],$row['datareserva'],$row['id']);

        return $reserva;
    }

    /**
    * Create Reserva
    * @param data - Les dades de la reserva a crear
    * @return boolean
    * 
    * Métode que crea una reserva i la inserta a la BBDD
    */
    public static function create_reserva($data){
        $reserva = new Reserva($data->idoferta,$data->nomclient,$data->telefon,$data->npersones,$data->descompte,$data->datareserva);

        return $reserva->create();
    }

    /**
    * Delete Reserva
    * @param $id - id de la reserva a eliminar
    * @return boolean
    * 
    * Métode que elimina la reserva de la BBDD
    */
    public static function delete_reserva($id){
        $reserva = self::reserva_find($id);

        if($reserva === null){
            return false;
        }
        return $reserva->delete();
    }
}
?>