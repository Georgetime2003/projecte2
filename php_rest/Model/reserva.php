<?php 
    class Reserva implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $oferta;
        private $client;
        private $telf;
        private $n_persones;
        private $descompte;
        private $data_reserva;

        // CONSTRUCTOR
        public function __construct($oferta, $client, $telf, $n_persones, $descompte, $data_reserva, $id = null){
            $this->oferta = $oferta;
            $this->client = $client;
            $this->telf = $telf;
            $this->n_persones = $n_persones;
            $this->descompte = $descompte;
            $this->data_reserva = $data_reserva;
            $this->id = $id;
        }

        // GETTERS
        public function getOferta(){
            return $this->oferta;
        }
        public function getClient(){
            return $this->client;
        }
        public function getTelf(){
            return $this->telf;
        }
        public function getNumPersones(){
            return $this->n_persones;
        }
        public function getDescompte(){
            return $this->descompte;
        }
        public function getDataReserva(){
            return $this->data_reserva;
        }
        public function getId(){
            return $this->id;
        }
        
        // SETTERS

        public function setOferta($oferta){
            $this->oferta = $oferta;
        }
        public function setClient($client){
            $this->client = $client;
        }
        public function setTelf($telf){
            $this->telf = $telf;
        }
        public function setNumPersones($n_persones){
            $this->n_persones = $n_persones;
        }
        public function setDescompte($descompte){
            $this->descompte = $descompte;
        }
        public function setDataReserva($data_reserva){
            $this->data_reserva = $data_reserva;
        }
        public function setId($id){
            $this->id = $id;
        }

        // METHODS

        public function jsonSerialize() {
            return [
                'oferta' => $this->getOferta(),
                'client' => $this->getClient(),
                'telf' => $this->getTelf(),
                'num_persones' => $this->getNumPersones(),
                'descompte' => $this->getDescompte(),
                'data_reserva' => $this->getDataReserva(),
                'id' => $this->getId()
            ];
        }
    }

?>