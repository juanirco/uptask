<?php include_once __DIR__ . '/header-dashboard.php';?>

<div class="contenedor-sm">
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<a href="/perfil" class="enlace">Volver a Perfil</a>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo">
            <label for="password_actual">Password Actual</label>
            <input 
                type="password" 
                name="password_actual" 
                id="password_actual" 
                placeholder="Tu password actual"
                >
        </div>
        <div class="campo">
            <label for="password_nuevo">Password nuevo</label>
            <input 
                type="password" 
                name="password_nuevo" 
                id="password_nuevo" 
                placeholder="Tu password nuevo"
                >
        </div>

        <input type="submit" value="Guardar Cambios" class="boton">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php';?>