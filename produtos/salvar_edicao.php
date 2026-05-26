<?php

include '../includes/conexao.php';
include '../includes/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

session_start();

if($_SESSION['tipo'] != 'gerente'){
    header("Location: ../login.php");
    exit;
}

$id = $_POST['id'];

$nome = trim($_POST['nome']);
$descricao = trim($_POST['descricao']);
$categoria = trim($_POST['categoria']);

$preco = str_replace(',', '.', $_POST['preco']);

$estoque = $_POST['estoque'];

/* =========================
   IMAGEM ATUAL
========================= */

$sqlImagem = $pdo->prepare("
SELECT imagem
FROM produtos
WHERE id_produtos = ?
");

$sqlImagem->execute([$id]);

$produto = $sqlImagem->fetch(PDO::FETCH_ASSOC);

$imagemBanco = $produto['imagem'];

/* =========================
   NOVA IMAGEM
========================= */

if(
    isset($_FILES['imagem'])
    &&
    $_FILES['imagem']['error'] == 0
){

    $imagem = $_FILES['imagem'];

    $extensao = strtolower(
        pathinfo(
            $imagem['name'],
            PATHINFO_EXTENSION
        )
    );

    $permitidas = [
        'jpg',
        'jpeg',
        'png',
        'webp',
        'avif',
        'jfif'
    ];

    if(!in_array($extensao, $permitidas)){

        header("Location: editar.php?erro=formato");
        exit;
    }

    try{

        $upload = new UploadApi();

        $resultado = $upload->upload(

            $imagem['tmp_name'],

            [
                'folder' => 'segredodoce/produtos'
            ]

        );

        $imagemBanco = $resultado['secure_url'];

    }
    catch(Exception $e){

        header("Location: editar.php?erro=upload");
        exit;
    }

}

/* =========================
   UPDATE
========================= */

$sql = $pdo->prepare("
UPDATE produtos 
SET 
nome = ?,
descricao = ?,
categoria = ?,
preco = ?,
estoque = ?,
imagem = ?
WHERE id_produtos = ?
");

$sql->execute([
    $nome,
    $descricao,
    $categoria,
    $preco,
    $estoque,
    $imagemBanco,
    $id
]);

header("Location: ../gerente.php?msg=produto_editado");
exit;

?>
