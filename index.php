
<?php
require __DIR__ . "/includes/conexion.php";

// Recuperamos los filtros enviados por GET
$busqueda = isset($_GET["buscar"]) && is_string($_GET["buscar"])
    ? trim($_GET["buscar"]) : "";

$genero = isset($_GET["genero"]) && is_string($_GET["genero"])
    ? trim($_GET["genero"]) : "";

$orden = isset($_GET["orden"]) && is_string($_GET["orden"])
    ? $_GET["orden"] : "nombre_asc";

// Recuperamos los generos disponibles
$generos = [];
$sqlGeneros = "SELECT DISTINCT genero FROM juegos ORDER BY genero ASC";
$resultadoGeneros = mysqli_query($conexion, $sqlGeneros);

while ($fila = mysqli_fetch_assoc($resultadoGeneros)) {
    $generos[] = $fila["genero"];
}

mysqli_free_result($resultadoGeneros);

// Validamos el genero recibido
if ($genero !== "" && !in_array($genero, $generos, true)) {
    $genero = "";
}

// Solo permitimos ordenamientos definidos
$ordenes = [
    "nombre_asc" => "nombre ASC",
    "nombre_desc" => "nombre DESC",
    "anio_desc" => "anio DESC, nombre ASC",
    "anio_asc" => "anio ASC, nombre ASC",
    "rating_desc" => "rating DESC, nombre ASC",
    "rating_asc" => "rating ASC, nombre ASC"
];

if (!array_key_exists($orden, $ordenes)) {
    $orden = "nombre_asc";
}

$ordenSQL = $ordenes[$orden];
$patronBusqueda = "%" . $busqueda . "%";

// Consulta preparada para evitar inyecciones SQL
$sql = "SELECT id, nombre, genero, anio, rating,
               descripcion, imagen
        FROM juegos
        WHERE (? = '' OR nombre LIKE ?)
          AND (? = '' OR genero = ?)
        ORDER BY $ordenSQL";

$stmt = mysqli_prepare($conexion, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $busqueda,
    $patronBusqueda,
    $genero,
    $genero
);

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
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
            <img src="img/juegos/cyberpunk2077.jpg"
                 alt="Portada de Cyberpunk 2077">
        </div>
    </section>

    <section id="catalogo" class="seccion-catalogo">

        <div class="seccion-encabezado">
            <div>
                <span class="etiqueta">SELECCION PC VAULT</span>
                <h2>Explora nuestros juegos</h2>
            </div>

            <span class="contador">
                <?= $totalJuegos ?> juegos encontrados
            </span>
        </div>

        <!-- Busqueda, filtros y ordenamiento -->
        <form action="index.php#catalogo"
              method="GET"
              class="barra-filtros">

            <div class="campo-filtro campo-busqueda">
                <label for="buscar">Buscar por titulo</label>

                <input
                    type="search"
                    id="buscar"
                    name="buscar"
                    placeholder="Ej: Cyberpunk, GTA..."
                    maxlength="100"
                    value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="campo-filtro">
                <label for="genero">Genero</label>

                <select id="genero" name="genero">
                    <option value="">Todos los generos</option>

                    <?php foreach ($generos as $opcionGenero): ?>
                        <option
                            value="<?= htmlspecialchars($opcionGenero, ENT_QUOTES, 'UTF-8') ?>"
                            <?= $genero === $opcionGenero ? "selected" : "" ?>
                        >
                            <?= htmlspecialchars($opcionGenero) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo-filtro">
                <label for="orden">Ordenar por</label>

                <select id="orden" name="orden">
                    <option value="nombre_asc"
                        <?= $orden === "nombre_asc" ? "selected" : "" ?>>
                        Nombre A-Z
                    </option>

                    <option value="nombre_desc"
                        <?= $orden === "nombre_desc" ? "selected" : "" ?>>
                        Nombre Z-A
                    </option>

                    <option value="anio_desc"
                        <?= $orden === "anio_desc" ? "selected" : "" ?>>
                        Mas recientes
                    </option>

                    <option value="anio_asc"
                        <?= $orden === "anio_asc" ? "selected" : "" ?>>
                        Mas antiguos
                    </option>

                    <option value="rating_desc"
                        <?= $orden === "rating_desc" ? "selected" : "" ?>>
                        Mejor puntuados
                    </option>

                    <option value="rating_asc"
                        <?= $orden === "rating_asc" ? "selected" : "" ?>>
                        Menor puntuacion
                    </option>
                </select>
            </div>

            <button type="submit" class="boton-filtrar">
                Aplicar
            </button>

            <a href="index.php#catalogo" class="boton-limpiar">
                Limpiar
            </a>
        </form>

        <!-- Resultados del catalogo -->
        <?php if ($totalJuegos === 0): ?>

            <p class="sin-resultados">
                No se encontraron videojuegos con esos filtros.
            </p>

        <?php else: ?>

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
                                    src="<?= htmlspecialchars($rutaImagen, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Portada de <?= htmlspecialchars($juego['nombre'], ENT_QUOTES, 'UTF-8') ?>"
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

        <?php endif; ?>

    </section>

</main>

<?php
mysqli_free_result($resultado);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

require __DIR__ . "/includes/footer.php";
?>
