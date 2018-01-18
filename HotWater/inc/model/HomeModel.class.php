<?php

namespace model;

class HomeModel {
    private $testo;
    
    public function __construct() {
        $this->testo = "testo 1";
    }
    
    public function getTesto() {
        return $this->testo;
    }
    
    public function setTesto(String $testo) {
        $this->testo = $testo;
    }
}
?>