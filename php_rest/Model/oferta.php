<?php 
    class Oferta implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $desti;
        private $preu_persona;
        private $data_inici;
        private $data_fi;

        // CONSTRUCTOR
        public function __construct($desti, $preu_persona, $data_inici, $data_fi, $id = null){
            $this->desti = $desti;
            $this->preu_persona = $preu_persona;
            $this->data_inici = $data_inici;
            $this->data_fi = $data_fi;
            $this->id = $id;
        }

        // GETTERS
        public function getDesti(){
            return $this->desti;
        }
        public function getPreuPersona(){
            return $this->preu_persona;
        }
        public function getDataInici(){
            return $this->data_inici;
        }
        public function getDataFi(){
            return $this->data_fi;
        }
        public function getId(){
            return $this->id;
        }
        
        // SETTERS

        public function setDesti($desti){
            $this->desti = $desti;
        }
        public function setPreuPersona($preu_persona){
            $this->preu_persona = $preu_persona;
        }
        public function setDataInici($data_inici){
            $this->data_inici = $data_inici;
        }
        public function setDataFi($data_fi){
            $this->data_fi = $data_fi;
        }
        public function setId($id){
            $this->id = $id;
        }

        // METHODS

        public function create(){
            $query = "INSERT INTO ofertes (id, iddesti, preupersona, datainici, datafi)
                        VALUES (null, :iddesti, :preupersona, :datainici, :datafi)";

            $params = array(':iddesti' => $this->getDesti(),
                            ':preupersona' => $this->getPreuPersona(),
                            ':datainici' => $this->getDataInici(),
                            ':datafi' => $this->getDataFi()
            );

            Connexio::connect();
            $stmt = Connexio::execute($query,$params);

            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function delete(){
            //Delete query
            $query = "DELETE FROM ofertes WHERE id = :id;";

            $params = array(":id" => $this->getId());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            
            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function jsonSerialize() {
            return [
                'destinacio' => $this->getDesti(),
                'preu_persona' => $this->getPreuPersona(),
                'data_inici' => $this->getDataInici(),
                'data_fi' => $this->getDataFi(),
                'id' => $this->getId()
            ];
        }
    }

?>