
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

    <form action="<?= $ruta ?>cambiar-tema.php"
          method="POST"
          class="form-tema">

        <input
            type="hidden"
            name="volver"
            value="<?= htmlspecialchars($volver, ENT_QUOTES, 'UTF-8') ?>"
        >

        <button type="submit" class="boton-tema">
            <?= $tema === "oscuro"
                ? "☀ Modo claro"
                : "☾ Modo oscuro" ?>
        </button>

    </form>

</nav>
