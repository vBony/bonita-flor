<?php
namespace models;
use core\modelHelper;

use \PDO;
use \PDOException;

class AdminServico extends modelHelper{

    public $table = 'adminServico';
    public static $sufix = 'ads';
    public static $attrs = [
        'id',
        'idServico',
        'idAdmin',
        'excluido'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarPorId($id, $idAdmin){
        $sufix = self::$sufix;
        $colunas = self::getColunas();

        $sufixServico = Servico::$sufix;
        $colunasServico = Servico::getColunas();

        $colunasCategoria = Categoria::getColunas();
        $sufixCategoria = Categoria::$sufix;

        $sql  = "SELECT 
                    {$colunas},
                    {$colunasServico},
                    {$colunasCategoria}
                FROM adminServico {$sufix}
                INNER JOIN servico {$sufixServico} on {$sufixServico}.id = {$sufix}.idServico
                    AND {$sufixServico}.excluido = 0
                INNER JOIN categoria {$sufixCategoria} ON {$sufixServico}.idCategoria = {$sufixCategoria}.id
                    AND {$sufixCategoria}.excluido = 0
                WHERE {$sufix}.idAdmin = :idAdmin
                AND {$sufix}.id = :id
                AND {$sufix}.excluido = 0";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idAdmin', $idAdmin);
        $sql->bindValue(':id', $id);
        $sql->execute();


        if($sql->rowCount() > 0){

            $data = $sql->fetch(PDO::FETCH_NAMED);

            return $this->setMapeamento($data);
        }
    }

    public function buscarPorAdmin($idAdmin){
        $sufix = self::$sufix;
        $colunas = self::getColunas();

        $sufixServico = Servico::$sufix;
        $colunasServico = Servico::getColunas();

        $colunasCategoria = Categoria::getColunas();
        $sufixCategoria = Categoria::$sufix;

        $sql  = "SELECT 
                    {$colunas},
                    {$colunasServico},
                    {$colunasCategoria}
                FROM adminServico {$sufix}
                INNER JOIN servico {$sufixServico} on {$sufixServico}.id = {$sufix}.idServico
                    AND {$sufixServico}.excluido = 0
                INNER JOIN categoria {$sufixCategoria} ON {$sufixServico}.idCategoria = {$sufixCategoria}.id
                    AND {$sufixCategoria}.excluido = 0
                WHERE {$sufix}.idAdmin = :idAdmin
                AND {$sufix}.excluido = 0";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idAdmin', $idAdmin);
        $sql->execute();


        if($sql->rowCount() > 0){

            $data = $sql->fetchAll(PDO::FETCH_NAMED);

            return $this->setMapeamentoLista($data);
        }
    }

    public function buscarPorServico($idAdmin, $idServico){
        $sufix = self::$sufix;
        $colunas = self::getColunas();

        $sufixServico = Servico::$sufix;
        $colunasServico = Servico::getColunas();

        $colunasCategoria = Categoria::getColunas();
        $sufixCategoria = Categoria::$sufix;

        $sql  = "SELECT 
                    {$colunas},
                    {$colunasServico},
                    {$colunasCategoria}
                FROM adminServico {$sufix}
                INNER JOIN servico {$sufixServico} on {$sufixServico}.id = {$sufix}.idServico
                    AND {$sufixServico}.excluido = 0
                INNER JOIN categoria {$sufixCategoria} ON {$sufixServico}.idCategoria = {$sufixCategoria}.id
                    AND {$sufixCategoria}.excluido = 0
                WHERE {$sufix}.idAdmin = :idAdmin
                AND {$sufix}.excluido = 0
                AND {$sufix}.idServico = :idServico";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idAdmin', $idAdmin);
        $sql->bindValue(':idServico', $idServico);
        $sql->execute();


        if($sql->rowCount() > 0){

            $data = $sql->fetch(PDO::FETCH_NAMED);

            return $this->setMapeamento($data);
        }
    }

    public function salvar($data){
        $sql = "INSERT INTO {$this->table}
                    (idServico, idAdmin)
                VALUES
                    (:idServico, :idAdmin)";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idServico', $data['idServico']);
        $sql->bindValue(':idAdmin', $data['idAdmin']);

        try {
            $this->db->beginTransaction();

            $sql->execute();
            $this->db->commit();

            return true;
        } catch(PDOException $e) {
            $this->db->rollback();

            exit($e->getMessage());
            // TODO: SALVAR ERRO NUMA TABELA DE LOG

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

    private function setMapeamento($dados){
        $registro = parent::mapear($dados, self::$sufix);
        $registro['servico'] = parent::mapear($dados, Servico::$sufix);
        $registro['servico']['categoria'] = parent::mapear($dados, Categoria::$sufix);

        return array_filter($registro);
    }

    private function setMapeamentoLista($dados){
        $lista = array();

        foreach($dados as $chave => $dado){
            $lista[$chave] = $this->setMapeamento($dado);
        }

        return $lista;
    }

    public static function getColunas(){
        return parent::setColunas(self::$sufix, self::$attrs);
    }
}