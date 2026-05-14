<?php
session_start();

include '../includes/conexao.php';


if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php?erro=login");
    exit;
}

$id = $_POST['id'] ?? null;


if(!$id){
    header("Location: ../cardapio.php?erro=produto");
    exit;
}


$sql = $pdo->prepare("
SELECT *
FROM produtos
WHERE id_produtos = ?
");


$sql->execute([$id]);
$produto = $sql->fetch(PDO::FETCH_ASSOC);


if(!$produto){
    header("Location: ../cardapio.php?erro=produto");
    exit;
}

if($produto['estoque'] <= 0){
    header("Location: ../cardapio.php?erro=estoque");
    exit;
}

$nome = $produto['nome'];
$nomeCurto = mb_strimwidth($nome, 0, 35, "...");


if(isset($_SESSION['carrinho'][$id])){

    if($_SESSION['carrinho'][$id]['quantidade'] < $produto['estoque']){
        $_SESSION['carrinho'][$id]['quantidade']++;

    }
    else{
        header("Location: ../cardapio.php?erro=estoque");
        exit;
    }

}
else{
    $_SESSION['carrinho'][$id] = [
        'id_produtos' => $produto['id_produtos'],
        'nome' => $produto['nome'],
        'preco' => $produto['preco'],
        'imagem' => $produto['imagem'],
        'categoria' => $produto['categoria'],
        'estoque' => $produto['estoque'],
        'quantidade' => 1
    ];


}

header("Location: ../cardapio.php?msg=adicionado&nome=" . urlencode($nomeCurto));

exit;
?>