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

    // $data = json_decode(file_get_contents("php://input"));
    $data = $_POST;
    $imatge = $_FILES;
    
    // Si no falten dades creem la oferta
    if (!empty($data['id']) && (!empty($data['continent']) || !empty($data['pais']) || !empty($_FILES["imatge"]["name"]))) {
        $result = LlistaDestinacions::updateDestinacio($data, $_FILES['imatge']);

        // Si l'update es fa correctament, es puja el fitxer al servidor
        if ($result) {
            $missatge = array('success' => true);

            $env = json_decode(file_get_contents("../../environment/environment.json"));
            $environment = $env->environment;
        
            $target_dir = "../../../" . $environment->imatges;
            $target_file = $target_dir . basename($_FILES["imatge"]["name"]);

            move_uploaded_file($_FILES["imatge"]["tmp_name"], $target_file);
        } else {
            $missatge = array('error' => true);
        }
    }

    echo json_encode($missatge);
?>