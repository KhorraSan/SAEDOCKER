<?php

session_start();
if (isset($_SESSION['.K]=h{g8;n!P\CED'])) {
    
      $_SESSION['.K]=h{g8;n!P\CED'] = array();
        
      session_destroy();
        
      echo "<script>
      window.location.href = 'index.php';
      </script>";
}
// logout.php

// Inclure la configuration de Keycloak
require("config/keycloack.php");

// Vérifier si l'utilisateur est connecté (token d'accès présent dans la session)
if (isset($_SESSION['access_token'])) {
    // Supprimer le token d'accès de la session
    unset($_SESSION['access_token']);
    session_destroy();
    $logoutUrl = getKeycloakLogoutUrl();
    header("Location: $logoutUrl");
}
?>
