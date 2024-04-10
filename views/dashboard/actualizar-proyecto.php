<?php include_once __DIR__ . '/header-dashboard.php';?>


<div class="contenedor-sm">
    <p class="descripcion-pagina">Nombra tu nuevo proyecto</p>
    <?php include_once __DIR__ . '/../templates/alertas.php';?>
        <form class="formulario" method="POST">

        <?php require_once __DIR__ . '/formulario-proyecto.php';?>

            <input type="submit" class="boton" value="Actualizar Proyecto">
        </form>

    </div> <!-- contenedor-sm -->

<?php include_once __DIR__ . '/footer-dashboard.php';?>