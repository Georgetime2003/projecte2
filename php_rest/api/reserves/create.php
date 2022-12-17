<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
*/
    require_once "../../config/database.php";
    require_once "../../Model/reserva.php";
    require_once "../../Model/llista_reserves.php";

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_POST;
    
    // Si no falten dades creem la reserva
    if (!empty($data['idoferta']) && !empty($data['nomclient']) && !empty($data['telefon']) && !empty($data['npersones']) && !empty($data['descompte']) && !empty($data['datareserva'])) {
        $result = LlistaReserves::create_reserva($data);

        if ($result) {
            $missatge = array('success' => true);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>