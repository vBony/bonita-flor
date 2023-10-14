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


        $this->send(200, $response);
    }

    public function apiDisponibilidade(){
        /**
         * TODO:
         * - Buscar os profissionais por serviço disponíveis, as horas disponiveis
         */
        $request = $this->post('agendamento');
        $servicos = $request['servicos'];

        // Buscando os profissionais disponíveis para atender os serviços selecionados
        $disponibilidade = array();
        foreach($servicos as $servico){
            $servico['admins'] = $this->mSistema->buscarDisponibilidadePorServico($servico['id']);
            array_push($disponibilidade, $servico);
        }

        $this->send(200, $disponibilidade);
    }
}