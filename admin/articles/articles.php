<?php

$respArticles = $pdo->query('SELECT * FROM articles');
$articles = $respArticles->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" id="articles">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-secondary-emphasis">Articles</h2>
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
                    <th scope="col">Date</th>
                    <th scope="col" class="d-flex justify-content-end"><button type="button" onclick="window.location.href = '/website/admin/articles/create_modify_article.php';" class=" btn btn-primary mx-2">Ajouter</button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($articles as $article) {
                ?>
                    <tr style="vertical-align:middle;">
                        <th scope="row"><?php echo $article['id_article']; ?></th>
                        <td><?php echo $article['name_article']; ?></td>
                        <td><img src="/website/uploads/<?php echo $article['img_article'] ?>" width="50" height="50"></td>
                        <td><?php echo $article['desc_article']; ?></td>
                        <td><?php echo $article['date_article']; ?></td>
                        <td class="d-flex justify-content-end mt-3">
                            <button type="button" onclick="window.location.href = '/website/admin/articles/create_modify_article.php?modifier_id_article=<?php echo $article['id_article'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = '/website/admin/index.php?supprimer_id_article=<?php echo $article['id_article'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>