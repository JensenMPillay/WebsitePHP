<?php
session_start();
require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$insert = $pdo->prepare("INSERT INTO products(name_product,img_product, desc_product, price, tax, fk_category_id) VALUES(?, ?, ?, ?, ?, ?)");
$update = $pdo->prepare("UPDATE products SET name_product = ?, img_product = ?, desc_product = ?, price = ?, tax = ?, fk_category_id = ? WHERE id_product = ?");

$errors = [];
if (isset($_POST['name_product']) && empty($_FILES['img_product']['name']) && isset($_POST['desc_product']) && isset($_POST['price']) && isset($_POST['tax'])) {
    $name_product = $_POST['name_product'];
    $desc_product = $_POST['desc_product'];
    $price = $_POST['price'];
    $tax = $_POST['tax'];
    $cat_id = $_POST['cat_id'];
    if (!is_string($name_product)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_product)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    if (!is_string($price)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Prix' correctement.</span><br>";
    }
    if (!is_string($tax)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'TVA' correctement.</span><br>";
    }
    if (empty($cat_id)) {
        $errors[] = "<span style='color:red;'>Le champ 'Categorie' ne doit pas être vide.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $update = $pdo->prepare("UPDATE products SET name_product = ?, desc_product = ?, price = ?, tax = ?, fk_category_id = ? WHERE id_product = ?");
            $update->execute([$name_product, $desc_product, $price, $tax, $cat_id, $mod_id]);
            header('Location:/website/admin/index.php#products');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
    <?php }
}

if (isset($_POST['name_product']) && !empty($_FILES['img_product']['name']) && isset($_POST['desc_product']) && isset($_POST['price']) && isset($_POST['tax'])) {
    $name_product = $_POST['name_product'];
    $desc_product = $_POST['desc_product'];
    $price = $_POST['price'];
    $tax = $_POST['tax'];
    $cat_id = $_POST['cat_id'];
    if (!is_string($name_product)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Nom' correctement.</span><br>";
    }
    if (!is_string($desc_product)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Description' correctement.</span><br>";
    }
    if (!is_string($price)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'Prix' correctement.</span><br>";
    }
    if (!is_string($tax)) {
        $errors[] = "<span style='color:red;'>Veuillez remplir le champ 'TVA' correctement.</span><br>";
    }
    if (empty($cat_id)) {
        $errors[] = "<span style='color:red;'>Le champ 'Categorie' ne doit pas être vide.</span><br>";
    }
    $nom_fichier = $_FILES['img_product']['name'];
    $type_fichier = $_FILES['img_product']['type'];
    $taille_fichier = $_FILES['img_product']['size'];
    $dossier_temp = $_FILES['img_product']['tmp_name'];
    $dossier_final = "../../uploads/" . $nom_fichier; // Chemin d'accès du dossier d'uploads + nom fichier
    $extension_fichier = strchr($nom_fichier, '.');
    $extension_valid = ['.pdf', '.PDF', '.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG'];
    if (!in_array($extension_fichier, $extension_valid)) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " n'est pas au bon format</span><br>";
    }
    if ($taille_fichier >= 7000000) {
        $errors[] = "<span style='color:red;'>Le fichier " . $nom_fichier . " dépasse 7MB.</span><br>";
    }
    if (empty($errors)) {
        $mod_id = $_POST['mod_id'];
        if ($mod_id != "") {
            $respProduct = $pdo->query("SELECT * FROM products WHERE id_product = $mod_id");
            $product = $respProduct->fetch(PDO::FETCH_ASSOC);
            unlink("../../uploads/" . $product['img_product']);
            $update->execute([$name_product, $nom_fichier, $desc_product, $price, $tax, $cat_id, $mod_id]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#products');
        } else {
            $insert->execute([$name_product, $nom_fichier, $desc_product, $price, $tax, $cat_id]);
            move_uploaded_file($dossier_temp, $dossier_final);
            header('Location:/website/admin/index.php#products');
        }
    } else {
        foreach ($errors as $error) {
            echo $error;
        } ?>
        <a href='/website/admin/index.php'>Revenir sur la page Index</a><br>
<?php }
}

?>