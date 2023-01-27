<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

$respProducts = $pdo->prepare('SELECT * FROM products INNER JOIN categories ON products.fk_category_id = categories.category_id WHERE id_product = ?');

$showCard = false;

if (!empty($_GET)) {
    if (!empty(trim($_GET['id_product']))) {
        if (ctype_alnum($_GET['id_product'])) {
            $respProducts->execute([$_GET['id_product']]);
            $product = $respProducts->fetch(PDO::FETCH_ASSOC);
            if (!empty($product)) {
                $showCard = true;
            }
        }
    }
}

?>

<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
<!-- Main -->
<div id="main" class="container">
    <!-- Bloc Cards -->
    <div class="row text-bg-dark text-secondary-emphasis border-light m-5">
        <?php if ($showCard) {
            $id_product = $product['id_product'];
            $name_product = $product['name_product'];
            $img_product = $product['img_product'];
            $price_product = $product['price'];
            $desc_product = $product['desc_product'];
            $category_name = $product['category_name'];
        ?>
            <div class="col-6">
                <img src="/website/uploads/<?php echo $img_product ?>" class="img-fluid">
            </div>
            <div class="col-6">
                <h2><?php echo $name_product ?></h2>
                <p><?php echo $price_product ?> €</p>
                <p><?php echo $desc_product ?></p>
                <a href="#"><button class="btn btn-primary">Add To Cart</button></a>
            </div>

        <?php
        } else { ?>
            <h5 class="text-center text-secondary-emphasis">Il n'y aucun résultat.</h5>
        <?php } ?>
    </div>
</div>
<!-- Bloc Cards -->

</div>
<!-- Main -->
<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>