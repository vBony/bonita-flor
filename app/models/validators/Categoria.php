<?php
namespace models\validators;
use models\Categoria as Model;
use core\modelHelper as Helper;
class Categoria  {
    public $messages = [];
    private $type;

    private $emptyMessage = 'Campo obrigatório';


    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function validate($data){
        $this->id($data);
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

    public function descricao($data){
        $descricao = isset($data['descricao']) ? $data['descricao'] : null;
        $id = isset($data['id']) ? $data['id'] : null;

        $model = new Model();
        if($this->type == Helper::$CRIANDO){
            $categoria = $model->buscarPorDescricao($descricao);
        }else{
            $categoria = $model->buscarPorDescricao($descricao, $id);
        }

        if(empty($descricao)){
            $this->messages['descricao'] = $this->emptyMessage;
        }

        if(!empty($categoria)){
            $this->messages['descricao'] = "Categoria já existe";
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
}  