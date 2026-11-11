
<?php

// Conexion local o del hosting
$servidor = $_SERVER["SERVER_NAME"] ?? "localhost";

if ($servidor === "localhost" || $servidor === "127.0.0.1") {

    // Configuracion de XAMPP
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDatos = "pc_vault";

} else {

    // Configuracion privada de InfinityFree
    $config = require __DIR__ . "/config-hosting.php";

    $host = $config["host"];
    $usuario = $config["usuario"];
    $contrasena = $config["contrasena"];
    $baseDatos = $config["baseDatos"];
}

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
