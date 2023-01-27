<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$rowTransp = false;

$preQueryTranspMod = $pdo->prepare('SELECT * FROM transporteurs WHERE transp_id=?');
// $modProd = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_transp'])) {
    $id = $_GET['modifier_id_transp'];
    $preQueryTranspMod->execute([$id]);
    $rowTransp = $preQueryTranspMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowTransp) {
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
    <title>Transporteur</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_transp.php" method="post">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire Transporteurs</legend>
                <div class="mb-3">
                    <label for="nom" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="nom" name="nom" placeholder="Taper le Nom" value="<?php
                                                                                                                                            if ($rowTransp) {
                                                                                                                                                echo $rowTransp['nom'];
                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="delay" class="form-label text-secondary-emphasis">Delai</label>
                    <input type="text" aria-label="second_name" class="form-control" id="delay" name="delay" placeholder="Taper le Delai" value="<?php
                                                                                                                                                    if ($rowTransp) {
                                                                                                                                                        echo $rowTransp['delay'];
                                                                                                                                                    } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label text-secondary-emphasis">Pays</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Taper le Prix" value="<?php
                                                                                                                            if ($rowTransp) {
                                                                                                                                echo $rowTransp['country'];
                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="zone" class="form-label text-secondary-emphasis">Zone</label>
                    <input type="text" class="form-control" id="zone" name="zone" placeholder="Taper la TVA" value="<?php
                                                                                                                    if ($rowTransp) {
                                                                                                                        echo $rowTransp['zone'];
                                                                                                                    } ?>" required>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowTransp) {
                                                                                                echo $rowTransp['transp_id'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
    <!-- Main -->
</body>