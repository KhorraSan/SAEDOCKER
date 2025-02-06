<?php
session_start();

require("config/creationdb.php");
require("config/fonction.php");
require("config/keycloack.php");  // Assurez-vous que ce fichier est bien inclus

// 🔹 Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['.K]=h{g8;n!P\CED']) && !empty($_SESSION['.K]=h{g8;n!P\CED'])) {
    if ($_SESSION['.K]=h{g8;n!P\CED']['acces'] == "Autoriser") {
        echo "<script>window.location.href = 'dashboard.php';</script>";
        exit();
    }
}

// 🔹 Vérifie si Keycloak a renvoyé un code d'autorisation
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $url = KEYCLOAK_BASE_URL . "/realms/" . REALM . "/protocol/openid-connect/token";
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => REDIRECT_URI,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if (isset($json['access_token'])) {
        $_SESSION['access_token'] = $json['access_token'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Erreur lors de l'authentification via Keycloak.";
    }
}

// 🔹 Génération du lien de connexion Keycloak
$keycloakLoginUrl = getKeycloakLoginUrl();
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
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="header-left-panel">
                <div class="logo">
                    <img src="logo.png" alt="RoomFinder Logo">
                    <a href="index.php"><h4>FL</h4></a>
                </div>
            </div>
            <div class="box-form-left-panel">
                <div class="connecter">
                    <h2>Se connecter</h2>
                    <h4><a href="#" id="Interne">Interne</a><a href="#" id="Externe">Externe</a></h4>
                </div>
                <form action="#" method="POST" id="InterneForm" style="display:block;">
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="EmailAddress" placeholder="email@example.com" required>
                    </div>
                    <div class="input-group password-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="Password" placeholder="********" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <div class="forgot-password">
                        <h4><a href="#" style="color: #CF0A1D;" >Inscrivez-vous</a> ou <a href="#" style="color: #CF0A1D;" >Mot de passe oublié ?</a></h4>
                    </div>
                    <button type="submit" name="submitFormSignIn" class="btn-primary">Se connecter</button>
                    <div style="width:100%; heigth:100%;">
                         <a href="<?= $keycloakLoginUrl ?>" class="btn-primary Keyloack">Connexion Keycloack</a>
                    </div>
                </form>
                <form action="#" method="POST" id="ExterneForm" style="display:none;">
                    <div class="input-group">
                        <label for="emailExterne">E-mail</label>
                        <input type="email" id="emailExterne" name="EmailAddressExterne" placeholder="emailexterne@example.com" required>
                    </div>
                    <div class="input-group password-group">
                        <label for="passwordExterne">Mot de passe</label>
                        <input type="password" id="passwordExterne" name="PasswordExterne" placeholder="********" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <div class="forgot-password">
                        <h4><a href="#" style="color: #007BFF;" >Inscrivez-vous</a> ou <a href="#" style="color: #007BFF;" >Mot de passe oublié ?</a></h4>
                    </div>
                    <button type="submit" name="submitFormSignInExterne" class="btn-secondaire">Se connecter</button>
                    <div style="width:100%; heigth:100%;">
                        <a href="<?= $keycloakLoginUrl ?>" class="btn-secondaire Keyloack">Connexion Keycloack</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="right-panel">
            <div class="icon-right-panel"></div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

<?php
// Code de connexion interne et externe
if (isset($_POST['submitFormSignInExterne'])) {
    if (!empty($_POST['EmailAddressExterne']) AND !empty($_POST['PasswordExterne'])) {
        $checkingEmail = htmlspecialchars(strip_tags($_POST['EmailAddressExterne']));
        $checkingPassword = htmlspecialchars(strip_tags($_POST['PasswordExterne']));

        $admin = connexionAdmin($checkingEmail, hash("sha256", $checkingPassword));

        if ($admin) {
            $_SESSION['.K]=h{g8;n!P\CED'] = $admin;
            if ($_SESSION['.K]=h{g8;n!P\CED']['acces'] == "Autoriser") {
                echo "<script>window.location.href = 'dashboard.php';</script>";
            }
        }
    }
}

if (isset($_POST['submitFormSignIn'])) {
    if (!empty($_POST['EmailAddress']) AND !empty($_POST['Password'])) {
        echo "OK";
        $email = $_POST['EmailAddress'];
        $ldap_search_filter = "(mail=$email)";
        $ldap_admin_dn = "cn=admin,dc=example,dc=com";  // DN de l'administrateur LDAP
        $ldap_connection = ldap_connect("ldap://ldap");
        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        if (@ldap_bind($ldap_connection, $ldap_admin_dn, "adminpassword")) {
            $base_dn = "ou=Users,dc=example,dc=com";
            $search_result = ldap_search($ldap_connection, $base_dn, $ldap_search_filter);

            if ($search_result) {
                $entries = ldap_get_entries($ldap_connection, $search_result);
                if ($entries["count"] > 0) {
                    $user_entry = $entries[0];
                    $uid = $user_entry['uid'][0];
                    $_SESSION['access_token'] = "Some_generated_token"; // Ceci est à adapter pour les tokens Keycloak
                    echo "<script>window.location.href = 'dashboard.php';</script>";
                } else {
                    echo "Utilisateur introuvable.";
                }
            }
        }
    }
}
