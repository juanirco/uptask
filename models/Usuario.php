<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;
    
    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarCuenta() : array {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        } // El [] luego de ['error'] es para indicar que debe agregarse al final del arreglo
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 8 ) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
         // Verificar al menos una minúscula, una mayúscula y un caracter especial
        if (!preg_match('/[a-z]/', $this->password) || !preg_match('/[A-Z]/', $this->password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $this->password)) {
            self::$alertas['error'][] = 'El password debe contener mínimo una mayúscula, una minúscula y un caracter especial';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Ambos passwords deben coincidir';
        }
        return self::$alertas;
    }

    public function validarPassword() : array {
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 8 ) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
         // Verificar al menos una minúscula, una mayúscula y un caracter especial
        if (!preg_match('/[a-z]/', $this->password) || !preg_match('/[A-Z]/', $this->password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $this->password)) {
            self::$alertas['error'][] = 'El password debe contener mínimo una mayúscula, una minúscula y un caracter especial';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Ambos passwords deben coincidir';
        }
        return self::$alertas;
    }

    public function validarLogin() : array {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail() : array {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El formato del email no es válido';
        }
        return self::$alertas;
    }

    public function validarPerfil() : array {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 8 ) {
            self::$alertas['error'][] = 'El password nuevo debe contener al menos 8 caracteres';
        }
         // Verificar al menos una minúscula, una mayúscula y un caracter especial
        if (!preg_match('/[a-z]/', $this->password_nuevo) || !preg_match('/[A-Z]/', $this->password_nuevo) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $this->password_nuevo)) {
            self::$alertas['error'][] = 'El password debe contener mínimo una mayúscula, una minúscula y un caracter especial';
        }
        return self::$alertas;
    }

    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }

    public function passwordHash() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function sendToken() : void  {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) : bool {
        $resultado = password_verify($_POST['password'], $this->password);

        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Usuario o password incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}