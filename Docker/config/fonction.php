<?php

function Inscription($nom, $email, $password){
    if(require("connexion.php")) {
        $req = $conn->prepare("INSERT INTO membres (nom, email, password) VALUES (?, ?, ?)");

        $req->execute(array($nom, $email, $password));

        $req->closeCursor();
    }
}


function connexionAdmin($checkingEmail, $checkingPassword) {
    if(require("connexion.php")) {
        $req = $conn->prepare("SELECT * FROM membres WHERE email=?");
        $req->bindParam(1, $checkingEmail);

        if ($req->execute()) {
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $stored_password = $user['password'];
                if ($checkingPassword === $stored_password) {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $errorInfo = $req->errorInfo();
            return false;
        }
    }  
}
/*
function afficherInfosEtudiant($id) {
	if(require("connexion.php")) {
		$req=$conn->prepare("SELECT * FROM etudiants WHERE id=?");

        $req->execute(array($id));

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        $req->closeCursor();
        
        return $data;
	}
}

function delete($id) {
    if(require("connexion.php")) {
        $req = $conn->prepare("DELETE FROM etudiants WHERE id=?");

        $req->execute(array($id));

        $req->closeCursor();
    }
}

function displayAllInfos() {
    if(require("connexion.php")) {
        $req=$conn->prepare("SELECT * FROM etudiants ORDER BY id");

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        $req->closeCursor();

        return $data;
    }
}

function displayAllFiles() {
    if(require("connexion.php")) {
        $req=$conn->prepare("SELECT * FROM fichiers ORDER BY id DESC");

        $req->execute();

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        $req->closeCursor();

        return $data;
    }
}

function ajouterFichier($cheminFichier, $nomFichier, $tailleFichier) {
    if(require("connexion.php")) {
        $req = $conn->prepare("INSERT INTO fichiers (cheminFichier, nomFichier, tailleFichier) VALUES (?, ?, ?)");

        $req->execute(array($cheminFichier, $nomFichier, $tailleFichier));

        $req->closeCursor();
    }
}

function connexionAdmin($checkingEmail, $checkingPassword) {
    if(require("connexion.php")) {
        $req = $conn->prepare("SELECT * FROM admins WHERE email=?");
        $req->bindParam(1, $checkingEmail);

        if ($req->execute()) {
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $stored_password = $user['password'];
                if ($checkingPassword === $stored_password) {
                    return $user;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $errorInfo = $req->errorInfo();
            return false;
        }
    }  
}

function checkResetPasswd($checkingEmail){
    if(require("connexion.php")) {
        $req = $conn->prepare("SELECT * FROM admins WHERE email=?");
        $req->bindParam(1, $checkingEmail);

        if ($req->execute()) {
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return true;
            } else {
                return false;
            }
        } else {
            $errorInfo = $req->errorInfo();
            return false;
        }
    } else {
        return false;
    }  
}

function generateToken($token_hash, $expiration, $checkingEmail){
    if(require("connexion.php")) {
        $req = $conn->prepare("UPDATE admins SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email=?");
    
        $req->execute(array($token_hash, $expiration, $checkingEmail));
    
        $req->closeCursor();

        return true;
    } 
}

function deleteToken($token_hash){
    if(require("connexion.php")) {
        $req = $conn->prepare("UPDATE admins SET reset_token_hash = ?, reset_token_expires_at = ? WHERE reset_token_hash=?");
    
        $req->execute(array(NULL, NULL, $token_hash));
    
        $req->closeCursor();
    } 
}

function lectureToken($token_hash) {
	if(require("connexion.php")) {
		$req=$conn->prepare("SELECT * FROM admins WHERE reset_token_hash=?");

        $req->execute(array($token_hash));

        $data = $req->fetchAll(PDO::FETCH_OBJ);

        $req->closeCursor();

        return $data;

	}
}

function modifierMdpAdmin($password, $token_hash) {
    if(require("connexion.php")) {
        $req = $conn->prepare("UPDATE admins SET password = ? WHERE reset_token_hash=?");
    
        $req->execute(array($password, $token_hash));
    
        $req->closeCursor();

        return true;
    }
}

function deleteTables() {
    if(require("connexion.php")) {
        $req=$conn->prepare("DROP TABLE etudiants");
        $req->execute();

        $req=$conn->prepare("DROP TABLE fichiers");
        $req->execute();
    }
}*/

?>