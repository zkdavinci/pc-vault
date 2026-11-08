
<?php
session_start();

require __DIR__ . "/../includes/conexion.php";

$ruta = "../";
$pagina = "admin";
$errores = [];

// Valores del formulario
$datos = [
    "nombre" => "",
    "genero" => "",
    "anio" => "",
    "rating" => "",
    "descripcion" => "",
    "imagen" => ""
];

// Generos disponibles en la base de datos
$generos = [];
$resultadoGeneros = mysqli_query(
    $conexion,
    "SELECT DISTINCT genero FROM juegos ORDER BY genero ASC"
);

while ($fila = mysqli_fetch_assoc($resultadoGeneros)) {
    $generos[] = $fila["genero"];
}

mysqli_free_result($resultadoGeneros);

// Token de seguridad del formulario
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    foreach ($datos as $campo => $valor) {
        $entrada = $_POST[$campo] ?? "";
        $datos[$campo] = is_string($entrada)
            ? trim($entrada)
            : "";
    }

    $token = $_POST["csrf_token"] ?? "";

    if (
        !is_string($token) ||
        !hash_equals($_SESSION["csrf_token"], $token)
    ) {
        $errores[] = "Solicitud no valida.";
    }

    // Validacion de campos obligatorios
    if (
        $datos["nombre"] === "" ||
        $datos["genero"] === "" ||
        $datos["anio"] === "" ||
        $datos["rating"] === "" ||
        $datos["descripcion"] === ""
    ) {
        $errores[] = "Completa todos los campos obligatorios.";
    }

    if (strlen($datos["nombre"]) > 150) {
        $errores[] = "El nombre es demasiado largo.";
    }

    if (!in_array($datos["genero"], $generos, true)) {
        $errores[] = "Selecciona un genero valido.";
    }

    $anio = filter_var(
        $datos["anio"],
        FILTER_VALIDATE_INT,
        [
            "options" => [
                "min_range" => 1980,
                "max_range" => (int) date("Y")
            ]
        ]
    );

    if ($anio === false) {
        $errores[] = "Ingresa un año valido.";
    }

    $rating = filter_var(
        str_replace(",", ".", $datos["rating"]),
        FILTER_VALIDATE_FLOAT
    );

    if ($rating === false || $rating < 0 || $rating > 10) {
        $errores[] = "El rating debe estar entre 0 y 10.";
    }

    // Solo permitimos rutas de imagenes locales
    if (
        $datos["imagen"] !== "" &&
        !preg_match(
            '#^img/juegos/[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)$#i',
            $datos["imagen"]
        )
    ) {
        $errores[] = "La ruta de la imagen no es valida.";
    }

    // Guardamos el videojuego
    if (empty($errores)) {

        $nombre = $datos["nombre"];
        $genero = $datos["genero"];
        $descripcion = $datos["descripcion"];
        $imagen = $datos["imagen"];
        $rating = round($rating, 1);

        $sql = "INSERT INTO juegos
                (nombre, genero, anio, rating, descripcion, imagen)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexion, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssidss",
            $nombre,
            $genero,
            $anio,
            $rating,
            $descripcion,
            $imagen
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION["flash"] = "El videojuego se agrego correctamente.";

        mysqli_close($conexion);

        header("Location: index.php");
        exit;
    }
}

require __DIR__ . "/../includes/header.php";
?>

<main class="contenedor admin-seccion">

    <div class="admin-encabezado">
        <div>
            <span class="etiqueta">ADMINISTRACION</span>
            <h1>Agregar videojuego</h1>
            <p>Completa los datos del nuevo titulo.</p>
        </div>

        <a href="index.php" class="boton-limpiar">
            Volver
        </a>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="admin-errores">
            <?php foreach ($errores as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="admin-formulario">

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>"
        >

        <div class="campo-admin">
            <label for="nombre">Nombre del videojuego *</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="150"
                required
                value="<?= htmlspecialchars($datos["nombre"], ENT_QUOTES, "UTF-8") ?>"
            >
        </div>

        <div class="admin-fila">

            <div class="campo-admin">
                <label for="genero">Genero *</label>

                <select id="genero" name="genero" required>
                    <option value="">Seleccionar genero</option>

                    <?php foreach ($generos as $opcion): ?>
                        <option
                            value="<?= htmlspecialchars($opcion, ENT_QUOTES, "UTF-8") ?>"
                            <?= $datos["genero"] === $opcion ? "selected" : "" ?>
                        >
                            <?= htmlspecialchars($opcion) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo-admin">
                <label for="anio">Año *</label>
                <input
                    type="number"
                    id="anio"
                    name="anio"
                    min="1980"
                    max="<?= date("Y") ?>"
                    required
                    value="<?= htmlspecialchars($datos["anio"]) ?>"
                >
            </div>

            <div class="campo-admin">
                <label for="rating">Rating (0-10) *</label>
                <input
                    type="number"
                    id="rating"
                    name="rating"
                    min="0"
                    max="10"
                    step="0.1"
                    required
                    value="<?= htmlspecialchars($datos["rating"]) ?>"
                >
            </div>

        </div>

        <div class="campo-admin">
            <label for="descripcion">Descripcion *</label>
            <textarea
                id="descripcion"
                name="descripcion"
                rows="5"
                required
            ><?= htmlspecialchars($datos["descripcion"], ENT_QUOTES, "UTF-8") ?></textarea>
        </div>

        <div class="campo-admin">
            <label for="imagen">Ruta de la imagen (opcional)</label>

            <input
                type="text"
                id="imagen"
                name="imagen"
                placeholder="img/juegos/ejemplo.jpg"
                value="<?= htmlspecialchars($datos["imagen"], ENT_QUOTES, "UTF-8") ?>"
            >

            <small>
                Si no tienes una portada, deja el campo vacio.
            </small>
        </div>

        <button type="submit" class="boton-principal admin-guardar">
            Guardar videojuego
        </button>

    </form>

</main>

<?php
mysqli_close($conexion);
require __DIR__ . "/../includes/footer.php";
?>
