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

    $data = $_POST;
    // $data = json_decode(file_get_contents("php://input"));
    
    if (!empty($data['id'])) {
        $result = LlistaOfertes::delete_oferta($data['id']);
    
        if ($result) {
            $missatge = array('success' => true);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>