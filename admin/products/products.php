<?php

$respProducts = $pdo->query('SELECT * FROM products INNER JOIN categories ON products.fk_category_id = categories.category_id ORDER BY id_product');
$products = $respProducts->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" id="products">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Produits</h2>
        </div>
    </div>
    <div class="row">
        <table class="table text-secondary-emphasis border border-light mt-5">
            <thead class="text-bg-light">
                <tr style="vertical-align:middle;">
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix</th>
                    <th scope="col">TVA</th>
                    <th scope="col">Categories</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/products/create_modify_prod.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $product['id_product']; ?></th>
                        <td><?php echo $product['name_product']; ?></td>
                        <td><img src="/website/uploads/<?php echo $product['img_product'] ?>" width="50" height="50"></td>
                        <td><?php echo $product['desc_product']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['tax']; ?></td>
                        <td><?php echo $product['category_name']; ?></td>
                        <td class="d-flex justify-content-end mt-3">
                            <button type="button" onclick="window.location.href = '/website/admin/products/create_modify_prod.php?modifier_id_prod=<?php echo $product['id_product'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_prod=<?php echo $product['id_product'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>