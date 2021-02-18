<?php
session_start();
//conexao com o banco
require_once 'conexao.php';

$conexao = novaConexao();

//bota enviar para o bando de dados
if (isset($_POST['btn-entrar'])) {
    $erros = [];
    $email = mysqli_escape_string($conexao, $_POST['email']); //filtrar os dados
    $senha = mysqli_escape_string($conexao, $_POST['senha']);

    if (empty($email) or empty($senha)) { //se um dos campos estiver vazio
        $erros[] = "O campo email/senha precisa ser preenchido";
    } else {
        $senhaCriptografada = md5($senha);
        $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
        $query = $conexao->prepare($sql);
        $query->bind_param("ss", $email, $senhaCriptografada);
        $query->execute();

        $resultado = $query->get_result();
        
        if ($resultado->num_rows > 0) {
            $data = $resultado->fetch_array(MYSQLI_ASSOC);  
            
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario'] = $data['id'];
            $_SESSION['nome'] = $data['nome'];
            $_SESSION['admin'] = ($data['admin'] == 1);
            header('location: tarefas.php');
        } else {
            $erros[] = "Email e senha nao conferem";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <title>Gerenciador de tarefas</title>
</head>
<body>
    <div class="container">
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Login</h3>
                    <?php
                        //exibir o erro
                        if (!empty($erros)):
                            foreach ($erros as $erro):
                                echo $erro;
                            endforeach;
                        endif;
                        ?>
                                        
			  	<div class="panel-body">
			    	<form method="POST" >
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="seuemail@example.com" name="email" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="senha" name="senha" type="password">
			    		</div>
			    		<div class="checkbox">
			    	    	<label>
			    	    		<input name="lembrar" type="checkbox"> Lembrar
			    	    	</label>
			    	    </div>
			    		<input class="btn btn-lg btn-success btn-block" name="btn-entrar" type="submit" value="Entrar">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

</form>
</body>
</html>
