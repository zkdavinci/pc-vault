
<?php
$ruta = $ruta ?? "";
$pagina = $pagina ?? "inicio";

// Leemos la preferencia guardada en la cookie
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

        <nav class="navegacion">

            <a
                href="<?= $ruta ?>index.php"
                class="<?= $pagina === 'inicio' ? 'enlace-activo' : '' ?>"
            >
                Inicio
            </a>

            <a href="<?= $ruta ?>index.php#catalogo">
                Catalogo
            </a>

            <a
                href="<?= $ruta ?>admin/index.php"
                class="<?= $pagina === 'admin' ? 'enlace-activo' : '' ?>"
            >
                Administracion
            </a>

            <form
                action="<?= $ruta ?>cambiar-tema.php"
                method="POST"
                class="form-tema"
            >
                <input
                    type="hidden"
                    name="volver"
                    value="<?= htmlspecialchars(
                        $volver,
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>"
                >

                <button type="submit" class="boton-tema">
                    <?= $tema === "oscuro"
                        ? "☀ Modo claro"
                        : "☾ Modo oscuro" ?>
                </button>
            </form>

        </nav>

    </div>
</header>
