<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;

class SistemaEndereco extends modelHelper{
    public $table = 'sistemaEndereco';

    public function __construct()
    {
        parent::__construct();
    }

    public function buscar(){
        $sql = "SELECT * FROM {$this->table} WHERE excluido = false";

        $sql = $this->db->prepare($sql);
        
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }
    
    public function salvar($data){
        $sql = "INSERT INTO {$this->table}
                (
                    cep,
                    logradouro,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado
                )
                VALUES(
                    :cep,
                    :logradouro,
                    :numero,
                    :complemento,
                    :bairro,
                    :cidade,
                    :estado
                )";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':cep', $data["cep"]);
        $sql->bindValue(':logradouro', $data["logradouro"]);
        $sql->bindValue(':numero', $data["numero"]);
        $sql->bindValue(':complemento', $data["complemento"]);
        $sql->bindValue(':bairro', $data["bairro"]);
        $sql->bindValue(':cidade', $data["cidade"]);
        $sql->bindValue(':estado', $data["estado"]);

        try {
            $this->db->beginTransaction();

            $sql->execute();

            $id = $this->db->lastInsertId();

            $this->db->commit();

            $this->excluir($id);

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();
            exit($e->getMessage());
            return false;
        }
    }

    public function excluir($idExcecao){
        $sql = "UPDATE {$this->table} SET excluido = 1 WHERE id != :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idExcecao);

        try {
            $this->db->beginTransaction();
            $sql->execute();
            $this->db->commit();

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }
}