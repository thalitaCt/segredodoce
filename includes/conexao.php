<?php

date_default_timezone_set('America/Sao_Paulo');

    $host = "ep-winter-wave-acvep69a-pooler.sa-east-1.aws.neon.tech";
    $db = "neondb";
    $user = "neondb_owner";
    $pass = "npg_PpQ23OwtrDxL";

    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$db;sslmode=require", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
?>
