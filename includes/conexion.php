
<?php

// Configuracion de la base de datos local
$host = "localhost";
$usuario = "root";
$contrasena = "";
$baseDatos = "pc_vault";

try {
    $conexion = new mysqli(
        $host,
        $usuario,
        $contrasena,
        $baseDatos
    );

    $conexion->set_charset("utf8mb4");

} catch (mysqli_sql_exception $error) {
    error_log($error->getMessage());
    http_response_code(500);
    die("Error al conectar con la base de datos.");
}
