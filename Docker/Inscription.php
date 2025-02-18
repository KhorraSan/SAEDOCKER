<?php

session_start();

require("config/creationdb.php");
require("config/fonction.php");

if(isset($_SESSION['.K]=h{g8;n!P\CED']))
{
    if(!empty($_SESSION['.K]=h{g8;n!P\CED']))
    {
        echo "<script>
				window.location.href = 'dashboard.php';
        </script>";
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
    <title>Optilocaux - Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="header-left-panel" >
                <div class="logo">
                    <img src="logo.png" alt="RoomFinder Logo">
                    <a href="index.php"><h4>Optilocaux</h4></a>
                </div>
            </div>
            <div class="box-form-left-panel">
                <div class="connecter" >
                    <h2>Inscription</h2>
                </div>
                <form action="#" method="POST">
                    <div class="input-group-inscription">
                        <label for="nom">Nom Complet</label>
                        <input type="text" id="nom" name="nomcomplet" placeholder="nom complet" required>
                    </div>
                    <div class="input-group-inscription">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="email@example.com" required>
                    </div>
                    <div class="input-group-inscription-password">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="********" onkeyup="checkPasswordStrength(this.value)" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <div class="Bar" id="5password-strength">
                        <progress id="avancement-bar" value="0" max="100" style="display:none;"></progress>
                    </div>
                    <div class="contraite">
                        <p>- Au moins une lettre minuscule </p>
                        <p>- Au moins une lettre majuscule </p>
                        <p>- Au moins un chiffre</p>
                        <p>- Au moins un caratère spécial </p>
                    </div>
                    <div class="input-group-inscription-password">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="-confirm" name="confirmpassword" placeholder="********" required>
                        <span class="toggle-password">👁</span>
                    </div>
                    <input type="hidden" name="ConfirmTest" id="ConfirmTest" maxlength="5" style="display:none;" >
                    <button type="submit" name="submitinscription" class="btn-primary btn-inscription">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

<script>

function checkPasswordStrength(password) {
    var ava = document.getElementById("avancement-bar");
    var length = password.length; 

    var containsNumbers = /\d/.test(password);

    var containsUpperCase = /[A-Z]/.test(password);

    var containsLowerCase = /[a-z]/.test(password);

    var containsSpecialChars = /[!@#$%^&*()\-_=+{};:,<.>]/.test(password);

    if(length >= 8 && containsNumbers == true && containsLowerCase == true && containsUpperCase == true && containsSpecialChars == true ){
      document.getElementById("ConfirmTest").value="true"; 
      ava.style.display = 'Block';
      ava.className = "green";
      ava.value = 100;
    }else if(length >= 4 && containsNumbers == true || containsLowerCase == true && containsUpperCase == true || containsSpecialChars == true){
      document.getElementById("ConfirmTest").value="true"; 
      ava.style.display = 'Block';
      ava.className = "orange";
      ava.value = 66;
    }else if(length >= 2 || containsNumbers == true || containsLowerCase == true || containsUpperCase == true || containsSpecialChars == true){
      document.getElementById("ConfirmTest").value="false"; 
      ava.className = "red";
      ava.style.display = 'Block';
      ava.value = 33;
    }else{
      ava.style.display = 'none';
      ava.value = 0;
    }
}
</script>

<?php
if(isset($_POST['submitinscription'])) {

	if(!empty($_POST['nomcomplet']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])) {

            $nomcomplet = htmlspecialchars(strip_tags($_POST['nomcomplet'])) ;
            $email = htmlspecialchars(strip_tags($_POST['email']));
			$newPassword = htmlspecialchars(strip_tags($_POST['password'])) ;
			$confirmPassword = htmlspecialchars(strip_tags($_POST['confirmpassword']));

        if(($newPassword === $confirmPassword) AND ($_POST['ConfirmTest'] == "true") ) {

            Inscription($nomcomplet,$email,hash(algo: 'sha256',data: $newPassword));
            echo "<script>window.location.href = 'index.php';</script>";

        } else {
            echo "<script> 
						document.querySelector('.box-form-error').style.display = 'block';
            document.querySelector('.box-form-error').innerHTML = 'Les mots de passe doivent être identiques.';
					</script>";
        }
	}
}
?>
