<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
    class Oferta implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $desti;
        private $titol;
        private $preu_persona;
        private $data_inici;
        private $data_fi;

        // CONSTRUCTOR
        public function __construct($desti, $titol , $preu_persona, $data_inici, $data_fi, $id = null){
            $this->desti = $desti;
            $this->titol = $titol;
            $this->preu_persona = $preu_persona;
            $this->data_inici = $data_inici;
            $this->data_fi = $data_fi;
            $this->id = $id;
        }

        // GETTERS
        public function getDesti(){
            return $this->desti;
        }
        public function getTitol(){
            return $this->titol;
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
        public function setTitol($titol){
            $this->titol = $titol;
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

        /**
         * create
         *
         * @return boolean
         * 
         * Métode per introduir una oferta a la BBDD
         */
        public function create(){
            $query = "INSERT INTO ofertes (id, iddesti, titol, preupersona, datainici, datafi)
                        VALUES (null, :iddesti, :titol, :preupersona, :datainici, :datafi)";

            $params = array(':iddesti' => $this->getDesti(),
                            ':titol' => $this->getTitol(),
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

        /**
         * delete
         *
         * @return boolean
         * 
         * Métode per eliminar una oferta de la BBDD
         */
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

        /**
         * jsonSerialize
         *
         * @return Array
         * 
         * Métode de la interfície JsonSerializable que indica la seva estructura quan es converteixi a JSON
         */
        public function jsonSerialize() {
            return [
                'destinacio' => $this->getDesti(),
                'titol' => $this->getTitol(),
                'preu_persona' => $this->getPreuPersona(),
                'data_inici' => $this->getDataInici(),
                'data_fi' => $this->getDataFi(),
                'id' => $this->getId()
            ];
        }
    }

?>