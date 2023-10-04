<?php
namespace models;
use core\modelHelper;
use core\sanitazerHelper;
use models\SistemaEndereco;
use models\SistemaHorarios;
use models\SistemaDiasAtendimento;

class Sistema extends modelHelper {
    private $mEndereco;
    private $mHorarios;
    private $mDiasAtendimento;

    public function __construct()
    {
        parent::__construct();
        $this->mEndereco = new SistemaEndereco();
        $this->mHorarios = new SistemaHorarios();
        $this->mDiasAtendimento = new SistemaDiasAtendimento();
    }
    
    public function buscar(){
        $endereco = $this->mEndereco->buscar();   
        $horarios = $this->mHorarios->buscar();
        $diasAtendimento = $this->mDiasAtendimento->buscar();

        $data['endereco'] = !empty($endereco) ? $endereco : null;

        $data['horarios']['atendimento']['inicio'] = !empty($horarios['inicioAtendimento']) ? $horarios['inicioAtendimento'] : null;
        $data['horarios']['atendimento']['fim'] = !empty($horarios['fimAtendimento']) ? $horarios['fimAtendimento'] : null;
        $data['horarios']['intervalo']['inicio'] = !empty($horarios['inicioIntervalo']) ? $horarios['inicioIntervalo'] : null;
        $data['horarios']['intervalo']['fim'] = !empty($horarios['fimIntervalo']) ? $horarios['fimIntervalo'] : null;

        $data['diasAtendimento'] = !empty($diasAtendimento) ? $this->intToBoolean($diasAtendimento) : null;

        return $data;
    }

    public function intToBoolean($list){
        foreach($list as $i => $row){
            $list[$i] = sanitazerHelper::boolVal($row);
        }

        return $list;
    }
}