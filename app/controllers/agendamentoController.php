<?php
use core\controllerHelper;
use models\Categoria;
use models\Sistema;
use models\SistemaEndereco;

class agendamentoController extends controllerHelper {
    private $mEndereco;
    private $mSistema;
    private $mCategorias;

    public function __construct(){
        $this->mSistema = new Sistema();
        $this->mCategorias = new Categoria();
    }

    public function viewIndex(){
        $this->loadView('agendar', array());
    }

    public function apiIndex(){
        $sistema = $this->mSistema->buscar();
        $categorias = $this->mCategorias->buscar();

        $response['sistema'] = $sistema;
        $response['categorias'] = $categorias;
        $response['agenda'] = 


        $this->send(200, $response);
    }
}