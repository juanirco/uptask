<div class="barra-mobile">
    <a href="/dashboard" class="logoHome">
        <h1 class="uptask <?php if(isset($_SESSION)) {echo "resize" ?? '';} ?>">✔UpTask</h1>
    </a>

    <div class="menu">
        <img src="build/img/menu.svg" id="mobile-menu" alt="imagen menu">
    </div>
    
</div>

<div class="barra">
    <p>Hola: <span><?php echo $_SESSION['nombre'];?></span></p>
    <a href="/logout" class="cerrar-session">Cerrar Sesión</a>
</div>