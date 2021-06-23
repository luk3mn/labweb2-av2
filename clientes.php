<!-- chama o programa que faz o CRUD -->
<?php include('crud_cli.php'); ?>

<?php
    # Recupera o registro para a ediçao
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $update = true;
        $record = mysqli_query($db, "SELECT * FROM clientes WHERE idcli=$id");
        #teste o retorno do select e cria o vetor com os registros trazidos
        if ($record) {
            $n = mysqli_fetch_array($record);
            $nome = $n['nomecli'];
            $endereco = $n['endcli'];
            $fone = $n['fonecli'];
            $email = $n['emailcli'];
        }
    }

    # testa se existe uma sessao
    if (!isset($_SESSION['loginok'])) {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <!-- testa se a sessão existe e exibe sua mensagem -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="msg">
            <?php
                # exibe mensagem da sessão
                echo $_SESSION['message'];
                # apaga a sessão
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
    <!-- testa se a sessão ERRO existe e exibe sua mensagem -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="msg-erro">
            <?php
                # exibe mensagem da sessão
                echo $_SESSION['error'];
                # apaga a sessão
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    <!-- ------------------------------------------------- -->

    <!-- recupera os registros do banco de dados e exibe na página -->
    <?php $results = mysqli_query($db, "SELECT * FROM clientes"); ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Fone</th>
                <th>E-mail</th>
                <th colspan="2">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($results)) { ?> <!-- Fica no loop enquanto houver registro no array -->
            <tr>
                <th><?php echo $rs['idcli']; ?></th>
                <td><?php echo $rs['nomecli']; ?></td>
                <td><?php echo $rs['fonecli']; ?></td>
                <td><?php echo $rs['emailcli']; ?></td>
                <td>
                    <a href="clientes.php?edit=<?php echo $rs['idcli']; ?>" class="edit_btn">Alterar</a>
                </td>
                <td>
                    <a href="crud_cli.php?del=<?php echo $rs['idcli']; ?>" class="del_btn">Remover</a>
                </td>         
            </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form method="post" action="crud_cli.php">
        <!-- campo oculto - contem o id do registo que vai ser atualizado -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="input-group">
            <label>Nome do cliente</label>
            <input type="text" name="nome" value="<?php echo $nome; ?>">
        </div>
        <div class="input-group">
            <label>Endereço</label>
            <input type="text" name="endereco" value="<?php echo $endereco; ?>">
        </div>
        <div class="input-group">
            <label>Telefone</label>
            <input type="text" name="fone" value="<?php echo $fone; ?>">
        </div>
        <div class="input-group">
            <label>E-mail</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <?php if ($update == true) : ?>
                <button class="btn" type="submit" name="altera" style="background: #556B2F;">Alterar</button>
            <?php else : ?>
                <button class="btn" type="submit" name="adiciona">Adicionar</button>
                <button class="btn" type="submit" name="voltar">Voltar</button>
            <?php endif; ?>
        </div>
    </form>
</body>

</html>