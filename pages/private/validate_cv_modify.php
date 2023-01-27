<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");

$update = $pdo->prepare("UPDATE curriculums SET cv_name = ?, cv_doc = ?, user_id = ? WHERE cv_id= ?");

$errors = [];

if (isset($_POST['cv_name']) && isset($_FILES) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cv_name = $_POST['cv_name'];
    $nom_fichier = $_FILES['cv_doc']['name'];
    $type_fichier = $_FILES['cv_doc']['type'];
    $taille_fichier = $_FILES['cv_doc']['size'];
    $dossier_temp = $_FILES['cv_doc']['tmp_name'];
    $dossier_final = '../../uploads/' . $nom_fichier; // Chemin d'accès du dossier d'uploads + nom fichier
    $extension_fichier = strchr($nom_fichier, '.');
    $extension_valid = ['.pdf', '.PDF', '.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'];
    if (!is_string($_POST['cv_name'])) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!in_array($extension_fichier, $extension_valid)) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " n'est pas au bon format</span><br>";
    }
    if ($taille_fichier >= 7000000) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " dépasse 7MB.</span><br>";
    }
    if (empty($errors)) {
        $update->execute([$cv_name, $nom_fichier, $user_id, $_GET['modifier_id']]);
        move_uploaded_file($dossier_temp, $dossier_final);
        header('Location:cv.php');
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='cv.php'>Revenir sur la page CV</a><br>
<?php }
}

?>