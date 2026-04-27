<?php
    $host = "ep-winter-wave-acvep69a-pooler.sa-east-1.aws.neon.tech";
    $db = "neondb";
    $user = "neondb_owner";
    $pass = "npg_PpQ23OwtrDxL";
    $port = "5432";

    $endpoint = "ep-winter-wave-acvep69a";

    $dns = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require;options=endpoint=$endpoint";

    try {
        $pdo = new PDO($dns, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false
        ]);
        echo "Conectou!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
?>