<div class="contenedor reestablecer">
<?php 
        include_once __DIR__ . '/../templates/nombre-sitio.php';
        include_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($mostrar) { ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Colococa tu nuevo password</p>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu password"
                name="password">
            </div>
            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input 
                type="password"
                id="password2"
                placeholder="Repite tu password"
                name="password2">
            </div>

            <input type="submit" class="boton" value="Nuevo Password">
        </form>
        <?php } ?>
    </div> <!-- contenedor-sm -->
</div> <!-- contenedor -->