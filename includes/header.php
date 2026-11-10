
<?php
$ruta = $ruta ?? "";
$pagina = $pagina ?? "inicio";

// Preferencia guardada en la cookie
$tema = ($_COOKIE["pc_vault_tema"] ?? "") === "claro"
    ? "claro"
    : "oscuro";

$volver = $_SERVER["REQUEST_URI"] ?? "/";
?>
<!DOCTYPE html>
<html lang="es" data-tema="<?= $tema ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Vault | Videojuegos para PC</title>
    <link rel="stylesheet" href="<?= $ruta ?>css/general.css">
</head>
<body>

<header class="cabecera">
    <div class="contenedor cabecera-interior">

        <a href="<?= $ruta ?>index.php" class="logo">
            <span class="logo-icono">P</span>
            PC <span class="logo-acento">VAULT</span>
        </a>

        <?php require __DIR__ . "/nav.php"; ?>

    </div>
</header>
