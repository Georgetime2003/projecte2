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

    $data = $_POST;
    // $data = json_decode(file_get_contents("php://input"));
    
    // Si no falta la id eliminem la reserva
    if (!empty($data['id'])) {
        $result = LlistaReserves::delete_reserva($data['id']);
    
        if ($result) {
            $missatge = array('success' => true);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>