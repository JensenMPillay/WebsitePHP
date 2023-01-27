<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$date = date('Y-m-d H:i:s');
$insert = $pdo->prepare("INSERT INTO articles(name_article,img_article, desc_article, date_article) VALUES(?, ?, ?, ?)");
$update = $pdo->prepare("UPDATE articles SET name_article = ?, img_article = ?, desc_article = ?, date_article = ? WHERE id_article = ?");

$errors = [];
if (isset($_POST['name_article']) && empty($_FILES['img_article']['name']) && isset($_POST['desc_article'])) {
    $name_article = $_POST['name_article'];
    $desc_article = $_POST['desc_article'];
    if (!is_string($name_article)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_article)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $update = $pdo->prepare("UPDATE articles SET name_article = ?, desc_article = ?, date_article = ? WHERE id_article = ?");
            $update->execute([$name_article, $desc_article, $date, $mod_id]);
            header('Location:/website/admin/index.php#articles');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
    <?php }
}

if (isset($_POST['name_article']) && !empty($_FILES['img_article']['name']) && isset($_POST['desc_article'])) {
    $name_article = $_POST['name_article'];
    $desc_article = $_POST['desc_article'];
    if (!is_string($name_article)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_article)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    $nom_fichier = $_FILES['img_article']['name'];
    $type_fichier = $_FILES['img_article']['type'];
    $taille_fichier = $_FILES['img_article']['size'];
    $dossier_temp = $_FILES['img_article']['tmp_name'];
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
            $respArticle = $pdo->query("SELECT * FROM articles WHERE id_article = $mod_id");
            $article = $respArticle->fetch(PDO::FETCH_ASSOC);
            unlink("../../uploads/" . $article['img_article']);
            $update->execute([$name_article, $nom_fichier, $desc_article, $date, $mod_id]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#articles');
        } else {
            $insert->execute([$name_article, $nom_fichier, $desc_article, $date]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#articles');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}

?>