<?php
session_start(); // começa uma sessão

include('conexao.php'); // Chama o programa que realiza a conexão com o BD

# inicializa variáveis
$nome = "";
$endereco = "";
$fone = "";
$email = "";
$id = 0;
$update = false;

# adiciona cliente -> CREATE
if (isset($_POST['adiciona'])) {
  
  # Validando os campos de entrada
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
  $fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

  # e $nome e $endereclienteserem vazios
  if ( ($nome) && ($endereco) && ($fone) && ($email) ) {

    # recebe os valores do formulario e faz o INSERT no BD
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    mysqli_query($db, "INSERT INTO clientes (nomecli, endcli, fonecli, emailcli) VALUES ('$nome', '$endereco', '$fone', '$email')");

    # grava mensagem na sessão
    $_SESSION['message'] = "Cliente adicionado!";
    header('location: clientes.php');

  } else {
    
    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: clientes.php');

  }

}

# altera cliente -> UPDATE
if (isset($_POST['altera'])) {

  # Validando os campos de entrada
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
  $fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

  # e $nome e $endeclientesiverem vazios
  if ( ($nome) && ($endereco) && ($fone) && ($email)) {

    # recebe os valores do formulario e faz o UPDATE no BD
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    mysqli_query($db, "UPDATE clientes SET nomecli ='$nome', endcli = '$endereco', fonecli = '$fone', emailcli = '$email' WHERE idcli = $id");

    # grava mensagem na sessão
    $_SESSION['message'] = "Cliente alterado!";
    header('location: clientes.php');

  } else {

    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: clientes.php');

  }

}

# remove cliente -> DELETE
if (isset($_GET['del'])) {

  # recebe o valor pelo GET e faz o DELETE no BD
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM clientes WHERE idcli=$id");

  # grava mensagem na sessão
  $_SESSION['message'] = "Cliente removido!";
  header('location: clientes.php');

}

# Fecha a conexão com o banco de dados
if (isset($_POST['voltar'])) {
  mysqli_close($db);
  header('Location: inicio.php');
}