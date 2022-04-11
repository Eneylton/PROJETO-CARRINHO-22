<?php session_start() ?>
<?php

include_once('connect.php');

$id  = 0;
$qtd = 0;
$del = 0;
$calculo = 0;
$total = 0;
$porcento = 0;
$valor_base = 0;
$produto = 0;
$sub = 0;
$result = "";
$result2 = "";
$desconto = "";


if (!isset($_SESSION['carrinho'])) {

    $_SESSION['carrinho'] = array();
}

if (isset($_POST['buscar'])) {

    $codigo = filter_input(INPUT_POST, 'buscar', FILTER_UNSAFE_RAW);

    if (!isset($_SESSION['carrinho'][$codigo])) {

        $_SESSION['carrinho'][$codigo] = 1;

    } else {

        $_SESSION['carrinho'][$codigo] += 1;
    }
}

if (isset($_GET['id'])) {

    if (!isset($_SESSION['carrinho'][$_GET['id']])) {

        $_SESSION['carrinho'][$_GET['id']] = 1;
    } else {

        $_SESSION['carrinho'][$_GET['id']] += 1;
    }
}

if(isset($_GET['acao'])){

    if ($_GET['acao'] == 'edit') {

        foreach ($_POST['produto'] as $codigo => $qtd) {
    
            $codigo = intval($codigo);
            $qtd = intval($qtd);
    
            if (!empty($qtd) || $qtd != 0) {
    
                $_SESSION['carrinho'][$codigo] = $qtd;
            } else {
    
                unset($_SESSION['carrinho'][$codigo]);
            }
        }
    }
}


$sql = "SELECT * FROM produtos";

$res = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_assoc($res)) {

    $result .= ' <tr>
<td>' . $rows['id'] . '</td>
<td>' . $rows['nome'] . '</td>
<td>' . $rows['barra'] . '</td>
<td>' . $rows['qtd'] . '</td>
<td>R$ ' . number_format($rows['preco'], "2", ",", ".") . '</td>
<td><a href="?id=' . $rows['barra'] . '">ADICIONAR</a></td>
</tr>';
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Carrinho</title>
</head>

<body>

    <div class="container">
        <h2>PDV DESENVOLVIMENTO</h2>
        <p>CARRINHO PARA PDV</p>

        <form method="post">
            <div class="row">
                <div class="col-6">
                    <input type="text" name="buscar" class="form-control float-right" placeholder="Pesquisar...." autofocus>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Adiciona
                    </button>
                </div>


            </div>
        </form>
        <div style="margin-top: 20px;">

            <table class="table table-success">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>BARRA</th>
                        <th>QTD</th>
                        <th>VALOR</th>
                        <th>AÇÕES</th>

                    </tr>
                </thead>
                <tbody>

                    <?= $result ?>

                </tbody>
            </table>
        </div>

        <div style="margin-top: 50px;">

            <form action="?acao=edit" method="post">

                <table class="table table-primary">
                    <thead class="thead-dark">
                        <tr>
                            <th>CÓDIGO</th>
                            <th>PRODUTO</th>
                            <th>BARRA</th>
                            <th>QTD</th>
                            <th>VALOR</th>
                            <th>SUBTOTAL</th>
                            <th>DESCONTO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php



                        foreach ($_SESSION['carrinho'] as $prod => $qtd) {

                            $sql2 = "SELECT * FROM produtos WHERE barra='$prod'";

                                $res2 = mysqli_query($conn, $sql2);

                                $resultado = mysqli_fetch_assoc($res2);

                                $sub = $qtd * $resultado['preco'];

                                $total += $sub;

                            if(isset($_POST['porcent'][$prod])){

                                $porcento = $_POST['porcent'][$prod];

                            if($porcento != ""){

                                $sql2 = "SELECT * FROM produtos WHERE barra='$prod'";

                                $res2 = mysqli_query($conn, $sql2);

                                $resultado = mysqli_fetch_assoc($res2);

                                $calculo = $qtd * $resultado['preco'];

                                $sub  = $calculo  - ($calculo  * $porcento / 100);

                                $total += $sub;

                            }else{

                                $sql2 = "SELECT * FROM produtos WHERE barra='$prod'";

                                $res2 = mysqli_query($conn, $sql2);

                                $resultado = mysqli_fetch_assoc($res2);

                                $sub = $qtd * $resultado['preco'];

                                $total += $sub;
                            }

                            }

                            
                            echo '<tr>';
                            echo '<td>' . $resultado['id'] . '</td>';
                            echo '<td>' . $resultado['nome'] . '</td>';
                            echo '<td>' . $resultado['barra'] . '</td>';
                            echo '<td><input class="form-control" type="text" name="produto[' . $resultado['barra'] . ']" value="' . $qtd . '" style="width:50px; text-align:center" /></td>';
                            echo '<td>R$ ' . number_format($resultado['preco'], "2", ",", ".") . '</td>';
                            echo '<td>R$ ' . number_format($sub, "2", ",", ",") . '</td>';
                            echo ' <td style="text-align:left">
                                  <select class="form-control" name="porcent[' . $resultado['barra'] . ']">
                                  <option value="">%</option>
                                  <option value="5">5%</option>
                                  <option value="10">10%</option>
                                  <option value="15">15%</option>
                                  <option value="20">20%</option>
                                  <option value="50">50%</option>
                                  </select>
                                  </td>';
                            echo '<td>

                            <button class="btn btn-danger" type="submit"><i class="fas fa-pen"></i> EDITAR</button>
                            &nbsp;&nbsp;
                             <a class="btn btn-primary" href="acao.php?acao=del&barra=' . $resultado['barra'] . '">DELETE</a>
                             </td>';
                            echo '</tr>';
                        }

                        ?>

                    </tbody>
                    <tr>

                        <td colspan="5" style="text-align:right;"><span> TOTAL</span></td>
                        <td colspan="3"><span style="text-align: rigth;">R$ <?= number_format($total, "2", ",", ".") ?></span></td>

                    </tr>
                </table>
            </form>
        </div>
</body>

</html>