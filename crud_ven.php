<?php
session_start(); // começa uma sessão

include('conexao.php'); // Chama o programa que realiza a conexão com o BD

# inicializa variáveis
$idcli = "";
$idprod = "";
$qtdItens = "";
$codven = 0;
$update = false;

# adiciona venda -> CREATE
if (isset($_POST['adiciona'])) {
  
  # Validando os campos de entrada
  $idcli = filter_input(INPUT_POST, 'idcli', FILTER_SANITIZE_STRING);
  $idprod = filter_input(INPUT_POST, 'idprod', FILTER_SANITIZE_STRING);
  $qtdItens = filter_input(INPUT_POST, 'qtdItens', FILTER_SANITIZE_STRING);

  # se $nome e $descricao estiverem vazios
  if (($qtdItens) && ($idcli) && ($idprod)) {

    # recebe os valores do formulario e faz o INSERT no BD
    $idcli = intval($_POST['idcli']); // faz a conversão pra int e add na variavel
    $idprod = intval($_POST['idprod']);
    $qtdItens = intval($_POST['qtdItens']);
    
    # faz a consulta nas tabelas
    $resultsCli = mysqli_query($db, "SELECT * FROM clientes");
    $resultsProd = mysqli_query($db, "SELECT * FROM produtos");
    $resultsVenda = mysqli_query($db, "SELECT * FROM vendas");

    # percorre a tabela de clientes
    while ($rs = mysqli_fetch_array($resultsCli)) {
      if ($idcli == $rs['idcli']) {
        $idcliValid = $rs['idcli'];
      }
    }

    # percorre a tabela de produtos
    while ($rs = mysqli_fetch_array($resultsProd)) {
      if ($idprod == $rs['id']) {
        $idprodValid = $rs['id'];
      }
      if ($idprod == $rs['id']) {
        $qtdEstoque = $rs['qtdEstoque'];
      }
    }

    # valida a exitencia do cliente e produto no banco de dados
    if ($idcli != $idcliValid) {
      # grava mensagem na sessão
      $_SESSION['error'] = "Cliente não foi cadastrada!";
    } else if ($idprod != $idprodValid) {
      # grava mensagem na sessão
      $_SESSION['error'] = "Produto não foi cadastrada!";
    } else {

      # valida a quantidade vendida
      if ($qtdItens <= $qtdEstoque) {
        mysqli_query($db, "INSERT INTO vendas (idcli, idprod, qtdVen) VALUES ((SELECT idcli FROM clientes WHERE idcli = $idcli), (SELECT id FROM produtos WHERE id = $idprod), $qtdItens)");
        # grava mensagem na sessão
        $_SESSION['message'] = "Venda realizada!";
      } else {
        # grava mensagem na sessão
        $_SESSION['error'] = "Produto em estoque é insuficiente";
      }
      
    }
    header('location: vendas.php');

  } else {
    
    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: vendas.php');

  }

}

# altera produto -> UPDATE
if (isset($_POST['altera'])) {

  # Validando os campos de entrada
  $idcli = filter_input(INPUT_POST, 'idcli', FILTER_SANITIZE_STRING);
  $idprod = filter_input(INPUT_POST, 'idprod', FILTER_SANITIZE_STRING);
  $qtdItens = filter_input(INPUT_POST, 'qtdItens', FILTER_SANITIZE_STRING);

  # se $nome e $descricao estiverem vazios
  if (($qtdItens) && ($idcli) && ($idprod)) {

    # recebe os valores do formulario e faz o UPDATE no BD
    $codven = $_POST['codven'];
    $idcli = intval($_POST['idcli']);
    $idprod = intval($_POST['idprod']);
    $qtdItens = intval($_POST['qtdItens']);
    
    # faz a consulta nas tabelas
    $resultsCli = mysqli_query($db, "SELECT * FROM clientes");
    $resultsProd = mysqli_query($db, "SELECT * FROM produtos");
    $resultsVenda = mysqli_query($db, "SELECT * FROM vendas");

    # percorre a tabela de clientes
    while ($rs = mysqli_fetch_array($resultsCli)) {
      if ($idcli == $rs['idcli']) {
        $idcliValid = $rs['idcli'];
      }
    }

    # percorre a tabela de produtos
    while ($rs = mysqli_fetch_array($resultsProd)) {
      if ($idprod == $rs['id']) {
        $idprodValid = $rs['id'];
      }
      if ($idprod == $rs['id']) {
        $qtdEstoque = $rs['qtdEstoque'];
      }
    }

    # valida a exitencia do cliente e produto no banco de dados
    if ($idcli != $idcliValid) {
      # grava mensagem na sessão
      $_SESSION['error'] = "Cliente não foi cadastrada!";
    } else if ($idprod != $idprodValid) {
      # grava mensagem na sessão
      $_SESSION['error'] = "Produto não foi cadastrada!";
    } else {
      
      # valida a quantidade vendida
      if ($qtdItens <= $qtdEstoque) {
        mysqli_query($db, "UPDATE vendas SET idcli = '$idcli', idprod = '$idprod', qtdVen = '$qtdItens' WHERE codven = $codven");
        # grava mensagem na sessão
        $_SESSION['message'] = "Venda alterada!";
      } else {
        # grava mensagem na sessão
        $_SESSION['error'] = "Produto em estoque é insuficiente";
      }

    }
    header('location: vendas.php');
    
  } else {

    # grava mensagem na sessão
    $_SESSION['error'] = "Você não preencheu todos os campos!";
    header('location: vendas.php');

  }

}

# remove produto -> DELETE
if (isset($_GET['del'])) {

  # recebe o valor pelo GET e faz o DELETE no BD
  $codven = $_GET['del'];
  mysqli_query($db, "DELETE FROM vendas WHERE codven=$codven");

  # grava mensagem na sessão
  $_SESSION['message'] = "Venda removida!";
  header('location: vendas.php');

}

# Fecha a conexão com o banco de dados
if (isset($_POST['voltar'])) {
  mysqli_close($db);
  header('Location: inicio.php');
}