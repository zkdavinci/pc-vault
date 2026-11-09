
<?php
session_start();

require __DIR__ . "/../includes/conexion.php";

// Solo aceptamos solicitudes POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Verificamos el token de seguridad
$token = $_POST["csrf_token"] ?? null;

if (
    !is_string($token) ||
    empty($_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $token)
) {
    $_SESSION["flash_error"] = "Solicitud no valida.";
    header("Location: index.php", true, 303);
    exit;
}

// Validamos el ID del videojuego
$id = filter_var(
    $_POST["id"] ?? null,
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if ($id === false || $id === null) {
    $_SESSION["flash_error"] = "ID de videojuego no valido.";
    header("Location: index.php", true, 303);
    exit;
}

// Eliminamos utilizando una consulta preparada
$sql = "DELETE FROM juegos WHERE id = ?";

$stmt = mysqli_prepare($conexion, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$filasEliminadas = mysqli_stmt_affected_rows($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);

// Mostramos el resultado
if ($filasEliminadas === 1) {
    $_SESSION["flash"] =
        "El videojuego se elimino correctamente.";
} else {
    $_SESSION["flash_error"] =
        "No se encontro el videojuego seleccionado.";
}

header("Location: index.php", true, 303);
exit;
