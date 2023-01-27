<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");


$preQuery = $pdo->prepare('SELECT * FROM contacts WHERE contact_id=?');

if (isset($_GET['modifier_id'])) {
    $id = $_GET['modifier_id'];
    $preQuery->execute([$id]);
    $row = $preQuery->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header('Location:contact.php');
    }
}

?>
<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
<!-- Main -->
<div id="main" class="container">
    <form action="validate_contact_modify.php?modifier_id=<?php echo $_GET['modifier_id'] ?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend class="text-center text-secondary-emphasis">Contact</legend>
            <div class="mb-3">
                <label for="sujet" class="form-label text-secondary-emphasis">Sujet</label>
                <input type="text" aria-label="first_name" class="form-control" id="sujet" name="sujet" value="<?php
                                                                                                                if ($row) {
                                                                                                                    echo $row['sujet'];
                                                                                                                } ?>" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label text-secondary-emphasis">Message</label>
                <input type="textarea" class="form-control" id="message" name="message" value="<?php if ($row) {
                                                                                                    echo $row['message'];
                                                                                                } ?>" required>
            </div>
            <div class="mb-3">
                <label for="fichier" class="form-label text-secondary-emphasis">Pièce Jointe</label>
                <input type="file" class="form-control" id="fichier" name="fichier" value="<?php if ($row) {
                                                                                                echo $row['fichier'];
                                                                                            } ?>" required>
            </div>
            <div class="form-group text-center"> <button type="submit" class="btn btn-info" name=" submit">Modifier</button>
            </div>
        </fieldset>
    </form>
</div>

<!-- Main -->
<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>