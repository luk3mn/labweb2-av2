<?php
# conecta com o BD
$server = 'localhost';
$user = 'root';
$psw = '';
$dbase = 'loja';
$db = mysqli_connect($server, $user, $psw, $dbase);


/*********** CONEXÂO COM PDO PARA A TELA DE LOGIN  ***********/
$dsn = 'mysql:host=localhost;dbname=loja';
$user = 'root';
$psw = '';

try {
  # cria um objeto PDO - $conexao
  $conexao = new PDO($dsn, $user, $psw);
} catch (PDOException $e) {
  # mostrando o código de erro e sua mensagem
  echo 'Cod. Erro: ' . $e->getCode() . '<br>' . 'Mensagem: ' . $e->getMessage();
}