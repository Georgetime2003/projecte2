<?php

class LlistaReserves{
    private static $llista_reserves = array();

    public static function getLlista(){
        return self::$llista_reserves;
    }
    
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

    public static function reserva_find($id){
        $query = "SELECT id, idoferta, nomclient, telefon, npersones, descompte, datareserva FROM reserves WHERE id = :id ;";
        $params = array(':id' => $id);

        Connexio::connect();
        $stmt = Connexio::execute($query, $params);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $reserva = new Reserva($row['idoferta'],$row['nomclient'],$row['telefon'],$row['npersones'],$row['descompte'],$row['datareserva'],$row['id']);

        return $reserva;
    }

    public static function create_reserva($data){
        $reserva = new Reserva($data['idoferta'],$data['nomclient'],$data['telefon'],$data['npersones'],$data['descompte'],$data['datareserva']);

        return $reserva->create();
    }

    public static function delete_reserva($id){
        $reserva = self::reserva_find($id);

        if($reserva === null){
            return false;
        }
        return $reserva->delete();
    }
}
?>