<?php
namespace App\config;
include 'path/cabecalho.php';

//require_once "conexao.php";

$registros = [];
$conexao = novaConexao();

$data = [];

if (isset($_GET['excluir'])) {
    $excluirSQL = "DELETE FROM usuario WHERE id = ?";
    $stmt = $conexao->prepare($excluirSQL);
    $stmt->bind_param("i", $_GET['excluir']);
    if ($stmt->execute()) {
        header("location:cadastro.php");
    }
}

$sql = "SELECT id, nome, email FROM usuario";
$resultado = $conexao->query($sql);
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $registros[] = $row;
    }
} elseif ($conexao->error) {
    echo "Erro: " . $conexao->error;
}

if (isset($_GET['editar'])) {
    $sql = "SELECT * FROM usuario WHERE id = ?";
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
			    	<h3 class="panel-title">Cadastro</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form action="dados.php" method="POST">

					<input name="id" value="<?php echo $_GET['editar'] ?? null ?>" hidden />

                    <fieldset>
					Nome:
                    <div class="form-group">
							<input class="form-control"
							placeholder="seu nome" name="nome" type="text"
							value="<?php echo $data['nome'] ?? '' ?>">
			    		</div>
						Email:
                        <div class="form-group">
							<input class="form-control" placeholder="seuemail" name="email"
							value="<?php echo $data['email'] ?? '' ?>"
							type="text">
						</div>

						Senha:
			    		<div class="form-group">
							<input class="form-control" placeholder="sua senha"

							name="senha" type="password">
			    		</div>
						<button class="btn btn-lg btn-success btn-block" name="btn-enviar" type="submit">Salvar</button>
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
		<div class="col-md-8">
		<table class="table table-hover table-striped table-bordered">
    <thead>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
    </thead>
    <tbody>
        <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?=$registro['id']?></td>
                <td><?=$registro['nome']?></td>
                <td><?=$registro['email']?></td>
                <td>
				   <a 
				   onclick="confirmeDelete(<?=$registro['id']?>)"
						class="btn btn-danger ">
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
