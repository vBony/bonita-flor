<?php
require 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

header("Access-Control-Allow-Origin: *");

define('BASE_URL', $_ENV['BASE_URL']);

global $db;
try{
    $db = new PDO('mysql:dbname='.$_ENV['DB_NAME'].';host='.$_ENV['HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
}catch(PDOException $e){
    echo "Error: ".$e->getMessage();
    exit;
}