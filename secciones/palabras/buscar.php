<?php
//Importar conexión a BD
include("../../bd.php"); 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../style3.css">
    <title>Dictionary App</title>
</head>

<body>
    <audio id="sound"></audio>
    <div class="container">
        <div class="search-box">
            <input type="text" placeholder="Escribe palabra" id="inp-word" />
            <button id="search-btn">Buscar</button>
        </div>
        <div class="result" id="result"></div>
    </div>

    <script src="../../js/buscar.js"></script>

</body>

</html>