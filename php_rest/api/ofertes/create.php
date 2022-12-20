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
    
    // Si no falten dades creem la oferta
    if (!empty($data['pais']) && !empty($data['preupersona']) && !empty($data['datainici']) && !empty($data['datafinal'])) {
        if (!empty($data['intropais'])) {
            LlistaDestinacions::createDestinacio($data);
        }
        $result = LlistaOfertes::createOferta($data);

        if ($result) {
            $missatge = array('resultat' => "OK");
        } else {
            $missatge = array('resultat' => "Error");
        }
    }

    echo json_encode($missatge);
?>