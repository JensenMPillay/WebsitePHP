<?php

$respProducts = $pdo->query('SELECT * FROM products INNER JOIN categories ON products.fk_category_id = categories.category_id ORDER BY id_product'); //
$products = $respProducts->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Bloc Cards -->
<div class="cardslist mt-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center text-secondary-emphasis">Flowers & Fruits & Glasses</h2>
                <p class="text-center text-secondary-emphasis">Check our beautiful collection of flowers, fruits and glasses.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($products as $product) {
                $key_product = array_search($product, $products);
                $id_product = $product['id_product'];
                $name_product = $product['name_product'];
                $img_product = $product['img_product'];
                $desc_product = $product['desc_product'];
                $category_name = $product['category_name'];
            ?>
                <div class="card col-12 col-sm-6 col-md-4 col-lg-3 m-2 text-bg-dark text-secondary-emphasis border-light" style="width: 18rem;">
                    <a class="link text-decoration-none text-secondary-emphasis" href="/website/pages/category/category.php?search=&cat_search=<?php echo $category_name; ?>">
                        <div class="card-header d-flex justify-content-center"><?php echo $category_name; ?></div>
                    </a>
                    <img src="/website/uploads/<?php echo $img_product ?>" class="card-img-top mt-3" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name_product ?></h5>
                        <p class="card-text"><?php echo $desc_product ?></p>
                        <a href="/website/pages/product/product.php?id_product=<?php echo $id_product; ?>" class="btn btn-light">Show More</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Bloc Cards -->