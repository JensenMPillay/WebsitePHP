<?php
$reqPages = $pdo->query('SELECT * FROM pages'); // On exécute une requête visant à récupérer les catégories
$pages = $reqPages->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['user_id'])) {
    array_pop($pages);
}
?>
<!-- Navbar  -->
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a style="width:5%" href="/website/index.php"><img src="/website/assets/logo_mini.png" class="img-fluid navbar-brand" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($pages as $page) {
                ?>
                    <li class="nav-item">
                        <a id=<?php echo $page['page_id'] ?> class="nav-link" href=<?php echo ("/website/") . $page['page_path'] ?>><?php echo $page['page_name'] ?></a>
                    </li>
                <?php
                } ?>
            </ul>
            <form id="search_bar" class="d-flex mb-0" role="search">
                <input id="search" class="form-control me-2" type="search" name="search" placeholder="Rechercher" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Rechercher</button>
            </form>
            <?php
            if (!isset($_SESSION['user_id'])) {
            ?>
                <form class="d-flex ms-2 mb-0" action="/website/connexion/inscription.php" method="post" role="connect">
                    <button class="btn btn-outline-success" type="submit">Inscription</button>
                </form>
                <form class="d-flex ms-2 mb-0" action="/website/connexion/connexion.php" method="post" role="connect">
                    <button class="btn btn-outline-success" type="submit">Connexion</button>
                </form>
            <?php
            } else {
            ?>
                <span class="text-secondary-emphasis ms-1"><?php echo $_SESSION['prenom'] ?></span>
                <span class="text-secondary-emphasis ms-1"><?php echo $_SESSION['nom'] ?></span>
                <form class="d-flex ms-2 mb-0" action="/website/connexion/deconnexion.php" method="post" role="disconnect">
                    <button class="btn btn-outline-danger" type="submit">Deconnexion</button>
                </form>
            <?php
            }
            ?>

        </div>
    </div>
</nav>
<div class="container text-secondary-emphasis">
    <div id="results-container" class="row justify-content-center">
    </div>
</div>
<!-- Navbar  -->