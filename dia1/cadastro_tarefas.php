<?php
namespace App\config;

include 'path/cabecalho.php';

//require_once "conexao.php";

require_once "helper/date_functions.php";

$registros = [];
$conexao = novaConexao();

$data = [];
$registrosUsuarios = [];

$sql = "SELECT id, nome, email FROM usuario";
$resultado = $conexao->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $registrosUsuarios[] = $row;
    }
} elseif ($conexao->error) {
    echo "Erro: " . $conexao->error;
}

if (isset($_GET['excluir'])) {
    $excluirSQL = "DELETE FROM tarefas WHERE id = ?";
    $stmt = $conexao->prepare($excluirSQL);
    $stmt->bind_param("i", $_GET['excluir']);
    if ($stmt->execute()) {
        header("location:cadastro_tarefas.php");
    }
}

//$sql = "SELECT * FROM tarefas";
$sql = "select tarefas.*, usuario.nome from tarefas left join usuario on id_usuario_fk = usuario.id";

$resultado = $conexao->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $registros[] = $row;
    }
} elseif ($conexao->error) {
    echo "Erro: " . $conexao->error;
}

if (isset($_GET['editar'])) {
    $sql = "SELECT * FROM tarefas WHERE id = ?";
    $query = $conexao->prepare($sql);
    $query->bind_param("i", $_GET['editar']);
    $query->execute();

    $resultado = $query->get_result();
    $data = $resultado->fetch_array(MYSQLI_ASSOC);
}

//$conexao->close;

?>

<div class="container">
    <div class="row">
    	<div class="col-md-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Cadastro de tarefas</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form action="dados2.php" method="POST">

					<input name="id" value="<?php echo $_GET['editar'] ?? '' ?>" hidden />
                    <fieldset>
					Usuario:
                    <div class="form-group">
						<select class="form-control" name="usuario" id="usuario">
								<?php foreach ($registrosUsuarios as $r): ?>
									<option
									   value="<?php echo $r['id'] ?>"
									   <?php echo (isset($data['id_usuario_fk']) && $data['id_usuario_fk'] == $r['id']) ? 'selected' : '' ?>
									>
									<?php echo $r['nome'] ?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
						Nome da tarefa:
						<div class="form-group">
							<input type="text" name="nomedatarefa"  class="form-control"
							placeholder="Nome da tarefa" value="<?php echo $data['nomedatarefa'] ?? '' ?>">
						<br>
						Descricao:
                        <div class="form-group">
							<textarea name="descricao" class="form-control" id=""><?php echo isset($data['descricao']) ? trim($data['descricao']) : '' ?></textarea>
						</div>
						Incio:<br>
						<input type="date" class="form-control" name="inicio" value="<?php echo $data['inicio'] ?? '' ?>"><br>
						Fim:<br>
						<input type="date" class="form-control" name="fim" value="<?php echo $data['fim'] ?? '' ?>"><br>
						<br>

						<button class="btn btn-lg btn-success btn-block" name="btn-enviar" type="submit">Enviar</button>
			    	</fieldset>
					  </form>
			    </div>
			</div>
		</div>

		<div class="col-md-8">
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
				<td><?=$registro['inicio']?></td>
				<td><?=$registro['fim']?></td>

                <td>
					<a 
					   onclick="confirmeDelete(<?=$registro['id']?>)"
						class="btn btn-danger">
                        Excluir
					</a>

					<a href="?editar=<?=$registro['id']?>"
						<?php echo isset($_GET['editar']) && $_GET['editar'] == $registro['id'] ? 'disabled' : '' ?>
                        class="btn btn-warning">
                        Editar
					</a>
                </td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>
</div>
	</div>
</div>

<script>
	function confirmeDelete(id) {
		if (confirm("Tem certeza que deseja excluir o registro?")){
			location.href = '?excluir=' + id
		}
	}
</script>

<?php
include 'path/footer.php';
?>