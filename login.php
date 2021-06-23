<?php
session_start();  // inicia a sessao;

include('conexao.php'); // chama o programa que realiza a conexão

if (isset($_POST['entrar'])) {
  
  # filtrando os inputs
  $username = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

  # validando os inputs do formulario
  if (($username) && ($password)) {
    
    try {
      # cria a consulta SQL      
      $query = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";

      # prepara o comando SQL
      $stmt = $conexao->prepare($query);

      # atribui os valores a consulta SQL
      $stmt->bindValue(1, $_POST['nome']);
      $stmt->bindValue(2, $_POST['senha']);

      # executa a consulta
      $stmt->execute();

      # verifica se tem registros
      if ($stmt->rowCount() > 0) {
        # cria uma sessão para o login
        $_SESSION['loginok'] = 'login OK';
        header('location: inicio.php');
      } else {
        # cria uma sessão para login inválido
        $_SESSION['loginerr'] = 'Login Inválido';
        header('location: index.php');       
      }

    } catch (PDOException $e) {
      echo 'Cod. Erro: ' . $e->getCode() . '<br>' . 'Mensagem: ' . $e->getMessage();
    }

  } else {

    # grava mensagem na sessão
    $_SESSION['error'] = "Preencha todos os campos!";
    header('location: index.php');
    
  }
} 