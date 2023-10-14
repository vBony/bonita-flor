<?php
namespace models;
use core\modelHelper;
use core\sanitazerHelper;
use models\SistemaEndereco;
use models\SistemaHorarios;
use models\SistemaDiasAtendimento;
use models\Admin;
use \DateTime;
use \DateTimeZone;
use helpers\Date;

class Sistema extends modelHelper {
    private $mEndereco;
    private $mHorarios;
    private $mDiasAtendimento;
    private $mAdmin;

    private $periodoMaxAgendamentoDias = 30;

    public function __construct()
    {
        parent::__construct();
        $this->mEndereco = new SistemaEndereco();
        $this->mHorarios = new SistemaHorarios();
        $this->mDiasAtendimento = new SistemaDiasAtendimento();
        $this->mAdmin = new Admin();
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

        $data['regras'] = $this->getConfiguracoes();

        return $data;
    }

    public function getConfiguracoes(){
        $date = new Date();

        $maxDate = $date->addDays(null, $this->periodoMaxAgendamentoDias);
        $minDate = $date->now();
        
        return compact('maxDate', 'minDate');
    }

    public function intToBoolean($list){
        foreach($list as $i => $row){
            $list[$i] = sanitazerHelper::boolVal($row);
        }

        return $list;
    }

    public function buscarDisponibilidadePorServico($idServico){
        $admins = $this->mAdmin->buscarPorServico($idServico);

        return $admins;
    }
}