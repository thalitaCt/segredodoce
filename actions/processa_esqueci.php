<?php
include '../includes/conexao.php';


$email = $_POST['email'] ?? '';


if (empty($email)) {
    header("Location: ../esqueci_senha.php?erro=email");
    exit;
}


$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);


$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$usuario) {
    header("Location: ../esqueci_senha.php?erro=email");
    exit;
}


/* nome seguro */
$nome = 'Usuário';


if ($usuario['tipo'] == 'cliente') {
    $sqlNome = $pdo->prepare("SELECT nome FROM clientes WHERE usuario_id = ?");
} else {
    $sqlNome = $pdo->prepare("SELECT nome FROM funcionarios WHERE usuario_id = ?");
}


$sqlNome->execute([$usuario['id_usuario']]);
$user = $sqlNome->fetch(PDO::FETCH_ASSOC);


if ($user && !empty($user['nome'])) {
    $nome = $user['nome'];
}


/* token */
$token = bin2hex(random_bytes(16));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));


$update = $pdo->prepare("
    UPDATE usuarios 
    SET token = :token, token_expira = :expira 
    WHERE email = :email
");


$update->execute([
    'token' => $token,
    'expira' => $expira,
    'email' => $email
]);


$link = "http://segredodoce.onrender.com/nova_senha.php?token=$token";


/* sendgrid */
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
        "email" => "confeitariasegredodoce@gmail.com",
        "name" => "Segredo Doce"
    ],
    "subject" => "Recuperação de Senha",
    "content" => [
        [
            "type" => "text/html",
            "value" => "
                <h2>Recuperação de Senha</h2>
                <p>Olá, $nome</p>
                <p>Clique no link para redefinir sua senha:</p>
                <a href='$link'>Redefinir senha</a>
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


curl_exec($ch);
curl_close($ch);


header("Location: ../login.php?msg=email_enviado");
exit;
?>
