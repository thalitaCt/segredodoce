<?php
include '../includes/conexao.php';

// =========================
// RECEBIMENTO DE DADOS
// =========================
$nome = trim($_POST['nome'] ?? '');
$telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

// =========================
// VALIDAÇÕES BÁSICAS
// =========================
if (!$nome || !$email || !$senha || !$confirmar_senha) {
    header("Location: ../cadastro.php?erro=geral");
    exit;
}

// valida email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../cadastro.php?erro=geral");
    exit;
}

// valida senha igual
if ($senha !== $confirmar_senha) {
    header("Location: ../cadastro.php?erro=senha_diferente");
    exit;
}

// valida telefone (Brasil: 10 ou 11 dígitos)
if (strlen($telefone) < 10 || strlen($telefone) > 11) {
    header("Location: ../cadastro.php?erro=telefone_invalido");
    exit;
}

// =========================
// VERIFICA SE EMAIL EXISTE
// =========================
$sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    header("Location: ../cadastro.php?erro=email_existente");
    exit;
}

// =========================
// CRIA USUÁRIO
// =========================
try {

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $codigo = rand(100000, 999999);

    $sql = "INSERT INTO usuarios (email, senha, tipo, codigo_verificacao, verificado)
            VALUES (?, ?, 'cliente', ?, FALSE)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $senha_hash, $codigo]);

    $id_usuario = $pdo->lastInsertId();

    // =========================
    // INSERE CLIENTE
    // =========================
    $sql = "INSERT INTO clientes (usuario_id, nome, telefone)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $nome, $telefone]);

    // =========================
    // ENVIO DE EMAIL (SENDGRID)
    // =========================
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
                    <h2>Bem-vindo, $nome</h2>
                    <p>Seu código de verificação é:</p>
                    <h1 style='letter-spacing:5px;'>$codigo</h1>
                    <p>Use ele para ativar sua conta no site.</p>
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

    if ($httpCode >= 400) {
        error_log("Erro SendGrid: " . $response);
    }

    // =========================
    // REDIRECIONAMENTO
    // =========================
    header("Location: ../verificar.php?email=$email&msg=cadastro_ok");
    exit;

} catch (PDOException $e) {
    error_log("Erro cadastro: " . $e->getMessage());
    header("Location: ../cadastro.php?erro=geral");
    exit;
}
?>
