<?php session_start() ?>
<?php

if (!isset($_SESSION['carrinho'])) {

    $_SESSION['carrinho'] = array();
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

        header('location: index.php?status=success');
    }
    
    if ($_GET['acao'] == 'del') {
    
        $del = $_GET['barra'];
        unset($_SESSION['carrinho'][$del]);

    }
    header('location: index.php?status=success');
}


?>