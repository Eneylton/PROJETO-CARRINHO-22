<?php

include_once('connect.php');

$result = "";

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./datatables.min.css" />

    <script type="text/javascript" src="./datatables.min.js"></script>
    <title>MEu PDV</title>
</head>

<body>

    <table id="example" class="table table-striped" style="width:100%">
        <thead>
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
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>