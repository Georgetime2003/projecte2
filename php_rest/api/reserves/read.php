<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');
    header('Content-Type: application/json');

    require_once "../../config/database.php";
    require_once "../../Model/reserva.php";
    require_once "../../Model/llista_reserves.php";

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_GET;

    if(!empty($data['read']) && strtoupper($data['read']) == 'ALL'){
        LlistaReserves::getAllReserves();

        $llista_ofertes = LlistaReserves::getLlista();

        $response = array(
            'reserves' => $llista_ofertes,
            'status' => 'OK'
        );
    }

    echo json_encode($response);
?>