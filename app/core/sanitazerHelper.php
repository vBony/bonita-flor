<?php

namespace core;
use core\modelHelper;

// TODO: MIGRAR PARA CLASSE HELPERS AS OPERAÇÕES DE DATA
class sanitazerHelper {
    public static function xss($str){
        return htmlentities($str);
    }

    public static function nomeCompleto($str){
        // $str = self::xss($str);

        return ucwords(strtolower($str));
    }

    public static function email($str){
        // $str = self::xss($str);

        return str_replace(' ', '', strtolower($str));
    }

    public static function texto($str){
        // $str = self::xss($str);

        return trim($str);
    }

    public static function boolVal($str){
        if($str === true){
            return true;
        }elseif($str === 'true'){
            return true;
        }elseif($str === 1){
            return  true;
        }else{
            return false;
        }
    }
}