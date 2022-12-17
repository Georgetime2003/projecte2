<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
*/
    require_once "../../config/database.php";
    require_once "../../Model/oferta.php";
    require_once "../../Model/llista_ofertes.php";

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_POST;
    
    if (!empty($data['desti']) && !empty($data['preupersona']) && !empty($data['datainici']) && !empty($data['datafi'])) {
        $result = LlistaOfertes::createOferta($data);

        if ($result) {
            $missatge = array('success' => true);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>