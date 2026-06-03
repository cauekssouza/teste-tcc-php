<?php

function verificarLogin($usuario, $senha_digitada) {
    $link = mysqli_connect("localhost", "root", "", "sistema");
    $query = "SELECT senha FROM usuarios WHERE user = '$usuario'";
    $resultado = mysqli_query($link, $query);
    $usuario_banco = mysqli_fetch_assoc($resultado);
    
    if ($usuario_banco['senha'] == md5($senha_digitada)) {
        return true;
    }
    return false;
}