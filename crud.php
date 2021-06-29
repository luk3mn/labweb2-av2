<?php
session_start(); // começa uma sessão

include('conexao.php'); // Chama o programa que realiza a conexão com o BD

# inicializa variáveis
$nome = "";
$descricao = "";
$qtdEstoque = "";
$precoUnit = "";
$id = 0;
$update = false;

# adiciona produto -> CREATE
if (isset($_POST['adiciona'])) {
  
  # Validando os campos de entrada
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
  $qtdEstoque = filter_input(INPUT_POST, 'qtdEstoque', FILTER_SANITIZE_STRING);
  $precoUnit = filter_input(INPUT_POST, 'precoUnit', FILTER_SANITIZE_STRING);

  # se $nome e $descricao estiverem vazios
  if ( ($nome) && ($descricao) && $qtdEstoque && $precoUnit) {

    # recebe os valores do formulario e faz o INSERT no BD
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $qtdEstoque = intval($_POST['qtdEstoque']); // faz a conversão pra float e add na variavel
    $precoUnit = floatval($_POST['precoUnit']); // faz a conversão pra int e add na variavel
    mysqli_query($db, "INSERT INTO produtos (nome, descricao, qtdEstoque, precoUnitario) VALUES ('$nome', '$descricao', '$qtdEstoque', '$precoUnit')");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto adicionado!";
    header('location: produtos.php');

  } else {
    
    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: produtos.php');

  }

}

# altera produto -> UPDATE
if (isset($_POST['altera'])) {

  # Validando os campos de entrada
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
  $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
  $qtdEstoque = filter_input(INPUT_POST, 'qtdEstoque', FILTER_SANITIZE_STRING);
  $precoUnit = filter_input(INPUT_POST, 'precoUnit', FILTER_SANITIZE_STRING);

  # se $nome e $descricao estiverem vazios
  if ( ($nome) && ($descricao) && ($qtdEstoque) && ($precoUnit)) {

    # recebe os valores do formulario e faz o UPDATE no BD
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $qtdEstoque = intval($_POST['qtdEstoque']);
    $precoUnit = floatval($_POST['precoUnit']);
    mysqli_query($db, "UPDATE produtos SET nome ='$nome', descricao = '$descricao', qtdEstoque = '$qtdEstoque', precoUnitario = '$precoUnit' WHERE id = $id");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto alterado!";
    header('location: produtos.php');

  } else {

    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: produtos.php');

  }

}

# remove produto -> DELETE
if (isset($_GET['del'])) {

  # recebe o valor pelo GET e faz o DELETE no BD
  $id = $_GET['del'];
  mysqli_query($db, "DELETE FROM produtos WHERE id=$id");

  # grava mensagem na sessão
  $_SESSION['message'] = "Produto removido!";
  header('location: produtos.php');

}

# Fecha a conexão com o banco de dados
if (isset($_POST['voltar'])) {
  mysqli_close($db);
  header('Location: inicio.php');
}