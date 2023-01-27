<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

$respCategories = $pdo->query('SELECT * FROM categories');
$categories = $respCategories->fetchAll(PDO::FETCH_ASSOC);

$respProducts = $pdo->prepare('SELECT * FROM products INNER JOIN categories ON products.fk_category_id = categories.category_id WHERE category_name LIKE ? ORDER BY id_product');

$showCardsList = false;
$showResultMsg = false;

if (!empty($_GET)) {
    if (!empty(trim($_GET['search']))) {
        if (ctype_alpha($_GET['search'])) {
            $respProducts->execute(["%" . $_GET['search'] . "%"]);
            $products = $respProducts->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($products)) {
                $showCardsList = true;
            } else {
                $showResultMsg = true;
            }
        } else {
            $showResultMsg = true;
        }
    }

    if (!empty(trim($_GET['cat_search']))) {
        if (ctype_alpha($_GET['cat_search'])) {
            $respProducts->execute(["%" . $_GET['cat_search'] . "%"]);
            $products = $respProducts->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($products)) {
                $showCardsList = true;
            } else {
                $showResultMsg = true;
            }
        }
    }
}

?>

<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
<!-- Main -->
<div id="main" class="container">
    <form id="search_form" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="m-5" role="search">
        <fieldset>
            <legend class="text-secondary-emphasis">Recherche Catégorie</legend>
            <div class="mb-3">
                <input id="search" class="form-control me-2" type="search" name="search" placeholder="Rechercher" aria-label="Search">
            </div>
            <div class="mb-3">
                <label for="cat_search" class="form-label text-secondary-emphasis">Categorie</label>
                <select class="form-select" aria-label="Default select example" name="cat_search">
                    <option value="" selected>Choisir la Catégorie</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group text-center"><button class="btn btn-outline-primary" type="submit">Rechercher</button></div>
        </fieldset>
    </form>
    <!-- Bloc Cards -->
    <div class="cardslist mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="text-center text-secondary-emphasis">
                        <?php if ($showCardsList) {
                            if ($_GET['cat_search']) {
                                echo $_GET['cat_search'];
                            } elseif ($_GET['search']) {
                                echo $_GET['search'];
                            }
                        }
                        ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <?php if ($showCardsList) {
                    foreach ($products as $product) {
                        $key_product = array_search($product, $products);
                        $id_product = $product['id_product'];
                        $name_product = $product['name_product'];
                        $img_product = $product['img_product'];
                        $desc_product = $product['desc_product'];
                        $category_name = $product['category_name'];
                ?>
                        <div class="card col-12 col-sm-6 col-md-4 col-lg-3 m-2 text-bg-dark text-secondary-emphasis border-light" style="width: 18rem;">
                            <div class="card-header d-flex justify-content-center"><?php echo $category_name ?></div>
                            <img src="/website/uploads/<?php echo $img_product ?>" class="card-img-top mt-3" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $name_product ?></h5>
                                <p class="card-text"><?php echo $desc_product ?></p>
                                <a href="/website/pages/product/product.php?id_product=<?php echo $id_product; ?>" class="btn btn-light">Show More</a>
                            </div>
                        </div>
                    <?php }
                }
                if ($showResultMsg) { ?>
                    <h5 class="text-center text-secondary-emphasis">Il n'y aucun résultat.</h5>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Bloc Cards -->
</div>
<!-- Main -->
<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>