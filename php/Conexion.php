<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "kiosco";


$conexion = new mysqli($server, $user, $pass, $db);

// $gol = $_POST('ventas')

if($conexion->connect_errno){

    die("Conexion Fallida".$conexion->concect_errno);

} 
?>