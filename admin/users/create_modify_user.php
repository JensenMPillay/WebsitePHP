<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$rowUser = false;

$preQueryUserMod = $pdo->prepare('SELECT * FROM users WHERE user_id=?');
// $modProd = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_user'])) {
    $id = $_GET['modifier_id_user'];
    $preQueryUserMod->execute([$id]);
    $rowUser = $preQueryUserMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowUser) {
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
    <title>Utilisateurs</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_user.php" method="post">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire Utilisateurs</legend>
                <div class="mb-3">
                    <label for="nom" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="nom" name="nom" placeholder="Taper le nom" value="<?php
                                                                                                                                            if ($rowUser) {
                                                                                                                                                echo $rowUser['nom'];
                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label text-secondary-emphasis">Prenom</label>
                    <input type="text" aria-label="second_name" class="form-control" id="prenom" name="prenom" placeholder="Taper le prenom" value="<?php
                                                                                                                                                    if ($rowUser) {
                                                                                                                                                        echo $rowUser['prenom'];
                                                                                                                                                    } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label text-secondary-emphasis">Mail</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Taper le mail" value="<?php
                                                                                                                        if ($rowUser) {
                                                                                                                            echo $rowUser['mail'];
                                                                                                                        } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary-emphasis">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Taper le mot de passe" required>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowUser) {
                                                                                                echo $rowUser['user_id'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
    <!-- Main -->
</body>