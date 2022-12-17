<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
* @author: Jordi Palomino <j.palomino@sapalomera.cat>
*
**/
    class Destinacio implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $continent;
        private $pais;
        private $imatges;

        // CONSTRUCTOR
        public function __construct($continent, $pais, $imatges, $id = null){
            $this->continent = $continent;
            $this->pais = $pais;
            $this->imatges = $imatges;
            $this->id = $id;
        }

        // GETTERS
        public function getContinent(){
            return $this->continent;
        }
        public function getPais(){
            return $this->pais;
        }
        public function getImatges(){
            return $this->imatges;
        }
        public function getId(){
            return $this->id;
        }
        
        // SETTERS
        public function setContinent($continent){
            $this->continent = $continent;
        }
        public function setpais($pais){
            $this->pais = $pais;
        }
        public function setImatges($imatges){
            $this->imatges = $imatges;
        }
        public function setId($id){
            $this->id = $id;
        }

        // METHODS
        /**
         * jsonSerialize
         *
         * @return JSONObject
         * 
         * Métode de la interfície JsonSerializable que indica la seva estructura quan es converteixi a JSON
         */
        public function jsonSerialize() {
            return [
                'id' => $this->getId(),
                'continent' => $this->getContinent(),
                'pais' => $this->getPais(),
                'imatges' => $this->getImatges()
            ];
        }
    }

?>