<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$rowSlider = false;

$preQuerySliderMod = $pdo->prepare('SELECT * FROM slider WHERE id_slider = ?');
// $modProd = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_slider'])) {
    $id = $_GET['modifier_id_slider'];
    $preQuerySliderMod->execute([$id]);
    $rowSlider = $preQuerySliderMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowSlider) {
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
    <title>Slider</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_slider.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire Slider</legend>
                <div class="mb-3">
                    <label for="name_slider" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="name_slider" name="name_slider" placeholder="Taper le Nom" value="<?php
                                                                                                                                                            if ($rowSlider) {
                                                                                                                                                                echo $rowSlider['name_slider'];
                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="img_slider" class="form-label text-secondary-emphasis">Image</label>
                    <?php
                    if ($rowSlider) { ?>
                        <br>
                        <img src="/website/uploads/<?php echo $rowSlider['img_slider']; ?>" width="50" height="50">
                        <br>
                    <?php
                    } ?>
                    <input type="file" aria-label="second_name" class="form-control" id="img_slider" name="img_slider" placeholder="Choisir son fichier" value="<?php
                                                                                                                                                                if ($rowSlider) {
                                                                                                                                                                    echo $rowSlider['img_slider'];
                                                                                                                                                                } ?>" <?php
                                                                                                                                                                        if (!$rowSlider) {
                                                                                                                                                                            echo "required";
                                                                                                                                                                        } ?>>
                </div>
                <div class="mb-3">
                    <label for="desc_slider" class="form-label text-secondary-emphasis">Description</label>
                    <input type="textarea" aria-label="second_name" class="form-control" id="desc_slider" name="desc_slider" placeholder="Taper la Description" value="<?php
                                                                                                                                                                        if ($rowSlider) {
                                                                                                                                                                            echo $rowSlider['desc_slider'];
                                                                                                                                                                        } ?>" required>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowSlider) {
                                                                                                echo $rowSlider['id_slider'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
</body>

<!-- Main -->