<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;


class TareaController {

    public static function index() {
        isSession();
        isAuth();

        // no se requiere el router porque el router hacer el renderizado a las vistas y al ser una API no requerimos vistas
        $proyectoId = $_GET['id'];

        if(!$proyectoId) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $proyectoId);

        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }


    public static function crear() {
        isSession();
        isAuth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;

            } 
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea agregada correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }

    }

    public static function actualizar() {
        isSession();
        isAuth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            if($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado correctamente'
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }

    public static function eliminar() {
        isSession();
        isAuth();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();
            $resultado = [
                'tipo' => 'exito',
                'resultado' => $resultado,
                'mensaje' => 'Eliminado correctamente'
            ];
            echo json_encode($resultado);
        }

    }
}