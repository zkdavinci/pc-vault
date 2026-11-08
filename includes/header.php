
<?php
$ruta = $ruta ?? "";
$pagina = $pagina ?? "inicio";
?>
<!DOCTYPE html>
<html lang="es">
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

        <nav class="navegacion">
            <a href="<?= $ruta ?>index.php"
               class="<?= $pagina === 'inicio' ? 'enlace-activo' : '' ?>">
                Inicio
            </a>

            <a href="<?= $ruta ?>index.php#catalogo">
                Catalogo
            </a>

            <a href="<?= $ruta ?>admin/index.php"
               class="<?= $pagina === 'admin' ? 'enlace-activo' : '' ?>">
                Administracion
            </a>
        </nav>
    </div>
</header>
