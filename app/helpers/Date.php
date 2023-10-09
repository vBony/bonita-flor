<?php
namespace helpers;
use core\modelHelper;
use \DateTime;

class Date{
    public function diferencaDatasPorExtenso($dataFinal, $tipo = 'restante'){
        $agora = (new modelHelper())->createdAt();

        $agora      = new DateTime($agora);
        $diff       = $agora->diff( new DateTime($dataFinal));

        $restanteValidade = '';

        $dias = $diff->days;
        $horas = $diff->format('%H');
        $minutos = $diff->format('%i');
        
        if($tipo == 'restante'){
            if($dias > 0){
                $restanteValidade = $dias . ($dias > 1 ? ' dias' : ' dia');
            }else{
                if($horas > 0){
                    $restanteValidade = $horas . ($horas > 1 ? ' horas' : ' hora');
                }else{
                    $restanteValidade = $minutos . ($minutos > 1 ? ' minutos' : ' minuto');
                }
            }
        }

        if($tipo == 'passado_simples'){
            if($dias > 0){
                return $dias . ' d';
            }else{
                if($horas > 0){
                    return $horas . ' h';
                }else{
                    if($minutos <= 1){
                        return ' agora';
                    }else{
                        return $minutos . ' min';
                    }
                }
            }
        }

        return $restanteValidade;
    }

    public function now(){
        return date('Y/m/d');
    }

    public function addDays($date = null, $days){
        date_default_timezone_set('America/Sao_Paulo');

        if(empty($date)){
            $date = $this->now();
        }

        $date = strtotime($date);
        $date = strtotime("+ $days day", $date);

        return date('Y/m/d', $date);
    }

    public function dataNormal($data){
        return date('d/m/Y',  strtotime($data));
    }

    public function hora($data){
        return date('H:i:s',  strtotime($data));
    }

    public function dataEHora($data, $divider = false){
        if(!$divider){
            return date('d/m/Y H:i:s',  strtotime($data));
        }else{
            return date('d/m/Y à\s H:i:s',  strtotime($data));
        }
    }

    public function numberFormatShort($number, $precision = 1 ) {
        if ($number < 900) {
            // 0 - 900
            $n_format = number_format($number, $precision);
            $suffix = '';
        } else if ($number < 900000) {
            // 0.9k-850k
            $n_format = number_format($number / 1000, $precision);
            $suffix = 'K';
        } else if ($number < 900000000) {
            // 0.9m-850m
            $n_format = number_format($number / 1000000, $precision);
            $suffix = 'M';
        } else if ($number < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($number / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($number / 1000000000000, $precision);
            $suffix = 'T';
        }
    
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
    
        return $n_format . $suffix;
    }
}