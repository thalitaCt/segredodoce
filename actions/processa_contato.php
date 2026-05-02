<?php
include '../includes/conexao.php';


$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$assunto = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');


$assuntosPermitidos = [
    'pedido',
    'encomenda',
    'cardapio',
    'entrega',
    'parceria',
    'sugestao',
    'outro'
];


if (!in_array($assunto, $assuntosPermitidos)) {
    header("Location: ../contato.php?erro=assunto");
    exit;
}


if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
    header("Location: ../contato.php?erro=campos_vazios");
    exit;
}


try {


    // salva no banco
    $sql = $pdo->prepare("
        INSERT INTO contatos (nome, email, assunto, mensagem)
        VALUES (?, ?, ?, ?)
    ");


    $sql->execute([$nome, $email, $assunto, $mensagem]);


    /* =========================
       SENDGRID API
    ========================= */


    $apiKey = getenv('SENDGRID_API_KEY');


    $data = [
        "personalizations" => [
            [
                "to" => [
                    ["email" => "confeitariasegredoce@gmail.com"]
                ]
            ]
        ],
        "from" => [
            "email" => "confeitariasegredoce@gmail.com",
            "name" => "Segredo Doce - Site"
        ],
        "subject" => "Novo contato - " . ucfirst($assunto),
        "content" => [
            [
                "type" => "text/html",
                "value" => "
                    <h2>Novo contato pelo site</h2>
                    <p><strong>Nome:</strong> $nome</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Assunto:</strong> " . ucfirst($assunto) . "</p>
                    <p><strong>Mensagem:</strong><br>$mensagem</p>
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
        error_log("Erro SendGrid contato: " . $response);
    }


    header("Location: ../contato.php?msg=enviado");
    exit;


} catch (Exception $e) {
    header("Location: ../contato.php?erro=geral");
    exit;
}
?>
