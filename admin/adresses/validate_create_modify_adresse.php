<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$insert = $pdo->prepare("INSERT INTO adresses(adresse1, adresse2, code_postal, ville) VALUES(?, ?, ?, ?)");
$update = $pdo->prepare("UPDATE adresses SET adresse1 = ?, adresse2 = ?, code_postal = ?, ville = ? WHERE adress_id = ?");

$errors = [];

if (isset($_POST['adresse1']) && isset($_POST['adresse2']) && isset($_POST['code_postal']) && isset($_POST['ville'])) {
    $adresse1 = $_POST['adresse1'];
    $adresse2 = $_POST['adresse2'];
    $code_postal = $_POST['code_postal'];
    $ville = $_POST['ville'];
    if (!is_string($adresse1)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Adresse' correctement.</span><br>";
    }
    if (!is_string($adresse2)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Complement Adresse' correctement.</span><br>";
    }
    if (!is_string($code_postal)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Code Postal' correctement.</span><br>";
    }
    if (!is_string($ville)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Ville' correctement.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $update->execute([$adresse1, $adresse2, $code_postal, $ville, $mod_id]);
            header('Location:/website/admin/index.php#adresses');
        } else {
            $insert->execute([$adresse1, $adresse2, $code_postal, $ville]);
            header('Location:/website/admin/index.php#adresses');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}

?>