<?php

namespace Controllers;

use MVC\Router;
use Model\Tarea;
use Model\Usuario;
use Model\Proyecto;

class DashboardController {
    public static function index(Router $router) {
        isSession();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }


    public static function crear_proyecto(Router $router) {
        isSession();
        isAuth();

        $proyecto = new Proyecto();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto->sincronizar($_POST);
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                $resultado = $proyecto->existeProyecto();

                if ($resultado->num_rows) {
                    $alertas = Proyecto::getAlertas();
                } else {

                    $hash = md5(uniqid());
                    $proyecto->url = $hash;
                    $proyecto->propietarioId = $_SESSION['id'];
                    $proyecto->guardar();
                    header('Location: /proyecto?id='.$proyecto->url);
                }
            }
        }
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas,
            'proyecto' => $proyecto
        ]);
    }

    public static function proyecto(Router $router) {
        isSession();
        isAuth();

        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
            'proyecto' => $proyecto
        ]);
    }

    public static function actualizar_proyecto(Router $router) {
        isSession();
        isAuth();
        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('id', $token);
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                Proyecto::setAlerta('error', 'No se puede completar la acción');
                $alertas = $proyecto->getAlertas();
            } else{
                $proyecto->sincronizar($_POST);
                $alertas = $proyecto->validarProyecto();
    
                if (empty($alertas)) {
                    $resultado = $proyecto->existeProyecto();
    
                    if ($resultado->num_rows) {
                        $alertas = Proyecto::getAlertas();
                    } else {
                        $proyecto->guardar();
                        header('Location: /proyecto?id='.$proyecto->url);
                    }
                }
            }

        }
        // debug($_SESSION);
        $router->render('dashboard/actualizar-proyecto', [
            'titulo' => 'Actualizar Proyecto',
            'alertas' => $alertas,
            'proyecto' => $proyecto
        ]);
    }

    public static function eliminar_proyecto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            isSession();
            isAuth();
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $proyecto = Proyecto::find($id);
            if (!$proyecto) {
                // Proyecto no encontrado
                // Puedes retornar un mensaje de error JSON o redirigir a alguna página de error
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'El proyecto no fue encontrado']);
                exit;
            }
    
            // Aquí podrías incluir lógica adicional, como verificar si el usuario tiene permisos para eliminar el proyecto, etc.
    
            $tarea = new Tarea($_POST);
            $tarea->eliminarAll();
            $proyecto->eliminar();
            
            // Envía una respuesta JSON indicando que el proyecto ha sido eliminado correctamente
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'El proyecto ha sido eliminado correctamente']);
            exit;

        }
    }
    

    public static function perfil(Router $router) {
        isSession();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id ) {
                    // Mensaje de error
                    Usuario::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    // Guardar el registro
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }
        
        
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function cambiar_password(Router $router) {
        isSession();
        isAuth();
        $alertas = [];

        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = Usuario::find($_SESSION['id']);


            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {
                    // Asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;

                    // Eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    // Hashear el nuevo password
                    $usuario->passwordHash();
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito', 'Password Actualizado');
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }  
            } 
        }
        
        
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }
}