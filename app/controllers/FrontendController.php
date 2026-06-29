<?php 

require_once __DIR__ . '/../middleware/auth.php';

class FrontendController
{
   
    public function __construct() {
        exigirAutenticacao();
    }

    public function pessoas() {
        $tituloPagina = 'Pessoas';
        require_once __DIR__ . '/../views/pessoas/index.php';
    }

    public function tipos() {
        $tituloPagina = 'Tipos de Atendimento';
        require_once __DIR__ . '/../views/tipos-atendimentos/index.php';
    }

    public function atendimentos() {
        $tituloPagina = 'Atendimentos';
        require_once __DIR__ . '/../views/atendimentos/index.php';
    }

}