<?php
session_start();

require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$rowProd = false;

$respCategories = $pdo->query('SELECT * FROM categories');
$categories = $respCategories->fetchAll(PDO::FETCH_ASSOC);

$preQueryProdMod = $pdo->prepare('SELECT * FROM products INNER JOIN categories ON products.fk_category_id = categories.category_id AND id_product = ? ORDER BY id_product');
// $modProd = $pdo->prepare("DELETE FROM adresse WHERE id=?");


if (isset($_GET['modifier_id_prod'])) {
    $id = $_GET['modifier_id_prod'];
    $preQueryProdMod->execute([$id]);
    $rowProd = $preQueryProdMod->fetch(PDO::FETCH_ASSOC);
    if (!$rowProd) {
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
    <title>Produit</title>
</head>

<body class="bg-dark">
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_create_modify_prod.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis">Formulaire Produit</legend>
                <div class="mb-3">
                    <label for="name_product" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="name_product" name="name_product" placeholder="Taper le Nom" value="<?php
                                                                                                                                                            if ($rowProd) {
                                                                                                                                                                echo $rowProd['name_product'];
                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="img_product" class="form-label text-secondary-emphasis">Image</label>
                    <?php
                    if ($rowProd) { ?>
                        <br>
                        <img src="/website/uploads/<?php echo $rowProd['img_product']; ?>" width="50" height="50">
                        <br>
                    <?php
                    } ?>
                    <input type="file" aria-label="second_name" class="form-control" id="img_product" name="img_product" placeholder="Choisir son fichier" value="<?php
                                                                                                                                                                    if ($rowProd) {
                                                                                                                                                                        echo $rowProd['img_product'];
                                                                                                                                                                    } ?>" <?php
                                                                                                                                                                            if (!$rowProd) {
                                                                                                                                                                                echo "required";
                                                                                                                                                                            } ?>>
                </div>
                <div class="mb-3">
                    <label for="desc_product" class="form-label text-secondary-emphasis">Description</label>
                    <input type="textarea" aria-label="second_name" class="form-control" id="desc_product" name="desc_product" placeholder="Taper la Description" value="<?php
                                                                                                                                                                            if ($rowProd) {
                                                                                                                                                                                echo $rowProd['desc_product'];
                                                                                                                                                                            } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label text-secondary-emphasis">Prix</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Taper le Prix" value="<?php
                                                                                                                        if ($rowProd) {
                                                                                                                            echo $rowProd['price'];
                                                                                                                        } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tax" class="form-label text-secondary-emphasis">TVA</label>
                    <input type="text" class="form-control" id="tax" name="tax" placeholder="Taper la TVA" value="<?php
                                                                                                                    if ($rowProd) {
                                                                                                                        echo $rowProd['tax'];
                                                                                                                    } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cat_id" class="form-label text-secondary-emphasis">Categorie</label>
                    <select class="form-select" aria-label="Default select example" name="cat_id" required>
                        <?php
                        if ($rowProd) { ?>
                            <option value="<?php echo $rowProd['category_id'] ?>" selected><?php echo $rowProd['category_name'] ?></option>
                        <?php
                        } else { ?>
                            <option value="" selected>Choisir la Catégorie</option>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" value="<?php if ($rowProd) {
                                                                                                echo $rowProd['id_product'];
                                                                                            } ?>" readonly>
                <button type="submit" class="btn btn-dark" name="submit">Valider</button>
            </fieldset>
        </form>
    </div>
</body>

<!-- Main -->