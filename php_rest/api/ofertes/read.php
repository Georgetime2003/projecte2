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
    require_once "../../Model/oferta.php";
    require_once "../../Model/llista_ofertes.php";

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_GET;

    // Si el parametre read=ALL retornem totes les ofertes
    if(!empty($data['read']) && strtoupper($data['read']) == 'ALL'){
        LlistaOfertes::getAllOfertes();

        $llista_ofertes = LlistaOfertes::getLlista();

        $response = array(
            'ofertes' => $llista_ofertes,
            'status' => 'OK'
        );
    }
    if(!empty($data['read']) && strtoupper($data['read']) == 'ALLNJ'){
        LlistaOfertes::getAllOfertesnJ();

        $llista_ofertes = LlistaOfertes::getLlista();

        $response = array(
            'ofertes' => $llista_ofertes,
            'status' => 'OK'
        );
    }
    echo json_encode($response);
?>