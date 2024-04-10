<?php include_once __DIR__ . '/header-dashboard.php';?>


<div class="contenedor-sm">
    <p class="descripcion-pagina">Nombra tu nuevo proyecto</p>
    <?php include_once __DIR__ . '/../templates/alertas.php';?>
        <form action="/crear-proyecto" class="formulario" method="POST">

        <?php require_once __DIR__ . '/formulario-proyecto.php';?>

            <input type="submit" class="boton" value="Crear Proyecto">
        </form>

    </div> <!-- contenedor-sm -->

<?php include_once __DIR__ . '/footer-dashboard.php';?>