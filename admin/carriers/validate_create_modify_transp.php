<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$insert = $pdo->prepare("INSERT INTO transporteurs(nom, delay, country, zone) VALUES(?, ?, ?, ?)");
$update = $pdo->prepare("UPDATE transporteurs SET nom = ?, delay = ?, country = ?, zone = ? WHERE transp_id = ?");

$errors = [];

if (isset($_POST['nom']) && isset($_POST['delay']) && isset($_POST['country']) && isset($_POST['zone'])) {
    $nom = $_POST['nom'];
    $delay = $_POST['delay'];
    $country = $_POST['country'];
    $zone = $_POST['zone'];
    if (!is_string($nom)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_numeric($delay)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Delai' correctement.</span><br>";
    }
    if (!is_string($country)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Pays' correctement.</span><br>";
    }
    if (!is_string($zone)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Zone' correctement.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $update->execute([$nom, $delay, $country, $zone, $mod_id]);
            header('Location:/website/admin/index.php#transporteurs');
        } else {
            $insert->execute([$nom, $delay, $country, $zone]);
            header('Location:/website/admin/index.php#transporteurs');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}

?>