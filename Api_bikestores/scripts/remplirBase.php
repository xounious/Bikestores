<?php

// Connexion à la base de données
$servername = "mysql.info.unicaen.fr:3306";
$username = "vallee211";
$password = "eo5Ahpamaighieph";
$dbname = "vallee211_8";

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Chemin du fichier SQL contenant les requêtes
$file = 'remplirBase.sql';

// Vérification de l'existence du fichier
if (!file_exists($file)) {
    die("Le fichier SQL n'existe pas.");
}

// Lecture du fichier SQL
$sql = file_get_contents($file);

// Exécution des requêtes SQL
if ($conn->multi_query($sql) === TRUE) {
    echo "Les requêtes SQL ont été exécutées avec succès.";
} else {
    echo "Erreur lors de l'exécution des requêtes SQL : " . $conn->error;
}

// Fermeture de la connexion
$conn->close();

?>
