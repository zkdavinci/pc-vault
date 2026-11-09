
<?php

// Alternamos entre tema oscuro y claro
$temaActual = ($_COOKIE["pc_vault_tema"] ?? "") === "claro"
    ? "claro"
    : "oscuro";

// Ruta principal del proyecto
$base = rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/\\");
$inicio = $base . "/index.php";

// Solo permitimos cambiar el tema mediante POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . $inicio);
    exit;
}

$nuevoTema = $temaActual === "oscuro" ? "claro" : "oscuro";

// Guardamos la preferencia durante 30 dias
setcookie("pc_vault_tema", $nuevoTema, [
    "expires" => time() + 60 * 60 * 24 * 30,
    "path" => "/",
    "secure" => !empty($_SERVER["HTTPS"])
        && $_SERVER["HTTPS"] !== "off",
    "httponly" => true,
    "samesite" => "Lax"
]);

// Regresamos a la pagina donde estaba el usuario
$volver = $_POST["volver"] ?? "";
$permitidas = [
    $base . "/",
    $base . "/index.php",
    $base . "/admin/",
    $base . "/admin/index.php",
    $base . "/admin/agregar.php",
    $base . "/admin/editar.php"
];

$partes = is_string($volver) ? parse_url($volver) : false;

if (
    !is_array($partes) ||
    isset($partes["scheme"]) ||
    isset($partes["host"]) ||
    !in_array($partes["path"] ?? "", $permitidas, true) ||
    preg_match('/[\r\n]/', $volver)
) {
    $volver = $inicio;
}

header("Location: " . $volver, true, 303);
exit;
