<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$select = $pdo->prepare('SELECT * FROM users WHERE mail = ?');

$errors = [];

if (isset($_POST['mail']) && isset($_POST['password'])) {
    if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'mail' correctement.</span><br>";
    }
    $passwordVerif = trim($_POST['password']);
    $string = preg_match('@[a-zA-Z]@', $passwordVerif);
    $number    = preg_match('@[0-9]@', $passwordVerif);
    // $specialChars = preg_match('@[^\w]@', $password);
    if (!$string || !$number || strlen($passwordVerif) < 7) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'mot de passe' correctement.</span><br>";
    }
    if (empty($errors)) {
        $mail = $_POST['mail'];
        $select->execute([$mail]);
        $resultat = $select->fetch(PDO::FETCH_ASSOC);
        if (empty($resultat['user_id'])) {
            echo "<span style='color:red;'>Votre adresse mail n'est pas enregistré.</span><br>";
            echo "<a href='connexion.php'>Revenir sur la page de Connexion </a><br>";
            echo "<a href='inscription.php'>Aller sur la page d'Inscription</a><br>";
        }
        if (!empty($resultat['user_id'])) {
            $passwordHash = $resultat['password'];
            if (password_verify($passwordVerif, $passwordHash)) {
                $_SESSION['user_id'] = $resultat['user_id'];
                $_SESSION['nom'] = $resultat['nom'];
                $_SESSION['prenom'] = $resultat['prenom'];
                header('Location:/website/index.php');
            } else {
                echo "<span style='color:red;'>Votre mot de passe est erroné.</span><br>";
                echo "<a href='connexion.php'>Revenir sur la page de Connexion </a><br>";
                echo "<a href='inscription.php'>Aller sur la page d'Inscription</a><br>";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='connexion.php'>Revenir sur la page de Connexion</a><br>
<?php }
}

?>