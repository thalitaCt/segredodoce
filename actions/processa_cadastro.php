<?php
include '../includes/conexao.php';


$nome = $_POST['nome'];
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$codigo = rand(100000, 999999);


// verifica se email já existe
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);


if ($stmt->rowCount() > 0) {
    header("Location: ../cadastro.php?erro=email_existente");
    exit;
}


try {


    // INSERE USUÁRIO
    $sql = "INSERT INTO usuarios (email, senha, tipo, codigo_verificacao, verificado)
            VALUES (?, ?, 'cliente', ?, false)";


    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $senha, $codigo]);


    $id_usuario = $pdo->lastInsertId('usuarios_id_usuario_seq');


    // INSERE CLIENTE
    $sql = "INSERT INTO clientes (usuario_id, nome, telefone, endereco)
            VALUES (?, ?, ?, ?)";


    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $nome, $telefone, $endereco]);




    /* =========================
       SENDGRID API (SEM SMTP)
    ========================= */


    $apiKey = getenv('SENDGRID_API_KEY');


    $data = [
        "personalizations" => [
            [
                "to" => [
                    ["email" => $email]
                ]
            ]
        ],
        "from" => [
            "email" => "confeitariasegredoce@gmail.com",
            "name" => "Segredo Doce"
        ],
        "subject" => "Verificação de conta",
        "content" => [
            [
                "type" => "text/html",
                "value" => "
                    <h2>Seu código de verificação</h2>
                    <p>Olá, $nome</p>
                    <p>Seu código é:</p>
                    <h1 style='letter-spacing:5px;'>$codigo</h1>
                    <p>Digite esse código no site para ativar sua conta.</p>
                "
            ]
        ]
    ];


    $ch = curl_init();


    curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


    curl_close($ch);


    // opcional: debug simples se der erro
    if ($httpCode >= 400) {
        error_log("Erro SendGrid: " . $response);
    }


    header("Location: ../verificar.php?email=$email");
    exit;


} catch (PDOException $e) {
    echo "Erro real: " . $e->getMessage();
    exit;
}
?>
