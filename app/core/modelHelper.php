<?php
namespace core;
use core\Database;
class modelHelper{
    protected $db;
    public static $CRIANDO = 'insert';
    public static $ALTERANDO = 'update';

    public function __construct() {
        $this->db = Database::getInstance();
    }   

    public function diretorioBase(){
        return dirname(__FILE__, 3) . '/';
    }

    public function xss($str){
        return htmlentities($str);
    }

    public static function createdAt(){
        return date('Y-m-d H:i:s');
    }

    public static function getIpAddress(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function setColunas($sufixo, $atributos){
        $retorno = array();
        foreach($atributos as $atributo){
            $str = "$sufixo.$atributo"." as ".$sufixo."_".$atributo;
            array_push($retorno, $str);
        }

        return implode(",", $retorno);
    }

    public static function mapear($dados, $sufix){
        $retorno = array();
        foreach($dados as $chave => $coluna){
            $arrChave = explode("_", $chave);

            if(isset($arrChave[0]) && !empty($arrChave[0])){
                if($arrChave[0] == $sufix){
                    $data = $coluna;
                    $nomeColuna = $arrChave[1];

                    $retorno[$nomeColuna] = $data;
                }
            }
            
        }

        return $retorno;
    }
}
?>