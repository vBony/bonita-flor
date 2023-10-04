<?php
use core\controllerHelper;
use models\Sistema;
use models\SistemaEndereco;

class agendamentoController extends controllerHelper {
    private $mEndereco;
    private $mSistema;

    public function __construct(){
        $this->mSistema = new Sistema();
    }

    public function viewIndex(){
        $this->loadView('agendar', array());
    }

    public function apiIndex(){
        $sistema = $this->mSistema->buscar();

        $this->send(200, $sistema);
    }
}