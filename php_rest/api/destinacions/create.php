<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
*/
    require_once "../../config/database.php";
    require_once "../../Model/destinacio.php";
    require_once "../../Model/llista_destinacions.php";

    $data = json_decode(file_get_contents("php://input"));
    // $data = $_POST;
    
    // Si no falten dades creem la destinacio, la imatge no és obligatòria
    if (!empty($data->continent) && !empty($data->pais)) {
        $result = LlistaDestinacions::createDestinacio($data);

        if ($result) {
            $missatge = array('success' => true);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>