<?php
namespace models;
use core\modelHelper;

use core\sanitazerHelper as Sanitazer;

use \PDO;
use \PDOException;

class Servico extends modelHelper{

    public $table = 'servico';
    public static $sufix = 'svc';
    public static $attrs = [
        'id',
        'idCategoria',
        'descricao',
        'nome',
        'preco',
        'duracao',
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

    public function buscarPorCategoria($idCategoria){
        $sql  = "SELECT * FROM {$this->table} 
                WHERE idCategoria = :id
                AND excluido = 0";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $idCategoria);

        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    public function buscarPorNome($nome, $idCategoria, $idExcecao = null){
        $sql = "SELECT * FROM {$this->table} 
                WHERE nome = :nome 
                AND excluido = 0 
                AND idCategoria = :idCategoria ";

        if(!empty($idExcecao)){
            $sql .= "AND id != :id ";
        }

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':idCategoria', $idCategoria);
        if(!empty($idExcecao)){
            $sql->bindValue(':id', $idExcecao);
        }
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function alterar($data){
        $sql = "UPDATE
                    {$this->table}
                SET
                    descricao = :descricao,
                    nome = :nome,
                    preco = :preco,
                    duracao = :duracao
                WHERE
                    id = :id";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(':id', $data['id']);
        $sql->bindValue(':descricao', $data['descricao']);
        $sql->bindValue(':nome', $data['nome']);
        $sql->bindValue(':preco', $data['preco']);
        $sql->bindValue(':duracao', $data['duracao']);

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


    public function salvar($data){
        $sql = "INSERT INTO
                    {$this->table}
                (
                    idCategoria,
                    descricao,
                    nome,
                    preco,
                    duracao
                )
                VALUES(
                    :idCategoria,
                    :descricao,
                    :nome,
                    :preco,
                    :duracao
                );";
                
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idCategoria', $data["idCategoria"]);
        $sql->bindValue(':descricao', $data["descricao"]);
        $sql->bindValue(':nome', Sanitazer::nomeCompleto($data["nome"]));
        $sql->bindValue(':preco', $data["preco"]);
        $sql->bindValue(':duracao', $data["duracao"]);

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