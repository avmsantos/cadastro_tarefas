<?php
  require_once __DIR__  . "./../helper/logado.php";
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
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <title>Gerenciador de tarefas</title>
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container-fluid blue-600">
    <a class="navbar-brand" href="tarefas.php">Gerenciador de tarefas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="tarefas.php">Tarefas</a>
        </li>

        <?php if ($_SESSION['admin']) :?>
        <li class="nav-item">
          <a class="nav-link" href="cadastro.php">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadastro_tarefas.php">Tarefas</a>
        </li>
        <?php endif ;?>
        <li class="nav-item">
          <a class="nav-link " id="navbarDropdownMenuLink">
            <?php echo $_SESSION['nome'] ?>
          </a>
        </li>
  
        <li class="nav-item dropdown">
          <a class="nav-link " href="logout.php" id="navbarDropdownMenuLink">
            Sair
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

