<?php

function novaConexao($banco = "db_gt") {
$servidor = "127.0.0.1:3307";
$senha = "root";
$usuario = "root";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if(mysqli_connect_error()){
    echo "Erro na conexao " . mysqli_connect_error();
}

return $conexao;
}
