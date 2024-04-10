<div class="contenedor olvide">
    <?php 
        include_once __DIR__ . '/../templates/nombre-sitio.php';
        include_once __DIR__ . '/../templates/alertas.php';
    ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso</p>
        <?php if($mostrar) { ?>
        <form action="/olvide" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email">
            </div>

            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <?php } ?>

        <div class="acciones">
            <a href="/">¿Recordaste tu Password? Inicia sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? Registrate acá</a>
        </div>
    </div> <!-- contenedor-sm -->
</div> <!-- contenedor -->