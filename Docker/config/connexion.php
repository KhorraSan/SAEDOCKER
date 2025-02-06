<?php
$servername = "db";
$usernameSQL = "root";
$passwordSQL = "vitrygtr";
$dbname = "docker";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $usernameSQL, $passwordSQL);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}

?>
