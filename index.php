<?php session_start() ?>
<?php

include_once('connect.php');

$del = 0;

if (isset($_SESSION['venda'])) {
} else {
    $_SESSION['venda'] = array();
}

    if (isset($_GET['id'])) {

        $_SESSION['venda'][$_GET['id']] = 1;
    }


if (isset($_GET['del'])) {

    $del = $_GET['del'];
    unset($_SESSION['venda'][$del]);

}

if (isset($_POST['buscar'])) {

    $codigo = filter_input(INPUT_POST, 'buscar', FILTER_UNSAFE_RAW);
    
    $_SESSION['venda'][$codigo] = 1;

}

$result = "";
$result2 = "";

$sql = "SELECT * FROM produtos";

$res = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_assoc($res)) {

    $result .= ' <tr>
                    <td>' . $rows['id'] . '</td>
                    <td>' . $rows['nome'] . '</td>
                    <td>' . $rows['barra'] . '</td>
                    <td>' . $rows['qtd'] . '</td>
                    <td>' . $rows['preco'] . '</td>
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
        <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="buscar" class="form-control float-right" placeholder="Pesquisar...." autofocus>
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i>
                </button>
        </div>
        
        </form>
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

        <div style="margin-top: 120px;">
            </hr>
        </div>

        <table class="table table-primary">
            <thead class="thead-dark">
                <tr>
                    <th>CÓDIGO</th>
                    <th>PRODUTO</th>
                    <th>BARRA</th>
                    <th>QTD</th>
                    <th>VALOR</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
            

                <?php

                foreach ($_SESSION['venda'] as $prod => $qtd){

                    $sql2 = "SELECT * FROM produtos WHERE barra='$prod'";
                    $res2 = mysqli_query($conn, $sql2);
                    $resultado = mysqli_fetch_assoc($res2);

                    echo '<tr>';
                    echo '<td>'.$resultado['id'].'</td>';
                    echo '<td>'.$resultado['nome'].'</td>';
                    echo '<td>'.$resultado['barra'].'</td>';
                    echo '<td>'.$resultado['qtd'].'</td>';
                    echo '<td>'.$resultado['preco'].'</td>';
                    echo '<td><a href="?del='.$resultado['barra'].'">DELETE</a></td>';
                    echo '</tr>';

                }

                ?>

            </tbody>
        </table>
    </div>
</body>

</html>