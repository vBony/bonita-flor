<?php
namespace models;

use core\controllerHelper;
use core\modelHelper;

use \PDO;
use \PDOException;

class Categoria extends modelHelper{

    public $table = 'categoria';
    public static $sufix = 'cat';
    public static $attrs = [
        'id',
        'descricao',
        'excluido'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function buscar($id = null){
        $sql  = "SELECT 
                    *
                FROM {$this->table} 
                WHERE excluido = 0 ";
        
        if(!empty($id)){
            $sql .= "AND id = :id";
        }

        $sql = $this->db->prepare($sql);

        if(!empty($id)){
            $sql->bindValue(':id', $id);
        }

        $sql->execute();

        if($sql->rowCount() > 0){
            if(!empty($id)){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                return $data;
            }else{
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }
        }
    }

    public function buscarPorDescricao($descricao, $idExcecao = null){
        $sql = "SELECT * FROM categoria c WHERE c.descricao = :descricao AND excluido = 0 ";

        if(!empty($idExcecao)){
            $sql .= "AND id != :id ";
        }

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':descricao', $descricao);
        if(!empty($idExcecao)){
            $sql->bindValue(':id', $idExcecao);
        }
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function salvar($data){
        $sql = "INSERT INTO categoria SET descricao = :descricao";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':descricao', $data["descricao"]);

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

    public function alterar($data){
        $sql = "UPDATE {$this->table} SET descricao = :descricao WHERE id = :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':descricao', $data["descricao"]);
        $sql->bindValue(':id', $data["id"]);

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

    public function excluir($id){
        $sql = "UPDATE {$this->table} SET excluido = 1 WHERE id = :id";
        $sql = $this->db->prepare($sql);

        $sql->bindValue(':id', $id);

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

    public static function getColunas(){
        return parent::setColunas(self::$sufix, self::$attrs);
    }
}