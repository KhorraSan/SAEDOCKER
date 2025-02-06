<?php

session_start();
require("config/keycloack.php");

if(isset($_SESSION['.K]=h{g8;n!P\CED']))
{
    if(!empty($_SESSION['.K]=h{g8;n!P\CED']))
    {
        if ($_SESSION['.K]=h{g8;n!P\CED']['acces'] == "Non Autoriser") {
            echo "<script>
            window.location.href = 'index.php';
            </script>";
        }
    }
}
$Url = getKeycloakLogoutUrl();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="fr" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>FL - Se connecter</title>
    <link rel="stylesheet" href="styles.css">
    <style>

        /* Content */
        .content {
            padding: 20px;
            margin-top: 20px;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #e60000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <!-- Remplacez l'URL de l'image par celle de votre logo -->
        <img src="logo.png" alt="Logo"> <!-- Logo -->
        <h2>FL</h2> <!-- Titre -->
    </div>

    <div class="buttons">
        <button>Accueil</button>
        <button>Accès</button>
        <button>Vider le Tableau</button>
	<button onclick="window.location.href='<?php echo $Url; ?>'">Deconnexion</button>
    </div>
</header>

<div class="content">
    <table id="dynamicTable" class="hidden">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Âge</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les données du tableau seront insérées ici par JavaScript -->
        </tbody>
    </table>
</div>
</body>
</html>

<?php
?>
