<?php
namespace models\validators;
use models\AdminServico as Model;
use models\Servico;
use models\Categoria;

class AdminServico  {
    public $messages = [];
    private $emptyMessage = 'Campo obrigatório';

    public function validate($data){
        $this->idServico($data);
        $this->idCategoria($data);
    }

    public function getMessages(){
        return $this->messages;
    }

    public function getMessage($attr){
        if(isset($this->messages[$attr])){
            return $this->messages[$attr];
        }
    }

    public function idServico($data){
        $model = new Model();
        $Servico = new Servico();

        $idServico = isset($data['idServico']) ? $data['idServico'] : null;
        $idAdmin =  isset($data['idAdmin']) ? $data['idAdmin'] : null;
        $idCategoria = isset($data['idCategoria']) ? $data['idCategoria'] : null;

        if(empty($idServico)){
            $this->messages['servico'] = 'Serviço é obrigatório';
        }

        $servico = $Servico->buscar($idServico);

        if(empty($servico)){
            $this->messages['servico'] = 'Serviço não encontrado';
        }else{
            if(!empty($idCategoria)){
                if($idCategoria != $servico['idCategoria']){
                    $this->messages['servico'] = 'O serviço não pertence à categoria selecionada';
                }
            }
        }

        if(empty($idAdmin)){
            $this->messages['admin'] = 'Admin é obrigatório';
        }

        if(empty($this->messages)){
            if(!empty($model->buscarPorServico($idAdmin, $idServico))){
                $this->messages['servico'] = 'Serviço já adicionado';
            }
        }
    }

    public function idCategoria($data){
        $idCategoria = isset($data['idCategoria']) ? $data['idCategoria'] : null;

        $Categoria = new Categoria();

        if(empty($idCategoria)){
            $this->messages['categoria'] = 'Categoria é obrigatória';
        }

        $categoria = $Categoria->buscar($idCategoria);

        if(empty($categoria)){
            $this->messages['categoria'] = 'Categoria não encontrada';
        }
    }
}