<?php
require "enviroment.php";

$data = array();
if(ENVIROMENT == 'development'){
    define('BASE_URL', 'http://localhost/bonita-flor/');
    $data['host'] = 'srv1056.hstgr.io';
    $data['db_name'] = 'u729110013_bnt_flor';
    $data['user_db'] = 'u729110013_bnt_flor_sys';
    $data['user_pass_db'] = 'ISbaP2r>';
}else{
    define('BASE_URL', 'https://www.admin.benurse.com.br/');
    $data['host'] = 'localhost';
    $data['db_name'] = 'benurs81_benurse';
    $data['user_db'] = 'benurs81_admin';
    $data['user_pass_db'] = 'Sacramento1@';
}

global $db;
try{
    $db = new PDO('mysql:dbname='.$data['db_name'].';host='.$data['host'], $data['user_db'], $data['user_pass_db']);
}catch(PDOException $e){
    echo "Error: ".$e->getMessage();
    exit;
}