<?php
require_once("$_SERVER[DOCUMENT_ROOT]/Website/config/config.php");
$tableData = [];
// Modèle requête de recherche
// $select = $pdo->prepare('SELECT * from products WHERE name_product LIKE ? OR desc_product LIKE ?');


if (!empty(trim($_POST['search']))) {
    // Création tableau $words à partir de la recherche pour chaque word
    $words = explode(" ", trim($_POST['search']));
    // Parcours sur le tableau pour intégrer chaque word dans une requête
    for ($i = 0; $i < count($words); $i++) {
        $reqWord[$i] = "(desc_product LIKE '%" . $words[$i] . "%' OR name_product LIKE '%" . $words[$i] . "%')";
    }
    // Requête de recherche avec l'assemblage des requêtes pour chaque mot accompagné d'un "AND"
    $select = $pdo->prepare("SELECT * from products WHERE " . implode(" AND ", $reqWord));
    $select->execute();
    // Récupération des résultats
    $resultats = $select->fetchAll(PDO::FETCH_ASSOC);
    // Ajout des résultats dans le tableau des Datas
    $tableData[] = $resultats;
    // Modèle Object des résultats
    $resultatsTable = ["donnees" => $tableData];
    echo json_encode($resultatsTable);
} else {
    $resultatsTable = ["donnees" => [""]];
    echo json_encode($resultatsTable);
}
