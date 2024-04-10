<aside class="sidebar">
    <div class="contenedor-sidebar">
        <a href="/dashboard" class="logoHome">
            <h1 class="uptask <?php if(isset($_SESSION)) {echo "resize" ?? '';} ?>">✔UpTask</h1>
        </a>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Proyectos') ? 'activo' : '';?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear Proyecto') ? 'activo' : '';?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : '';?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <p>Hola: <span><?php echo $_SESSION['nombre'];?></span></p>
        <a href="/logout" class="cerrar-session">Cerrar Sesión</a>
    </div>
</aside>