<?php
#error_checking 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#class_call
spl_autoload_register(function($c){include $c.'.php';});

#configuration
$base="http://localhost/restok";
$panel="http://localhost/restok";
$app="Restok Barang dengan Algoritma FIFO";
$copyright="Re-fansMU";
$host="localhost";
$user="root";
$password="";
$db="restok";
?>