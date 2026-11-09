
<?php
session_start();

require __DIR__ . "/../includes/conexion.php";

$ruta = "../";
$pagina = "admin";

// Token de seguridad para eliminar videojuegos
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Recuperamos los videojuegos
$sql = "SELECT id, nombre, genero, anio, rating
        FROM juegos
        ORDER BY id DESC";

$resultado = mysqli_query($conexion, $sql);
$totalJuegos = mysqli_num_rows($resultado);

// Mensajes de confirmacion y error
$mensaje = $_SESSION["flash"] ?? "";
$error = $_SESSION["flash_error"] ?? "";

unset($_SESSION["flash"], $_SESSION["flash_error"]);

require __DIR__ . "/../includes/header.php";
?>

<main class="contenedor admin-seccion">

    <div class="admin-encabezado">
        <div>
            <span class="etiqueta">PANEL DE CONTROL</span>
            <h1>Administracion de juegos</h1>
            <p>
                Gestiona los videojuegos disponibles
                en el catalogo de PC Vault.
            </p>
        </div>

        <a href="agregar.php" class="boton-principal">
            + Agregar juego
        </a>
    </div>

    <?php if ($mensaje !== ""): ?>
        <div class="admin-exito">
            <?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div class="admin-errores">
            <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
        </div>
    <?php endif; ?>

    <div class="admin-tabla-contenedor">

        <table class="admin-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Videojuego</th>
                    <th>Genero</th>
                    <th>Año</th>
                    <th>Rating</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($juego = mysqli_fetch_assoc($resultado)): ?>

                    <tr>
                        <td><?= (int) $juego["id"] ?></td>

                        <td>
                            <?= htmlspecialchars(
                                $juego["nombre"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $juego["genero"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td><?= (int) $juego["anio"] ?></td>

                        <td>
                            ★ <?= htmlspecialchars((string) $juego["rating"]) ?>
                        </td>

                        <td>
                            <div class="admin-acciones">

                                <a
                                    href="editar.php?id=<?= (int) $juego["id"] ?>"
                                    class="accion-editar"
                                >
                                    Editar
                                </a>

                                <form
                                    action="eliminar.php"
                                    method="POST"
                                    class="admin-form-eliminar"
                                    onsubmit="return confirm('¿Eliminar este videojuego definitivamente?');"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int) $juego["id"] ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars(
                                            $_SESSION["csrf_token"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="accion-eliminar"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </div>
                        </td>
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

    <p class="admin-total">
        Total: <?= $totalJuegos ?> videojuegos
    </p>

</main>

<?php
mysqli_free_result($resultado);
mysqli_close($conexion);

require __DIR__ . "/../includes/footer.php";
?>
