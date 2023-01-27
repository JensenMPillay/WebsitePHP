<?php

$respArticles = $pdo->query('SELECT * FROM articles');
$articles = $respArticles->fetchAll(PDO::FETCH_ASSOC);

function formatRelativeDate($date_from_db)
{
    $timestamp = strtotime($date_from_db);
    $diff = time() - $timestamp;
    $time = array( // seconds per unit
        'an' => 31556926,
        'moi' => 2629744,
        'semaine' => 604800,
        'jour' => 86400,
        'heure' => 3600,
        'minute' => 60,
        'seconde' => 1
    );
    $output = '';
    if ($diff < 0) {
        $diff = abs($diff);
        $output = "Dans ";
    } else {
        $output = "Il y a ";
    }
    foreach ($time as $unit => $value) {
        if ($diff >= $value) {
            $count = floor($diff / $value);
            $diff -= $count * $value;
            $output .= $count . ' ' . $unit . ($count == 1 ? ', ' : 's, ');
        }
    }
    return substr($output, 0, -2);
}
?>
<!-- Blog -->
<div class="blog mt-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center">Blog</h2>
                <p class="text-center">Nos Articles du moment</p>
            </div>
            <div class="container">
                <div class="card-group row">
                    <?php foreach ($articles as $article) {
                        $key_article = array_search($article, $articles);
                        $id_article = $article['id_article'];
                        $name_article = $article['name_article'];
                        $img_article = $article['img_article'];
                        $desc_article = $article['desc_article'];
                        $date_article = $article['date_article'];
                    ?>
                        <div id=<?php echo $id_article ?> class="card col-12 col-sm-6 col-md-4 col-lg-3">
                            <img src="/website/uploads/<?php echo $img_article ?>" class="card-img-top my-2" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $name_article ?></h5>
                                <p class="card-text"><?php echo $desc_article ?></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><?php echo formatRelativeDate($date_article) ?> </small>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog -->