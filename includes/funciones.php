<?php

function depurar($variable) : string {
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

// función para saber si está autorizado
function isAuth() : void {
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}