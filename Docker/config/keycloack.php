<?php
// 🔹 Définir une adresse IP manuelle pour l'hôte
$host_ip = '192.168.1.103';  // Remplace cette IP par l'adresse IP de ta machine hôte

// 🔹 Définir une variable pour le port de Keycloak (modifiable selon tes besoins)
$port_keycloak = 7080;  // Port de Keycloak

// 🔹 Définir une variable pour le port de redirection (modifiable selon tes besoins)
$port_redirect = 8000;  // Port pour la redirection (Dashboard)

// 🔹 Définir le chemin pour la redirection
$path_redirect = '/Docker/dashboard.php';
$path_logout = '/Docker/index.php' ;
// 🔹 Créer l'URL dynamique avec l'IP et le port
$host_keycloak = $host_ip . ':' . $port_keycloak;  // URL de base de Keycloak
$redirect_url = 'http://' . $host_ip . ':' . $port_redirect . $path_redirect; // URL de redirection
$logout_url = 'http://' . $host_ip . ':' . $port_redirect . $path_logout; // URL de logout
// 🔹 Configuration Keycloak
define('KEYCLOAK_BASE_URL', 'http://' . $host_keycloak);  // URL de base de Keycloak
define('REALM', 'my-realm');
define('CLIENT_ID', 'connexion');
define('CLIENT_SECRET', 'ZWdqTJ6AMn3ttud8KQih4BG5WPntiLCy');
define('REDIRECT_URI', $redirect_url); // Utilisation de l'IP et du port pour la redirection
define('LOGOUT_URI', $logout_url);
// 🔹 Fonction pour obtenir l'URL de connexion Keycloak dynamique
function getKeycloakLoginUrl() {
    return KEYCLOAK_BASE_URL . "/realms/" . REALM . "/protocol/openid-connect/auth"
        . "?client_id=" . CLIENT_ID
        . "&redirect_uri=" . urlencode(REDIRECT_URI)
        . "&response_type=code"
        . "&scope=openid";
}
function getKeycloakLogoutUrl() {
    return KEYCLOAK_BASE_URL . "/realms/" . REALM . "/protocol/openid-connect/logout"
        . "?client_id=" . CLIENT_ID
        . "&post_logout_redirect_uri=" . urlencode(LOGOUT_URI);
}
// 🔹 Fonction pour échanger le code d'autorisation contre un access token
function getAccessTokenFromCode($code) {
    $url = KEYCLOAK_BASE_URL . "/realms/" . REALM . "/protocol/openid-connect/token";
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => REDIRECT_URI,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
    ];

    // Envoi de la requête à Keycloak pour récupérer le token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);
    curl_close($ch);

    // Vérification de la réponse
    $json = json_decode($response, true);

    if (isset($json['access_token'])) {
        return $json['access_token'];  // Retourner le token si la requête est un succès
    } else {
        return null;  // Retourner null en cas d'erreur
    }
}

?>
