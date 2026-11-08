
<?php
session_start();

require __DIR__ . "/../includes/conexion.php";

$ruta = "../";
$pagina = "admin";

// Recuperamos los juegos de la base de datos
$sql = "SELECT id, nombre, genero, anio, rating
        FROM juegos ORDER BY id DESC";

$resultado = mysqli_query($conexion, $sql);
$totalJuegos = mysqli_num_rows($resultado);

// Recuperamos el mensaje de confirmacion
$mensaje = $_SESSION["flash"] ?? "";
unset($_SESSION["flash"]);

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

    <div class="admin-tabla-contenedor">

        <table class="admin-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Videojuego</th>
                    <th>Genero</th>
                    <th>Año</th>
                    <th>Rating</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($juego = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= (int) $juego["id"] ?></td>

                        <td>
                            <?= htmlspecialchars($juego["nombre"], ENT_QUOTES, "UTF-8") ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($juego["genero"], ENT_QUOTES, "UTF-8") ?>
                        </td>

                        <td><?= (int) $juego["anio"] ?></td>

                        <td>
                            ★ <?= htmlspecialchars((string) $juego["rating"]) ?>
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
