<?php

define('DB_NAME', 'projet');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

$pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD); //Connexion à la base de donnée avec Serveur/Nom BDD/USER/PW
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //EXCEPTION POUR DEBOGAGE
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // SECURITE : REQUETE BDD MySQL PREPARATION AU LIEU DE PDO

// $pdo->query : SELECT
// $pdo->prepare : UPDATE, INSERT, DELETE with ? 
// $pdo->exec : ? = []
// $pdo->fetchAll(PDO::FETCH_ASSOC) : TABLEAU
// $pdo->fetchAll(PDO::FETCH_OBJ) : OBJECTS