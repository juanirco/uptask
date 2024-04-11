<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        avoidDoubleLogin();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            if(empty($alertas)) {
                // Verificar quel el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if(!$usuario || !$usuario->confirmado ) {
                    Usuario::setAlerta('error', 'El Usuario No Existe o no esta confirmado');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $usuario->password) ) {
                        
                        // Iniciar la sesión 
                        isSession();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }
        if (isset($_GET['p_u']) && $_GET['p_u'] === 'true') { // la 1era ayuda a que si se accede a la url desde cualquier otra forma no salga el error de que no se ha definido el array key 'p_u'
            Usuario::setAlerta('exito', 'Se ha actualizado tu contraseña correctamente.');
        }
        $alertas = Usuario::getAlertas();
        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router) {
        isSession();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear(Router $router) {
        varSession();
        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCuenta();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if(!empty($existeUsuario)) {
                    Usuario::setAlerta('error', 'Este usuario ya existe');
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->passwordHash();
                    // Eliminar password2 porque no lo necesitamos
                    unset($usuario->password2);

                    $usuario->sendToken();

                    // Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->sendConfirmation();

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }

            }
        } 

        $router->render('/auth/crear', [
            'titulo' => 'Crear tu cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        varSession();
        $alertas = [];
        $mostrar = true;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario && $usuario->confirmado === "1") {
                    // Generar un token único
                    $usuario->sendToken();
                    unset($usuario->password2);
                    $usuario->guardar();
                    // Enviar el Email                    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->sendInstructions();
                    $mostrar = false;
                    
                    Usuario::setAlerta('exito', 'Revisa tu email');
                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no está confirmado');
                }
                
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('/auth/olvide', [
            'titulo' => 'Olvide',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function reestablecer(Router $router) {
        varSession();
        $alertas = [];
        $token = s($_GET['token']);
        $mostrar = true;
        $resultado = '';
        if(!$token) header('Location: /');

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {

            Usuario::setAlerta('error', 'Token no válido');
            $mostrar = false;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->passwordHash();
                $usuario->token = null;
                $resultado = $usuario->guardar();

            } if ($resultado) {
                header('Location: /?p_u=true');
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router) {
        varSession();

        $router->render('/auth/mensaje', [
            'titulo' => 'Mensaje'
        ]);
    }

    public static function confirmar(Router $router) {
        varSession();
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada');
        }

        $alertas = Usuario::getAlertas();

        $router->render('/auth/confirmar', [
            'titulo' => 'Confirmar',
            'alertas' => $alertas
        ]);
    }
}