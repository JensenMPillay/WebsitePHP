<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$update = $pdo->prepare("UPDATE contacts SET sujet = ?, message = ?, fichier = ? WHERE contact_id= ?");

$errors = [];

if (isset($_POST['sujet']) && is_string($_POST['sujet']) && isset($_POST['message']) && is_string($_POST['message']) && isset($_FILES)) {
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];
    $nom_fichier = $_FILES['fichier']['name'];
    $type_fichier = $_FILES['fichier']['type'];
    $taille_fichier = $_FILES['fichier']['size'];
    $dossier_temp = $_FILES['fichier']['tmp_name'];
    $dossier_final = '../../uploads/' . $nom_fichier; // Chemin d'accès du dossier d'uploads + nom fichier
    $extension_fichier = strchr($nom_fichier, '.');
    $extension_valid = ['.pdf', '.PDF', '.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'];
    if (!is_string($_POST['sujet'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'sujet' correctement.</span><br>";
    }
    if (!is_string($_POST['message'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'message' correctement.</span><br>";
    }
    if (!in_array($extension_fichier, $extension_valid)) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " n'est pas au bon format</span><br>";
    }
    if ($taille_fichier >= 3000000) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " dépasse 7MB.</span><br>";
    }
    if (empty($errors)) {
        $update->execute([$sujet, $message, $nom_fichier, $_GET['modifier_id']]);
        move_uploaded_file($dossier_temp, $dossier_final);
        header('Location:contact.php');
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='contact.php'>Revenir sur la page Contact</a><br>
<?php }
}

?>