<?php
$servername = "localhost";
$usernameSQL = "root";
$passwordSQL = "";
$dbname = "docker";

try {
    $conn = new PDO("mysql:host=$servername;charset=utf8", $usernameSQL, $passwordSQL);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $usernameSQL, $passwordSQL);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS `membres` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nom` varchar(50) NOT NULL,
            `email` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `acces` varchar(50) NOT NULL DEFAULT 'Non Autoriser',
            `Grade` int(2) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
    )";   
    
    $conn->exec($sql);

    $checkSql = "SELECT COUNT(*) FROM membres WHERE email = 'fm6265786@gmail.com'";
    $checkStmt = $conn->query($checkSql);

    if ($checkStmt->fetchColumn() == 0) {
        // Hash du mot de passe
        $password = hash("sha256", "061170Filipe@");
    
        // Requête d'insertion préparée
        $sql = "INSERT INTO membres (nom, email, password, acces, Grade) VALUES (:nom, :email, :password, :acces, :Grade)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => 'Filipe MARQUES COELHO',
            ':email' => 'fm6265786@gmail.com',
            ':password' => $password,
            ':acces' => 'Autoriser',
            ':Grade' => '2',
        ]);
    }
    } catch(PDOException $e) {
    $e;
    //echo "Erreur : " . $e->getMessage();
}

?>
