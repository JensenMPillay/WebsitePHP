<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$select = $pdo->prepare('SELECT * FROM users WHERE mail = ?');
$insert = $pdo->prepare("INSERT INTO users(user_id, nom, prenom, mail, password) VALUES(?, ?, ?, ?, ?)");

$errors = [];

if (isset($_POST['mail']) && isset($_POST['password'])) {
    if (!ctype_alpha($_POST['nom'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'sujet' correctement.</span><br>";
    }
    if (!ctype_alpha($_POST['prenom'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'message' correctement.</span><br>";
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
        $select->execute([$mail]);
        $resultat = $select->fetch(PDO::FETCH_ASSOC);
        if (!empty($resultat['user_id'])) {
            echo "<span style='color:red;'>L'adresse $mail est déjà utilisé.</span><br>";
            echo "<a href='connexion.php'>Aller à la page de Connexion</a><br>";
        } else {
            $insert->execute([$user_id, $nom, $prenom, $mail, $password]);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            header('Location:/website/index.php');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='inscription.php'>Revenir sur la page d'Inscription</a>
<?php }
}
?>