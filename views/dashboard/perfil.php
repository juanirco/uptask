<?php include_once __DIR__ . '/header-dashboard.php';?>


<div class="contenedor-sm">

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                placeholder="Tu nombre"
                value="<?php echo $usuario->nombre; ?>"
                >
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                placeholder="Tu nuevo email"
                value="<?php echo $usuario->email; ?>"
                >
        </div>

        <a href="/cambiar-password" class="enlace derecha">>> Cambiar Password <<</a>

        <input type="submit" value="Guardar Cambios" class="boton">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php';?>