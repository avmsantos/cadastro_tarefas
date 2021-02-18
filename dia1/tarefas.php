<?php

include 'path/cabecalho.php';

require_once "conexao.php";

require_once "helper/date_functions.php";


$registros = [];
$conexao = novaConexao();

$data = [];
$registrosUsuarios = [];
$erro = null;
$idUsuarioLogado = $_SESSION['id_usuario'];

//$sql = "SELECT * FROM tarefas";
$sql = "select tarefas.*, usuario.nome from tarefas left join usuario on id_usuario_fk = usuario.id where id_usuario_fk = $idUsuarioLogado";


$resultado = $conexao->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $registros[] = $row;
    }
} elseif ($conexao->error) {
    echo "Erro: " . $conexao->error;
}

if (isset($_GET['status'])) {
    $sql = "UPDATE tarefas set status = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ii', $_GET['status'], $_GET['id']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $erro = null;
        header("location: tarefas.php");
    } else {
        $erro =  "Erro: " . mysqli_error($conexao);
    }
}

?>

<div class="container">

<?php if (!is_null($erro)) :?>
<div class="alert alert-danger" role="alert">
  <?php echo $erro ;?>
</div>
<?php endif ;?>
<div class="row">
<div class="col-md-12">
		<table class="table table-hover table-striped table-bordered">
    <thead>
	    <th>ID</th>
		<th>usuario</th>
        <th>Nome da tarefa</th>
		<th>Descricao</th>
		<th>Inicio</th>
		<th>Fim</th>
		<th>Ações</th>
    </thead>
    <tbody>
        <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?=$registro['id']?></td>
                <td><?=$registro['nome']?></td>
				<td><?=$registro['nomedatarefa']?></td>
				<td><?=$registro['descricao']?></td>
				<td><?=converterDataEmFormatoBR($registro['inicio'])?></td>
				<td><?=converterDataEmFormatoBR($registro['fim'])?></td>

                <td>
                <a href="?id=<?= $registro['id'] ?>&status=<?php echo ($registro['status'] == 0) ? 1 : 0  ;?>" 
                        class="btn btn-success">
                        <?php if($registro['status'] == 0) :?>
                            <i class="fas fa-square"></i>
                        <?php else: ?>
                            <i class="far fa-check-square"></i>
                        <?php endif; ?>
					</a>
                </td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>
</div>
    </div>
</div>

<?php
include 'path/footer.php';
?>