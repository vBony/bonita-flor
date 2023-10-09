<?php
namespace models;

use core\modelHelper;
use \PDO;
use \PDOException;

class SistemaHorarios extends modelHelper{
    public $table = 'sistemaHorarios';

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
        $atendimento = $data['atendimento'];
        $intervalo = $data['intervalo'];

        $sql = "INSERT INTO {$this->table}
                (
                    inicioAtendimento,
                    fimAtendimento,
                    inicioIntervalo,
                    fimIntervalo
                )
                VALUES(
                    :inicioAtendimento,
                    :fimAtendimento,
                    :inicioIntervalo,
                    :fimIntervalo
                )";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':inicioAtendimento', $atendimento['inicio']);
        $sql->bindValue(':fimAtendimento', $atendimento['fim']);
        $sql->bindValue(':inicioIntervalo', $intervalo['inicio']);
        $sql->bindValue(':fimIntervalo', $intervalo['fim']);

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