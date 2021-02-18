<?php
session_start();

require_once __DIR__ . "/vendor/autoload.php";

use App\Validacoes\Usuarios;
use App\Config\BancoDeDados;
use App\Repositorio\UsuarioRepositorio;


//use Symfony\Component\Validator\Constraints\Length;

$bancoDeDados = new BancoDeDados();
$conexao = $bancoDeDados->conexao();

$campos = [
    'nome' => $_POST['nome'],
    'email' => $_POST['email'],
    'senha' => $_POST['senha']
];

$usuarios = new Usuarios($campos);

$erros = $usuarios->valid();

if (count($erros) > 0) {
    foreach ($erros as $value) {
        echo $value . "<br>";
    }

    exit;
}

if ($_POST['id'] == null ) {
    
    $usuarioRepositorio = new UsuarioRepositorio($conexao);
    if ($usuarioRepositorio->validarEmailExiste($campos['email'])){
        echo "Já existe usuario cadastrado com esse email";
        die;
    }


    $resultado = $usuarioRepositorio->salvar($campos);

    if($resultado) {
        echo "Sucesso :)";
    } else {
        echo "Erro: " . $conexao->error;
        die;
    }


} else {
    $usuarioRepositorio = new UsuarioRepositorio($conexao);

    $resultado = $usuarioRepositorio->update($_POST['id'], $campos);

    if($resultado) {
        echo "Sucesso :)";
    } else {
        echo "Erro: " . $conexao->error;
        die;
    }
}

$conexao->close();
header("location: cadastro.php");