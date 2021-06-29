<?php
  session_start(); // inicia a sessao;

  if (!isset($_SESSION['loginok'])) {
    header('location: index.php');
  }

  if (isset($_POST['logout'])) {
    # Inicia a sessão
    session_start(); 
  
    # encerra a sessão
    session_unset();
  
    # destroi a sessão
    session_destroy();
    
    # redireciona para a página de login
    header('location: index.php');
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Principal</title>
  <link rel="stylesheet" href="css/page-principal.css">
</head>
<body>
  <div class="container">

    <h1>Tela Principal</h1>

    <div class="box-content">
      
      <div class="author">
        <h3>Lucas Renan Maués Nunes</h3>
      </div>

      <div class="btn">
        <a href="produtos.php">
          <button id="produtos">Cadastro de produtos</button>
        </a>
        <a href="clientes.php">
          <button id="clientes">Cadastro de clientes</button>
        </a>
        <a href="vendas.php">
          <button id="vendas">Cadastrar Vendas</button>
        </a>
      </div>

      <form action="" method="POST">
        <button name="logout">Logout</button>
      </form>

    </div>
  </div>
  <footer>&copy;LabWebII - Lucas Renan</footer>
</body>
</html>