<?php
session_start();


include '../includes/conexao.php';


$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if ($usuario) {


    if (password_verify($senha, $usuario['senha'])) {


        if (!$usuario['verificado']) {
            header("Location: ../verificar.php?erro=nao_verificado&email=$email");
            exit;
        }

        $_SESSION['id'] = $usuario['id_usuario'];
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['tipo'] = $usuario['tipo'];

        if($usuario['tipo'] == 'cliente'){
            $sql = $pdo->prepare("SELECT nome FROM clientes WHERE usuario_id = ?");
        } else {
            $sql = $pdo->prepare("SELECT nome FROM funcionarios WHERE usuario_id = ?");
        }

        $sql->execute([$usuario['id_usuario']]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);


        $_SESSION['nome'] = $user['nome'] ?? 'Usuário';

        switch($usuario['tipo']){
            case 'admin':
                header("Location: ../admin.php");
                break;


            case 'gerente':
                header("Location: ../gerente.php");
                break;


            case 'recepcionista':
                header("Location: ../atendente.php");
                break;


            default:
                header("Location: ../index.php");
        }
        exit;


    } else {
        header("Location: ../login.php?erro=senha");
        exit;
    }


} else {
    header("Location: ../login.php?erro=email");
    exit;
}
?>
