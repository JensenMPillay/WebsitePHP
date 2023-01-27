<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/website/config/config.php");
$rowAdresse = false;

$preQueryAdresseMod = $pdo->prepare('SELECT * FROM adresses WHERE adress_id=?');
// $modAdresse = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_adresse'])) {
    $adressId = $_GET['modifier_id_adresse'];
    $preQueryAdresseMod->execute([$adressId]);
    $rowAdresse = $preQueryAdresseMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowAdresse) {
        header('Location:/website/admin/index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Adresse</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_adresse.php" method="post">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire d'Adresse</legend>
                <div class="mb-3">
                    <label for="adresse1" class="form-label text-secondary-emphasis">Adresse</label>
                    <input type="text" aria-label="first_name" class="form-control" id="adresse1" name="adresse1" placeholder="Taper votre adresse" value="<?php
                                                                                                                                                            if ($rowAdresse) {
                                                                                                                                                                echo $rowAdresse['adresse1'];
                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="adresse2" class="form-label text-secondary-emphasis">Complement Adresse</label>
                    <input type="text" aria-label="second_name" class="form-control" id="adresse2" name="adresse2" placeholder="Taper votre adresse" value="<?php
                                                                                                                                                            if ($rowAdresse) {
                                                                                                                                                                echo $rowAdresse['adresse2'];
                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="code_postal" class="form-label text-secondary-emphasis">Code Postal</label>
                    <input type="text" minlength="5" maxlength="5" class="form-control" id="code_postal" name="code_postal" placeholder="Taper votre code postal" value="<?php
                                                                                                                                                                            if ($rowAdresse) {
                                                                                                                                                                                echo $rowAdresse['code_postal'];
                                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ville" class="form-label text-secondary-emphasis">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" placeholder="Taper votre ville" value="<?php
                                                                                                                            if ($rowAdresse) {
                                                                                                                                echo $rowAdresse['ville'];
                                                                                                                            } ?>" required>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowAdresse) {
                                                                                                echo $rowAdresse['adress_id'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
</body>

<!-- Main -->