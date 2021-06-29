<!-- chama o programa que faz o CRUD -->
<?php include('crud_ven.php'); ?>
<?php
    # Recupera o registro para a ediçao
    if (isset($_GET['edit'])) {
        $codven = $_GET['edit'];
        $update = true;
        $record = mysqli_query($db, "SELECT * FROM vendas WHERE codven=$codven");
        #teste o retorno do select e cria o vetor com os registros trazidos
        if ($record) {
            $n = mysqli_fetch_array($record);
            $idcli = $n['idcli'];
            $idprod = $n['idprod'];
            $qtdItens = $n['qtdVen'];
        }
    }

    if (!isset($_SESSION['loginok'])) {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
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
    <?php $results = mysqli_query($db, "SELECT codven, qtdVen, nomecli, p.nome, (qtdVen * precoUnitario) as valorTotal FROM vendas v INNER JOIN produtos p ON v.idprod=p.id INNER JOIN clientes c ON v.idcli=c.idcli"); ?>
    <table>
        <thead>
            <tr>
                <th>Cod. Venda</th>
                <th>Nome Cliente</th>
                <th>Nome Produto</th>
                <th>Quantidade Vendida</th>
                <th>Valor Total</th>
                <th colspan="2">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($results)) { ?>
            <tr>
                <th><?php echo $rs['codven']; ?></th>
                <td><?php echo $rs['nomecli']; ?></td>
                <td><?php echo $rs['nome']; ?></td>
                <td><?php echo $rs['qtdVen']; ?></td>
                <td><?php echo $rs['valorTotal']; ?></td>
                <td>
                    <a href="vendas.php?edit=<?php echo $rs['codven']; ?>" class="edit_btn">Alterar</a>
                </td>
                <td>
                    <a href="crud_ven.php?del=<?php echo $rs['codven']; ?>" class="del_btn">Remover</a>
                </td>             
            </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->
    <form method="post" action="crud_ven.php">
        <input type="hidden" name="codven" value="<?php echo $codven; ?>">
        <div class="input-group">
            <label>Quantidade de itens</label>
            <input type="text" name="qtdItens" value="<?php echo $qtdItens; ?>">
        </div>
        <div class="input-group">
            <label>Id do Cliente</label>
            <input type="text" name="idcli" value="<?php echo $idcli; ?>">
        </div>
        <div class="input-group">
            <label>Id do Produto</label>
            <input type="text" name="idprod" value="<?php echo $idprod; ?>">
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