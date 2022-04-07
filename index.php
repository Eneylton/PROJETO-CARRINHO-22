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

$result = "";
$result2 = "";

$sql = "SELECT * FROM produtos";

$res = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_assoc($res)) {

    $result .= ' <tr>
                    <td>' . $rows['id'] . '</td>
                    <td>' . $rows['descricao'] . '</td>
                    <td><a href="?id=' . $rows['id'] . '">ADICIONAR</a></td>
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
        <h2>Basic Table</h2>
        <p>CARRINHO PARA PDV</p>
        <table class="table table-success">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
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
                    <th>VALOR</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
            

                <?php

                foreach ($_SESSION['venda'] as $prod => $qtd){

                    $sql2 = "SELECT * FROM produtos WHERE id='$prod'";
                    $res2 = mysqli_query($conn, $sql2);
                    $resultado = mysqli_fetch_assoc($res2);

                    echo '<tr>';
                    echo '<td>'.$resultado['id'].'</td>';
                    echo '<td>'.$resultado['descricao'].'</td>';
                    echo '<td>'.$resultado['preco'].'</td>';
                    echo '<td><a href="?del='.$resultado['id'].'">DELETE</a></td>';
                    echo '</tr>';

                }

                ?>

                
                    
                   
                  
              

            </tbody>
        </table>
    </div>
</body>

</html>