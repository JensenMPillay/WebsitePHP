<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header('Location:/website/index.php');
} else {
    $preQuery = $pdo->prepare('SELECT * FROM curriculums WHERE cv_id=?');

    if (isset($_GET['modifier_id'])) {
        $id = $_GET['modifier_id'];
        $preQuery->execute([$id]);
        $row = $preQuery->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            header('Location:/website/pages/private/cv.php');
        }
    }


?>
    <?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
    <!-- Main -->
    <div id="main" class="container">
        <form action="validate_cv_modify?modifier_id=<?php echo $_GET['modifier_id'] ?>.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend class="text-secondary-emphasis text-center">Curriculum Vitae</legend>
                <div class="mb-3">
                    <label for="cv_name" class="form-label text-secondary-emphasis">Sujet</label>
                    <input type="text" aria-label="first_name" class="form-control" id="cv_name" name="cv_name" value="<?php
                                                                                                                        if ($row) {
                                                                                                                            echo $row['cv_name'];
                                                                                                                        } ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cv_doc" class="form-label text-secondary-emphasis">Pièce Jointe</label>
                    <input type="file" class="form-control" id="cv_doc" name="cv_doc" value="<?php
                                                                                                if ($row) {
                                                                                                    echo $row['cv_doc'];
                                                                                                } ?>" required>
                </div>
                <div class="form-group text-center"> <button type="submit" class="btn btn-info" name=" submit">Modifier</button>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- Main -->
    <?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>
<?php } ?>