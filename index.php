
<?php
$juegosDemo = [
    [
        "nombre" => "Cyberpunk 2077",
        "genero" => "RPG",
        "anio" => 2020,
        "rating" => 9.2,
        "imagen" => "https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/library_600x900.jpg"
    ],
    [
        "nombre" => "Red Dead Redemption 2",
        "genero" => "Accion",
        "anio" => 2018,
        "rating" => 9.8,
        "imagen" => "https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1174180/library_600x900.jpg"
    ],
    [
        "nombre" => "Elden Ring",
        "genero" => "RPG",
        "anio" => 2022,
        "rating" => 9.6,
        "imagen" => "https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/library_600x900.jpg"
    ],
    [
        "nombre" => "Baldur's Gate 3",
        "genero" => "RPG",
        "anio" => 2023,
        "rating" => 9.7,
        "imagen" => "https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1086940/library_600x900.jpg"
    ]
];

require __DIR__ . "/includes/header.php";
?>

<main class="contenedor">

    <section class="hero">
        <div class="hero-contenido">
            <span class="etiqueta">TU BIBLIOTECA DE VIDEOJUEGOS</span>

            <h1>Grandes juegos.<br>
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
                <?= count($juegosDemo) ?> juegos disponibles
            </span>
        </div>

        <div class="grilla-juegos">

            <?php foreach ($juegosDemo as $juego): ?>
                <article class="tarjeta-juego">

                    <div class="tarjeta-imagen">
                        <img
                            src="<?= htmlspecialchars($juego['imagen']) ?>"
                            alt="Portada de <?= htmlspecialchars($juego['nombre']) ?>"
                            loading="lazy"
                        >
                    </div>

                    <div class="tarjeta-info">
                        <span class="juego-genero">
                            <?= htmlspecialchars($juego['genero']) ?>
                        </span>

                        <h3><?= htmlspecialchars($juego['nombre']) ?></h3>

                        <div class="tarjeta-detalles">
                            <span><?= (int) $juego['anio'] ?></span>

                            <span class="juego-rating">
                                ★ <?= htmlspecialchars((string) $juego['rating']) ?>
                            </span>
                        </div>
                    </div>

                </article>
            <?php endforeach; ?>

        </div>

    </section>

</main>

<?php
require __DIR__ . "/includes/footer.php";
?>
