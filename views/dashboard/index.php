<?php include_once __DIR__ . '/header-dashboard.php';?>


<?php if (count($proyectos) === 0) {?>
    <p class="no-proyectos">No hay proyectos aún. Crea tu primer proyecto en el siguiente botón:</p>
    <a class="boton izquierda" href="/crear-proyecto">Nuevo Proyecto</a>
    <?php } else {?>
        <a class="boton izquierda" href="/crear-proyecto">Nuevo Proyecto</a>
        <ul class="listado-proyectos">
            <?php foreach($proyectos as $proyecto) {?>
                <li class="proyecto">
                    <a href="/proyecto?id=<?php echo $proyecto->url;?>">
                    <?php echo $proyecto->proyecto;?>
                    </a>
                </li>
                <?php } ?>
        </ul>
    <?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php';?>