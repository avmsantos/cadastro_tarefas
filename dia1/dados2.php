<?php
session_start();

require_once "conexao.php";
require_once "helper/date_functions.php";

$conexao = novaConexao();

$nomedatarefa = $_POST['nomedatarefa'];
$descricao = $_POST['descricao'];
$inicio = converterDataEmFormatoDB($_POST['inicio']);
$fim = converterDataEmFormatoDB($_POST['fim']);
$usuario = $_POST['usuario'];

if ($_POST['id'] == "") {
    $sql = "INSERT INTO tarefas
    ( nomedatarefa, descricao, inicio, fim, id_usuario_fk)
    VALUES (
        '$nomedatarefa',
        '$descricao',
        '$inicio',
        '$fim',
        '$usuario'
    )";
    $resultado = $conexao->query($sql);

    if ($resultado) {
        echo "Sucesso :)";
    } else {
        echo "Erro: " . $conexao->error;
    }

} else {

    $sql = "UPDATE tarefas set nomedatarefa = ?, descricao = ?, inicio = ?, fim = ?, id_usuario_fk = ?  WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ssssii', $nomedatarefa, $descricao, $inicio, $fim, $_POST['usuario'], $_POST['id']);
    $stmt->execute();

    //var_dump(get_class_methods($smtp));

    if ($stmt->affected_rows > 0) {
        echo "Sucesso :)";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
}

$conexao->close();
header("location: cadastro_tarefas.php");
