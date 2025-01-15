<?php

session_start();

require("config/creationdb.php");
require("config/fonction.php");

if(isset($_SESSION['.K]=h{g8;n!P\CED']))
{
    if(!empty($_SESSION['.K]=h{g8;n!P\CED']))
    {
        if ($_SESSION['.K]=h{g8;n!P\CED']['acces'] == "Autoriser") {
            echo "<script>
            window.location.href = 'dashboard.php';
            </script>";
        }

    }
}

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
            <div class="header-left-panel" >
                <div class="logo">
                    <img src="logo.png" alt="RoomFinder Logo">
                    <a href="index.php"><h4>FL</h4></a>
                </div>
            </div>
            <div class="box-form-left-panel">
                <div class="connecter" >
                    <h2>Se connecter</h2>
                    <h4><a href="#" id="Interne">Interne</a><a href="#" id="Externe">Externe</a></h4>
                </div>
                <form action="#" method="POST" id="InterneForm" style="display:block;" >
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="EmailAdress" placeholder="email@example.com" required>
                    </div>
                    <div class="input-group password-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="Password" placeholder="********" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <div class="forgot-password">
                        <h4><a href="Inscription.php">Inscrivez-vous</a> ou <a href="#">Mot de passe oublié ?</a></h4>
                    </div>
                    <button type="submit" name="submitFormSignIn" class="btn-primary">Se connecter</button>
                </form>
                <form action="#" method="POST" id="ExterneForm" style="display:none;" >
                    <div class="input-group">
                        <label for="emailExterne">E-mail</label>
                        <input type="email" id="emailExterne" name="EmailAdressExterne" placeholder="emailexterne@example.com" required>
                    </div>
                    <div class="input-group password-group">
                        <label for="passwordExterne">Mot de passe</label>
                        <input type="password" id="passwordExterne" name="PasswordExterne" placeholder="********" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <div class="forgot-password">
                        <h4><a href="#" style="color: #007BFF;" >Inscrivez-vous</a> ou <a href="#" style="color: #007BFF;" >Mot de passe oublié ?</a></h4>
                    </div>
                    <button type="submit" name="submitFormSignInExterne" class="btn-primary" style="background-color: #007BFF;" >Se connecter</button>
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
	if(isset($_POST['submitFormSignIn'])) {

		if(!empty($_POST['EmailAdress']) AND !empty($_POST['Password'])) {

			$checkingEmail = htmlspecialchars(strip_tags($_POST['EmailAdress'])) ;
			$checkingPassword = htmlspecialchars(strip_tags($_POST['Password']));

			$admin = connexionAdmin($checkingEmail,hash("sha256",$checkingPassword));
            
			if($admin) {
                $_SESSION['.K]=h{g8;n!P\CED'] = $admin;
                if ($_SESSION['.K]=h{g8;n!P\CED']['acces'] == "Autoriser") {
                    echo "<script>
                    window.location.href = 'dashboard.php';
                    </script>";
                }
            }

			} else {
				echo "<script> 
						document.querySelector('.box-form-error').style.display = 'block';
					</script>";
		}
	}

    if(isset($_POST['submitFormSignInExterne'])) {

        if (!empty($_POST['EmailAdressExterne']) AND !empty($_POST['PasswordExterne'])) {
            echo "OK";
            $email = $_POST['EmailAdressExterne'] ; // L'e-mail à rechercher
            $ldap_search_filter = "(mail=$email)";
            $ldap_admin_dn = "cn=admin,dc=example,dc=com";  // DN de l'administrateur LDAP


            // Connexion au serveur LDAP
            $ldap_connection = ldap_connect("ldap://ldap");
            ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            if (@ldap_bind($ldap_connection, $ldap_admin_dn, "adminpassword")) { // Remplacez par vos identifiants d'admin
            $base_dn = "ou=Users,dc=example,dc=com"; // Remplacez par votre base DN
            $search_result = ldap_search($ldap_connection, $base_dn, $ldap_search_filter);

            if ($search_result) {
                    $entries = ldap_get_entries($ldap_connection, $search_result);
                    if ($entries["count"] > 0) {
                    // On prend le premier utilisateur trouvé
                    $user_entry = $entries[0];

                    // Extraction de l'UID et du mot de passe
                    $uid = $user_entry["uid"][0] ?? "Non défini";
                    $password = $user_entry["userpassword"][0] ?? "Non défini";

                    if ($_POST['PasswordExterne'] == $password){
                        echo "<script>
                        window.location.href = 'dashboard.php';
                        </script>";
                    }

                    echo "</pre>";
                    } else {
                    echo "Aucun utilisateur trouvé avec cet e-mail.\n";
                    }
            } else {
                    echo "Erreur lors de la recherche LDAP.\n";
            }

            ldap_close($ldap_connection);
            } else {
            echo "Impossible de se connecter au serveur LDAP.\n";
            }
        }
    }

    if (isset($_POST['logoutButton'])) {

        if (isset($_SESSION['.K]=h{g8;n!P\CED'])) {
    
            $_SESSION['.K]=h{g8;n!P\CED'] = array();
        
            session_destroy();
        
            echo "<script>
                    window.location.href = '../index.php';
                </script>";
        }
    }
?>

