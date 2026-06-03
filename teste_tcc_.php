<?php

function verificarLogin(string $usuario, string $senha_digitada): bool
{
    // Sanitização defensiva da variável de sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Regenera ID da sessão para evitar fixation
    session_regenerate_id(true);

    // Sanitização do nome de usuário (mínimo necessário)
    $usuario = filter_var($usuario, FILTER_SANITIZE_STRING);

    // Conexão usando mysqli com prepared statements
    $link = mysqli_connect("localhost", "root", "", "sistema");

    if (!$link) {
        // Nunca exponha erros internos ao usuário
        error_log("Erro de conexão ao banco.");
        return false;
    }

    $query = "SELECT senha FROM usuarios WHERE user = ?";
    $stmt = mysqli_prepare($link, $query);

    if (!$stmt) {
        error_log("Erro ao preparar statement.");
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $senha_hash_banco);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}