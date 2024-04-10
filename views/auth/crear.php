<div class="contenedor crear">
    <?php 
    include_once __DIR__ . '/../templates/nombre-sitio.php';
    include_once __DIR__ . '/../templates/alertas.php';
    ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu nueva cuenta</p>

        <form action="/crear" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                type="text"
                id="nombre"
                placeholder="Tu nombre"
                name="nombre"
                value="<?php echo $usuario->nombre;?>"
                >
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                value="<?php echo $usuario->email;?>"
                >
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu password"
                name="password"
                >
            </div>

            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input 
                type="password"
                id="password2"
                placeholder="Repite tu password"
                name="password2"
                >
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">Ya tienes una cuenta? Inicia sesión</a>
            <a href="/olvide">¿Olvidaste tu password?</a>
        </div>
    </div> <!-- contenedor-sm -->
</div> <!-- contenedor -->