<?php
require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

if (isset($_SESSION['user_id'])) {
    header('Location:/website/index.php');
} else {
?>
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_inscription.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis">Inscription</legend>
                <div class="mb-3">
                    <label for="nom" class="form-label text-secondary-emphasis">Nom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="nom" name="nom" placeholder="Taper votre nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label text-secondary-emphasis">Prenom</label>
                    <input type="text" aria-label="first_name" class="form-control" id="prenom" name="prenom" placeholder="Taper votre prenom" required>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label text-secondary-emphasis">Email</label>
                    <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail" placeholder="Taper votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary-emphasis">Mot de passe</label>
                    <input type="password" minlength="7" class="form-control" id="password" name="password" placeholder="Taper votre mot de passe" required>
                </div>
                <div class="mb-3">
                    <input type="hidden" class="form-control invisible" id="id_user" name="id_user">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-info" name="submit">S'inscrire</button>
                    <div class="form-group text-center">
            </fieldset>
        </form>
    </div>
    <!-- Main -->
    <?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>
<?php
}
?>