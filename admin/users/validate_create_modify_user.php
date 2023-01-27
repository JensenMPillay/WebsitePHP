<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$select = $pdo->prepare('SELECT * FROM users WHERE mail = ?');
$insert = $pdo->prepare("INSERT INTO users(user_id, nom, prenom, mail, password) VALUES(?, ?, ?, ?, ?)");
$update = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, mail = ?, password = ? WHERE user_id = ?");


$errors = [];


if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['password'])) {
    if (!ctype_alpha($_POST['nom'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'nom' correctement.</span><br>";
    }
    if (!ctype_alpha($_POST['prenom'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'prenom' correctement.</span><br>";
    }
    if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'mail' correctement.</span><br>";
    }
    $passwordVerif = trim($_POST['password']);
    $string = preg_match('@[a-zA-Z]@', $passwordVerif);
    $number    = preg_match('@[0-9]@', $passwordVerif);
    // $specialChars = preg_match('@[^\w]@', $password);
    if (!$string || !$number || strlen($passwordVerif) < 7) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'mot de passe' correctement.</span><br>";
    } else {
        $password = password_hash($passwordVerif, PASSWORD_DEFAULT);
    }
    if (empty($errors)) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $user_id = uniqid();
        $mod_id = $_POST['mod_id'];
        $select->execute([$mail]);
        $resultat = $select->fetch(PDO::FETCH_ASSOC);
        if ($mod_id != "") {
            $update->execute([$nom, $prenom, $mail, $password, $mod_id]);
            header('Location:/website/admin/index.php#users');
        } else {
            if (!empty($resultat['user_id'])) {
                echo "<span style='color:red;'>Votre adresse mail est déjà enregistré.</span><br>";
                echo "<a href='/website/admin/index.php'>Revenir sur la page Index</a><br>";
                exit();
            }
            $insert->execute([$user_id, $nom, $prenom, $mail, $password]);
            header('Location:/website/admin/index.php#users');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}
?>