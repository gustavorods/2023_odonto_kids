<?php
    include_once 'Conectar.php';

    class metodos_dashboard{
        private $responsavel_id;

        public function getResponsavelId() {
            return $this->responsavel_id;
        }
    
        public function setResponsavelId($responsavel_idd) {
            $this->responsavel_id = $responsavel_idd;
        }
    }
?>