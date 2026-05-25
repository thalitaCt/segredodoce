<?php

include '../includes/conexao.php';
include '../includes/cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

session_start();


if($_SESSION['tipo'] != 'gerente'){

    header("Location: ../login.php");
    exit;
}


/* =========================
   DADOS
========================= */

$nome = trim($_POST['nome']);

$categoria = trim($_POST['categoria']);

$preco = str_replace(',', '.', $_POST['preco']);

$estoque = $_POST['estoque'];

$descricao = trim($_POST['descricao']);


/* =========================
   VALIDAÇÕES
========================= */

if(

    empty($nome) ||
    empty($categoria) ||
    empty($preco) ||
    empty($estoque)

){

    header("Location: criar.php?erro=campos_vazios");
    exit;
}


/* =========================
   IMAGEM
========================= */

if(

    !isset($_FILES['imagem'])
    ||
    $_FILES['imagem']['error'] != 0

){

    header("Location: criar.php?erro=imagem_invalida");
    exit;
}


$imagem = $_FILES['imagem'];


/* EXTENSÃO */

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

    header("Location: criar.php?erro=formato_invalido");
    exit;
}


/* ENVIO CLOUDINARY */

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

    header("Location: criar.php?erro=erro_upload");
    exit;
}


/* =========================
   INSERT
========================= */

$sql = $pdo->prepare("

INSERT INTO produtos

(

    nome,
    categoria,
    preco,
    estoque,
    descricao,
    imagem

)

VALUES

(

    ?, ?, ?, ?, ?, ?

)

");


$sql->execute([

    $nome,
    $categoria,
    $preco,
    $estoque,
    $descricao,
    $imagemBanco

]);


header("Location: ../gerente.php?msg=produto_criado");

exit;

?>