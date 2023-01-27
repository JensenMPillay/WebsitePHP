<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$rowArticle = false;

$preQueryArticleMod = $pdo->prepare('SELECT * FROM articles WHERE id_article = ?');
// $modProd = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_article'])) {
    $id = $_GET['modifier_id_article'];
    $preQueryArticleMod->execute([$id]);
    $rowArticle = $preQueryArticleMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowArticle) {
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
    <title>Article</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_article.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire Article</legend>
                <div class="mb-3">
                    <label for="name_article" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="name_article" name="name_article" placeholder="Taper le Nom" value="<?php
                                                                                                                                                            if ($rowArticle) {
                                                                                                                                                                echo $rowArticle['name_article'];
                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="img_article" class="form-label text-secondary-emphasis">Image</label>
                    <?php
                    if ($rowArticle) { ?>
                        <br>
                        <img src="/website/uploads/<?php echo $rowArticle['img_article']; ?>" width="50" height="50">
                        <br>
                    <?php
                    } ?>
                    <input type="file" aria-label="second_name" class="form-control" id="img_article" name="img_article" placeholder="Choisir son fichier" value="<?php
                                                                                                                                                                    if ($rowArticle) {
                                                                                                                                                                        echo $rowArticle['img_article'];
                                                                                                                                                                    } ?>" <?php
                                                                                                                                                                            if (!$rowArticle) {
                                                                                                                                                                                echo "required";
                                                                                                                                                                            } ?>>
                </div>
                <div class="mb-3">
                    <label for="desc_article" class="form-label text-secondary-emphasis">Description</label>
                    <input type="textarea" aria-label="second_name" class="form-control" id="desc_article" name="desc_article" placeholder="Taper la Description" value="<?php
                                                                                                                                                                            if ($rowArticle) {
                                                                                                                                                                                echo $rowArticle['desc_article'];
                                                                                                                                                                            } ?>" required>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowArticle) {
                                                                                                echo $rowArticle['id_article'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
</body>

<!-- Main -->