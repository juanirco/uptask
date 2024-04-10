<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
        exit;
    }
}

function isSession() : void {
    if(!isset($_SESSION)) {
        session_start();
    }
}

function varSession() :void {
    if(!isset($_SESSION)) {
        $_SESSION = [];
    }
}

function avoidDoubleLogin() : void {
    session_start();
    if(isset($_SESSION['login'])) {
        header('Location: /dashboard');
        exit; // Es importante salir del script después de redirigir
    }
}