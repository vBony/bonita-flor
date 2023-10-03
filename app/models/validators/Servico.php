<?php
namespace models\validators;
use models\Servico as Model;
use core\modelHelper as Helper;
use models\Categoria;

class Servico {
    public $messages = [];
    private $type;

    private $emptyMessage = 'Campo obrigatório';


    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function validate($data){
        $this->id($data);
        $this->nome($data);
        $this->preco($data);
        $this->duracao($data);
        $this->descricao($data);
    }

    public function getMessages(){
        return $this->messages;
    }

    public function getMessage($attr){
        if(isset($this->messages[$attr])){
            return $this->messages[$attr];
        }
    }

    public function nome($data){
        $nome = isset($data['nome']) ? $data['nome'] : null;
        $id = isset($data['id']) ? $data['id'] : null;
        $idCategoria = isset($data['idCategoria']) ? $data['idCategoria'] : null;

        $model = new Model();
        if($this->type == Helper::$CRIANDO){
            $categoria = $model->buscarPorNome($nome, $idCategoria, null);
        }else{
            $categoria = $model->buscarPorNome($nome, $idCategoria, $id);
        }

        if(empty($nome)){
            $this->messages['nome'] = $this->emptyMessage;
        }

        if(!empty($categoria)){
            $this->messages['nome'] = "Serviço já existe";
        }
    }

    public function preco($data){
        $preco = isset($data['preco']) ? floatval($data['preco']) : 0;

        if($preco <= 0){
            $this->messages['preco'] = "Digite um valor maior que zero";
        }
    }

    public function id($data){
        $id = isset($data['id']) ? $data['id'] : null;

        if($this->type == Helper::$ALTERANDO){
            if(empty($id)){
                $this->messages['id'] = $this->emptyMessage;
            }
        }
    }

    public function duracao($data){
        $duracao = isset($data['duracao']) ? $data['duracao'] : null;

        if(empty($duracao)){
            $this->messages["duracao"] = $this->emptyMessage;
        }else{
            $duracaoArr = explode(":", $duracao);
            $mensagem =  "Siga o seguinte padrão HH:MM";
            if(count($duracaoArr) == 2){
                if(strlen($duracaoArr[0]) < 2 || strlen($duracaoArr[1]) < 2){
                    $this->messages['duracao'] = $mensagem;    
                }
            }else{
                $this->messages['duracao'] = $mensagem;
            }
        }

    }

    public function descricao($data){
        $descricao = isset($data['descricao']) ? $data['descricao'] : null;

        if(!empty($descricao)){
            if(strlen($descricao) > 400){
                $this->messages['descricao'] = "Limite de texto atingido (400 caracteres).";
            }
        }
    }

    public function idCategoria($data){
        $idCategoria = isset($data['idCategoria']) ? $data['idCategoria'] : null;

        if(!empty($idCategoria)){
            $this->messages["idCategoria"] = $this->emptyMessage;
            
        }else{
            $modelCategoria = new Categoria();
            $categoria = $modelCategoria->buscar($idCategoria);
            if(empty($categoria)){
                $this->messages["idCategoria"] = "Categoria não existe.";
            }
        }
    }
}