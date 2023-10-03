<?php
require 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

define('BASE_URL', $_ENV['BASE_URL']);
?>