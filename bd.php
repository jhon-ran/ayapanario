<?php
//Descomentar para servidor remoto
$servidor = "127.0.0.1:3306";
$baseDatos = "u878617270_diccionario";
$usuario = "u878617270_ayapa";
$contrasena = "@NxXbBc6m";

//En caso de que no funcione el servidor remoto, descomentar para servidor local
//$servidor = "localhost";
//$baseDatos="diccionario";
//$usuario="root";
//$contrasena="";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contrasena);
}catch(Exception $ex){
    echo $ex->getMessage();
}

?>