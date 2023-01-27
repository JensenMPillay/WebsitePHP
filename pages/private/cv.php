<?php
require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:/website/index.php');
} else {
    $reponse = $pdo->prepare('SELECT * FROM curriculums INNER JOIN users ON curriculums.user_id = users.user_id WHERE users.user_id = ?');
    $reponse->execute([$_SESSION['user_id']]);
    // $reponse = $pdo->query("SELECT * FROM curriculums");
    $curriculums = $reponse->fetchAll(PDO::FETCH_ASSOC);
    $preQuery = $pdo->prepare('SELECT * FROM curriculums WHERE cv_id=?');
    $del = $pdo->prepare("DELETE FROM curriculums WHERE cv_id=?");

    if (isset($_GET['supprimer_id'])) {
        $id = $_GET['supprimer_id'];
        $preQuery->execute([$id]);
        $row = $preQuery->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $del->execute([$id]);
        }
        header('Location:/website/pages/private/cv.php');
    }


?>
    <?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_cv.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis text-center">Curriculum Vitae</legend>
                <div class="mb-3">
                    <label for="cv_name" class="form-label text-secondary-emphasis">Sujet</label>
                    <input type="text" aria-label="first_name" class="form-control" id="cv_name" name="cv_name" placeholder="Taper votre sujet" required>
                </div>
                <div class="mb-3">
                    <label for="cv_doc" class="form-label text-secondary-emphasis">Pièce Jointe</label>
                    <input type="file" class="form-control" id="cv_doc" name="cv_doc" required>
                </div>
                <div class="form-group text-center"> <button type="submit" class="btn btn-info" name=" submit">Télécharger</button>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <table class="table text-secondary-emphasis border border-light mt-5">
                <thead class="text-bg-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Fichier</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($curriculums) == 0) {
                    ?>
                        <tr>
                            <th scope="row" colspan="3" class="text-center">Vous n'avez aucun fichier uploadé.</th>
                        </tr>
                        <?php
                    } else {
                        foreach ($curriculums as $cv) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $cv['cv_id']; ?></th>
                                <td><?php echo $cv['cv_name']; ?></td>
                                <td><a href="./uploads/<?php echo $cv['cv_doc']; ?>" target="_blank"><?php echo $cv['cv_doc']; ?></a></td>
                                <td class="d-flex justify-content-end">
                                    <button type="button" onclick="window.location.href = 'cv_modify.php?modifier_id=<?php echo $cv['cv_id'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                                    <button type="button" onclick="window.location.href = 'cv.php?supprimer_id=<?php echo $cv['cv_id'] ?>';" class=" btn btn-danger">Supprimer</button>
                                </td>
                            </tr>
                    <?php
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Main -->
    <?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>
<?php } ?>