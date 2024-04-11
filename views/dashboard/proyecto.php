<?php include_once __DIR__ . '/header-dashboard.php';?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button 
        type="button" 
        class="agregar-tarea" 
        id="agregar-tarea"
        >&#43; Nueva Tarea
        </button>
    </div>
    <div id="filtros" class="filtros">
        <div class="filtros-inputs">
            <h2>Filtro:</h2>
            <div class="campo">
                <label for="todas">Todas</label>
                <input
                    type="radio"
                    id="todas"
                    name="filtro"
                    value=""
                    checked
                />
            </div>

            <div class="campo">
                <label for="pendiente">Pendientes</label>
                <input
                    type="radio"
                    id="pendiente"
                    name="filtro"
                    value="Pendiente"
                />
            </div>

            <div class="campo">
                <label for="enProceso">En Proceso</label>
                <input
                    type="radio"
                    id="enProceso"
                    name="filtro"
                    value="En proceso"
                />
            </div>
            
            <div class="campo">
                <label for="completadas">Completadas</label>
                <input
                    type="radio"
                    id="completadas"
                    name="filtro"
                    value="Completada"
                />
            </div>

        </div>
    </div>
    <ul id="listado-tareas" class="listado-tareas"></ul>

    <div class="accionesProyecto">
        <a class="editarProyecto" href="/actualizar-proyecto?id=<?php echo $proyecto->id; ?>">Editar Proyecto</a>
        <form action="/eliminar-proyecto" method="POST">
            <input type="hidden" name="idProyecto" value="<?php echo $proyecto->id; ?>">
            <button type="button" class="eliminarProyecto" onclick="confirmarEliminarProyecto()">Eliminar Proyecto</button>

        </form>
    </div>

</div>
<?php include_once __DIR__ . '/footer-dashboard.php';?>

<?php 
    $script .= '
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/build/js/tareas.js"></script>
    '; // el primero va darnos acceso en consola a un objeto llamado Swal, puedes ir a consola y escribir swal y si se puede ver algo quiere decir que se instaló correctamente.
?>