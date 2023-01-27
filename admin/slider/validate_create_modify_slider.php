<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$insert = $pdo->prepare("INSERT INTO slider(name_slider,img_slider, desc_slider) VALUES(?, ?, ?)");
$update = $pdo->prepare("UPDATE slider SET name_slider = ?, img_slider = ?, desc_slider = ? WHERE id_slider = ?");

$errors = [];
if (isset($_POST['name_slider']) && empty($_FILES['img_slider']['name']) && isset($_POST['desc_slider'])) {
    $name_slider = $_POST['name_slider'];
    $desc_slider = $_POST['desc_slider'];
    if (!is_string($name_slider)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_slider)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $update = $pdo->prepare("UPDATE slider SET name_slider = ?, desc_slider = ? WHERE id_slider = ?");
            $update->execute([$name_slider, $desc_slider, $mod_id]);
            header('Location:/website/admin/index.php#slider');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
    <?php }
}

if (isset($_POST['name_slider']) && !empty($_FILES['img_slider']['name']) && isset($_POST['desc_slider'])) {
    $name_slider = $_POST['name_slider'];
    $desc_slider = $_POST['desc_slider'];
    if (!is_string($name_slider)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_slider)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    $nom_fichier = $_FILES['img_slider']['name'];
    $type_fichier = $_FILES['img_slider']['type'];
    $taille_fichier = $_FILES['img_slider']['size'];
    $dossier_temp = $_FILES['img_slider']['tmp_name'];
    $dossier_final = "../../uploads/" . $nom_fichier; // Chemin d'accès du dossier d'uploads + nom fichier
    $extension_fichier = strchr($nom_fichier, '.');
    $extension_valid = ['.pdf', '.PDF', '.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'];
    if (!in_array($extension_fichier, $extension_valid)) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " n'est pas au bon format</span><br>";
    }
    if ($taille_fichier >= 7000000) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " dépasse 7MB.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $respSlider = $pdo->query("SELECT * FROM slider WHERE id_slider = $mod_id");
            $slider = $respSlider->fetch(PDO::FETCH_ASSOC);
            unlink("../../uploads/" . $slider['img_slider']);
            $update->execute([$name_slider, $nom_fichier, $desc_slider, $mod_id]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#slider');
        } else {
            $insert->execute([$name_slider, $nom_fichier, $desc_slider]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#slider');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}

?>