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
    require_once "../../Model/destinacio.php";
    require_once "../../Model/llista_destinacions.php";

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_GET;

    if(!empty($data['read']) && $data['read'] === 'ALL'){
        LlistaDestinacions::getAllDestinacions();

        $llista_destinacions = LlistaDestinacions::getLlista();

        $response = array(
            'destinacions' => $llista_destinacions,
            'status' => 'OK'
        );
    }
    if(!empty($data['read']) && $data['read'] === 'continents'){
        LlistaDestinacions::getContinents();
        $llista_destinacions = LlistaDestinacions::getLlista();

        $response = array(
            'continents' => $llista_destinacions,
            'status' => 'OK'
        );
    }

    echo json_encode($response);
?>