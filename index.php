<?php include('login.php') ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de login</title>
  <link rel="stylesheet" href="css/pagina-login.css">
</head>
<body>

  <div class="erro-box">
    <!-- Menasgem de erro da sessao -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="msg-error">
            <?php
                # exibe mensagem da sessão
                echo $_SESSION['error'];
                # apaga a sessão
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    <!-- FIM -->

    <!-- Menasgem de erro da sessao login invalido -->
    <?php if (isset($_SESSION['loginerr'])) : ?>
        <div class="msg-error">
            <?php
                # exibe mensagem da sessão
                echo $_SESSION['loginerr'];
                # apaga a sessão
                unset($_SESSION['loginerr']);
            ?>
        </div>
    <?php endif; ?>
    <!-- FIM -->
  </div>

  <div class="container">

    <div class="formulario">
      <h1> Login </h1>

      <form action="login.php" method="POST">
        <input type="text" name="nome" placeholder="Nome de usuário">
        <input type="password" name="senha" placeholder="Senha">
        <button name="entrar">Entrar</button>
      </form>

    </div>
  </div>
  <div class="rodape">
    <footer>
      &copy;Lucas Renan Maues Nunes
    </footer>
  </div>
</body>
</html>