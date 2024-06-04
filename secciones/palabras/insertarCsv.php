<?php
//Importar conexión a BD
include("../../bd.php"); 
// Connect to the database
//$pdo = new PDO("mysql:host=localhost;dbname=database", "username", "password");

// Open the CSV file
$file = fopen("dictionary.csv", "r");

// Loop through each row in the CSV file
while (($data = fgetcsv($file, 1000, ","))!== false) {
    // Prepare the SQL query
    $stmt = $conexion->prepare("INSERT INTO palabras (ayapaneco, variante, significado, raiz) VALUES (:ayapaneco, :variante, :significado, :raiz)");

    // Bind parameters
    $stmt->bindParam(':ayapaneco', $data[1]);
    $stmt->bindParam(':variante', $data[2]);
    $stmt->bindParam(':significado', $data[0]);
    $stmt->bindParam(':raiz', $data[3]);


    // Execute the query
    $stmt->execute();
}

// Close the CSV file
fclose($file);

// Close the PDO connection
$pdo = null;

?>