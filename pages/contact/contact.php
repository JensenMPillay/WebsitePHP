<?php

require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/header.php");

$reponse = $pdo->query('SELECT * FROM contacts');
$contacts = $reponse->fetchAll(PDO::FETCH_ASSOC);
$del = $pdo->prepare("DELETE FROM contacts WHERE contact_id=?");
$preQuery = $pdo->prepare('SELECT * FROM contacts WHERE contact_id=?');
// $update = $pdo->prepare("UPDATE contacts SET sujet = ?,message = ?, ficchier = ? WHERE id = ?");

if (isset($_GET['supprimer_id'])) {
    $id = $_GET['supprimer_id'];
    $preQuery->execute([$id]);
    $row = $preQuery->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $del->execute([$id]);
    }
    header('Location:/website/pages/contact/contact.php');
}

?>

<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/navbar.php") ?>
<!-- Main -->
<div id="main" class="container">
    <form action="validate_contact.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend class="text-center text-secondary-emphasis">Contact</legend>
            <div class="mb-3">
                <label for="sujet" class="form-label text-secondary-emphasis">Sujet</label>
                <input type="text" aria-label="first_name" class="form-control" id="sujet" name="sujet" placeholder="Taper votre sujet" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label text-secondary-emphasis">Message</label>
                <input type="textarea" class="form-control" id="message" name="message" placeholder="Taper votre message" required>
            </div>
            <div class="mb-3">
                <label for="fichier" class="form-label text-secondary-emphasis">Pièce Jointe</label>
                <input type="file" class="form-control" id="fichier" name="fichier" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-info" name=" submit">Envoyer</button>
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
                    <th scope="col">Sujet</th>
                    <th scope="col">Message</th>
                    <th scope="col">Fichier</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($contacts as $contact) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $contact['contact_id']; ?></th>
                        <td><?php echo $contact['sujet']; ?></td>
                        <td><?php echo $contact['message']; ?></td>
                        <td><a href=" ./uploads/<?php echo $contact['fichier']; ?>" target="_blank"><?php echo $contact['fichier']; ?></a></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" onclick="window.location.href = 'contact_modify.php?modifier_id=<?php echo $contact['contact_id'] ?>';" class=" btn btn-warning me-2">Modifier</button>
                            <button type="button" onclick="window.location.href = 'contact.php?supprimer_id=<?php echo $contact['contact_id'] ?>';" class=" btn btn-danger">Supprimer</button>
                        </td>
                    <?php
                }
                    ?>
        </table>
    </div>
</div>
<!-- Main -->
<?php require_once("$_SERVER[DOCUMENT_ROOT]/website/includes/footer.php") ?>