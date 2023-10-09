<?php
namespace models\validators;

use helpers\UploadFile;
use models\Admin as modelAdmin;

class Admin  {
    public $messages = [];
    private $emptyMessage = 'Campo obrigatório';
    private $type;

    //Campos foto de perfil
    private $alturaMinima = 480;
    private $larguraMinima = 720;
    private $tamanhoMaximo = 5;
    
    public static $CRIANDO = 'insert';
    public static $ALTERANDO = 'update';

    public function __construct($type = null)
    {
        $this->type = $type;
    }


    public function validate($data){
        if($this->type == self::$CRIANDO){
            $this->validateCriar($data);
        }

        if($this->type == self::$ALTERANDO){
            $this->validateAlterar($data);
        }
    }

    public function validarFotoPerfil($foto){
        $validaFoto = new UploadFile($foto);

        if(!empty($foto)){
            if($validaFoto->getWidth() < $this->larguraMinima || $validaFoto->getHeight() < $this->alturaMinima){
                $this->messages['foto'] = "Imagem muito pequena, tamanho mínimo: {$this->alturaMinima}x{$this->larguraMinima}";
            }
    
            if($validaFoto->getMbSize() > $this->tamanhoMaximo){
                $this->messages['foto'] = "Imagem muito grande, tamanho máximo: {$this->tamanhoMaximo}mb";
            }
        }
    }

    public function validateAlterar($data){
        $this->nome($data);
        $this->email($data);
        $this->descricao($data);
        $this->senha($data);
    }
        

    private function validateCriar($data){
        $this->nome($data);
        $this->email($data);
        $this->senhaAoCriar($data);
    }

    public function getMessages(){
        return $this->messages;
    }

    public function getMessage($attr){
        if(isset($this->messages[$attr])){
            return $this->messages[$attr];
        }
    }

    // nome	lastName	email	urlAvatar	senha	
    public function nome($data){
        $nome = $data['nome'];

        if(!empty($nome)){
            if(strlen($nome) <= 2 || count(explode(' ', $nome)) <= 1)
                $this->messages['nome'] = 'Digite seu nome completo';
        }else{
            $this->messages['nome'] = $this->emptyMessage;
        }
    }

    public function email($data){
        $email = $data['email'];
        $id = isset($data['id']) ? $data['id'] : null;
        $Admin = new modelAdmin();

        if(empty($email)){
            $this->messages['email'] = $this->emptyMessage;
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->messages['email'] = "Email inválido"; 
            }else{
                $userFind = array();
                if($this->type == self::$CRIANDO)
                    $userFind = $Admin->buscarPorEmail($email);
                    
                if($this->type == self::$ALTERANDO)
                    $userFind = $Admin->buscarPorEmail($email, $id);

                if(!empty($userFind)){
                    $this->messages['email'] = "E-mail já está em uso";
                }
            }
        }
    }

    public function senha($data){
        if($this->type == self::$ALTERANDO){
            $this->senhaAlterando($data);
        }else{
            $this->senhaCriando($data);
        }
    }

    private function senhaAlterando($data){
        $pass = $data['senha'];

        if(!empty($pass)){
            if(strlen($pass) < 5 && $this->type == self::$CRIANDO){
                $this->messages['senha'] = 'A senha deve conter no mínimo 5 caracteres';
            }
        }
    }

    private function senhaCriando($data){
        $pass = $data['senha'];

        if(!empty($pass)){
            if(strlen($pass) < 5 && $this->type == self::$CRIANDO){
                $this->messages['senha'] = 'A senha deve conter no mínimo 5 caracteres';
            }
        }else{
            $this->messages['senha'] = $this->emptyMessage;
        }
    }

    public function retypePassword($data){
        $pass = $data['senha'];
        $rpass = $data['retypePassword'];

        if(!empty($rpass)){
            if($pass != $rpass){
                $this->messages['senha'] = 'As senhas não conferem';
                $this->messages['retypePassword'] = 'As senhas não conferem';
            }
        }else{
            $this->messages['retypePassword'] = $this->emptyMessage;
        }
    }

    public function descricao($data){
        $descricao = isset($data['descricao']) ? $data['descricao'] : null;

        if(!empty($descricao)){
            $descricao = trim($descricao);

            if(strlen($descricao) > 600){
                $this->messages['descricao'] = 'Texto muito longo, limite máximo de 600 caracteres.';
            }
        }
    }

    public function senhaAoCriar($data){
        $this->senha($data);
        // $this->retypePassword($data);
    }
}

// 53151453
// Quadra 48, Conjunto F, Casa 29 - Vila São José (Brazlândia - DF)