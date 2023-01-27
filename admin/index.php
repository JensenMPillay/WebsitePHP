<?php
require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");
$connected = false;

$preQueryUserDel = $pdo->prepare('SELECT * FROM users WHERE user_id=?');
$delUser = $pdo->prepare("DELETE FROM users WHERE user_id=?");


if (isset($_GET['supprimer_id_user'])) {
    $id = $_GET['supprimer_id_user'];
    $preQueryUserDel->execute([$id]);
    $row = $preQueryUserDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $delUser->execute([$id]);
    }
    header('Location:index.php#users');
}

$preQueryAdresseDel = $pdo->prepare('SELECT * FROM adresses WHERE adress_id=?');
$delAdresse = $pdo->prepare("DELETE FROM adresses WHERE adress_id=?");


if (isset($_GET['supprimer_id_adresse'])) {
    $adressId = $_GET['supprimer_id_adresse'];
    $preQueryAdresseDel->execute([$adressId]);
    $row = $preQueryAdresseDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $delAdresse->execute([$adressId]);
    }
    header('Location:index.php#adresses');
}

$preQueryTranspDel = $pdo->prepare('SELECT * FROM transporteurs WHERE transp_id=?');
$delTransp = $pdo->prepare("DELETE FROM transporteurs WHERE transp_id=?");


if (isset($_GET['supprimer_id_transp'])) {
    $id = $_GET['supprimer_id_transp'];
    $preQueryTranspDel->execute([$id]);
    $row = $preQueryTranspDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $delTransp->execute([$id]);
    }
    header('Location:index.php#transporteurs');
}

$preQueryProdDel = $pdo->prepare('SELECT * FROM products WHERE id_product=?');
$delProd = $pdo->prepare("DELETE FROM products WHERE id_product=?");


if (isset($_GET['supprimer_id_prod'])) {
    $id = $_GET['supprimer_id_prod'];
    $preQueryProdDel->execute([$id]);
    $row = $preQueryProdDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        unlink("../uploads/" . $row['img_product']);
        $delProd->execute([$id]);
    }
    header('Location:index.php#products');
}

$preQuerySliderDel = $pdo->prepare('SELECT * FROM slider WHERE id_slider=?');
$delSlider = $pdo->prepare("DELETE FROM slider WHERE id_slider=?");


if (isset($_GET['supprimer_id_slider'])) {
    $id = $_GET['supprimer_id_slider'];
    $preQuerySliderDel->execute([$id]);
    $row = $preQuerySliderDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        unlink("../uploads/" . $row['img_slider']);
        $delSlider->execute([$id]);
    }
    header('Location:index.php#slider');
}

$preQueryArticleDel = $pdo->prepare('SELECT * FROM articles WHERE id_article=?');
$delArticle = $pdo->prepare("DELETE FROM articles WHERE id_article=?");


if (isset($_GET['supprimer_id_article'])) {
    $id = $_GET['supprimer_id_article'];
    $preQueryArticleDel->execute([$id]);
    $row = $preQueryArticleDel->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        unlink("../uploads/" . $row['img_article']);
        $delArticle->execute([$id]);
    }
    header('Location:index.php#articles');
}

if (isset($_SESSION['user_id'])) {
    $connected = true;
}
if (!$connected) { ?>
    <div class="container">
        <div class="row">
            <div class="col d-flex">
                <a type="button" href=<?php echo ("/Website/connexion/connexion.php") ?> class=" btn btn-info mx-auto my-5">Se connecter</a>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col d-flex">
        <a type="button" href=<?php echo ("/Website/connexion/deconnexion.php") ?> class=" btn btn-danger mx-auto my-5">Deconnexion</a>
    </div>
    <!-- Main -->
    <div id="main" class="container">
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/users/users.php");
        ?>
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/adresses/adresses.php");
        ?>
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/carriers/carriers.php");
        ?>
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/products/products.php");
        ?>
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/slider/slider.php");
        ?>
        <?php include_once("$_SERVER[DOCUMENT_ROOT]/Website/admin/articles/articles.php");
        ?>
    </div>

<?php } ?>

<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php"); ?>