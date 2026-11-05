
<?php
require __DIR__ . "/includes/conexion.php";

// Recuperamos los videojuegos de MySQL
$sql = "SELECT id, nombre, genero, anio, rating,
               descripcion, imagen
        FROM juegos
        ORDER BY nombre ASC";

$resultado = mysqli_query($conexion, $sql);
$totalJuegos = mysqli_num_rows($resultado);

require __DIR__ . "/includes/header.php";
?>

<main class="contenedor">

    <section class="hero">
        <div class="hero-contenido">
            <span class="etiqueta">
                TU BIBLIOTECA DE VIDEOJUEGOS
            </span>

            <h1>
                Grandes juegos.<br>
                <span>Grandes historias.</span>
            </h1>

            <p>
                Descubri los mejores videojuegos AAA para PC.
                Explora nuestro catalogo, compara titulos
                y encontra tu proxima aventura.
            </p>

            <a href="#catalogo" class="boton-principal">
                Explorar catalogo
            </a>
        </div>

        <div class="hero-imagen">
            <img
                src="https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/library_600x900.jpg"
                alt="Portada de Cyberpunk 2077"
            >
        </div>
    </section>

    <section id="catalogo" class="seccion-catalogo">

        <div class="seccion-encabezado">
            <div>
                <span class="etiqueta">SELECCION PC VAULT</span>
                <h2>Explora nuestros juegos</h2>
            </div>

            <span class="contador">
                <?= $totalJuegos ?> juegos disponibles
            </span>
        </div>

        <div class="grilla-juegos">

            <?php while ($juego = mysqli_fetch_assoc($resultado)): ?>

                <article class="tarjeta-juego">

                    <div class="tarjeta-imagen">

                        <?php
                        $rutaImagen = $juego["imagen"];
                        $imagenExiste = is_file(
                            __DIR__ . "/" . $rutaImagen
                        );
                        ?>

                        <?php if ($imagenExiste): ?>
                            <img
                                src="<?= htmlspecialchars($rutaImagen) ?>"
                                alt="Portada de <?= htmlspecialchars($juego['nombre']) ?>"
                                loading="lazy"
                            >
                        <?php else: ?>
                            <div class="portada-pendiente">
                                <span>PC VAULT</span>
                                <strong>
                                    <?= htmlspecialchars($juego['nombre']) ?>
                                </strong>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="tarjeta-info">

                        <span class="juego-genero">
                            <?= htmlspecialchars($juego['genero']) ?>
                        </span>

                        <h3>
                            <?= htmlspecialchars($juego['nombre']) ?>
                        </h3>

                        <div class="tarjeta-detalles">
                            <span><?= (int) $juego['anio'] ?></span>

                            <span class="juego-rating">
                                ★ <?= htmlspecialchars((string) $juego['rating']) ?>
                            </span>
                        </div>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>

    </section>

</main>

<?php
mysqli_free_result($resultado);
mysqli_close($conexion);

require __DIR__ . "/includes/footer.php";
?>
