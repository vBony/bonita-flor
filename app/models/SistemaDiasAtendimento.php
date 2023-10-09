<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;
use core\sanitazerHelper as Sanitazer;

class SistemaDiasAtendimento extends modelHelper{
    public $table = 'sistemaDiasAtendimento';

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
        $sql = "INSERT INTO	{$this->table}
                (
                    segunda,
                    terca,
                    quarta,
                    quinta,
                    sexta,
                    sabado,
                    domingo
                )
                VALUES(
                    :segunda,
                    :terca,
                    :quarta,
                    :quinta,
                    :sexta,
                    :sabado,
                    :domingo
                );";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':segunda', Sanitazer::boolVal($data['segunda']));
        $sql->bindValue(':terca',   Sanitazer::boolVal($data['terca']));
        $sql->bindValue(':quarta',  Sanitazer::boolVal($data['quarta']));
        $sql->bindValue(':quinta',  Sanitazer::boolVal($data['quinta']));
        $sql->bindValue(':sexta',   Sanitazer::boolVal($data['sexta']));
        $sql->bindValue(':sabado',  Sanitazer::boolVal($data['sabado']));
        $sql->bindValue(':domingo', Sanitazer::boolVal($data['domingo']));

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