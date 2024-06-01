<?php 
include("../../bd.php"); 
//se inicializa variable de sesión
session_start();

//******Inicia código para recibir registro******
//Para verificar que se envía un id
if(isset($_GET['txtID'])){
        //Si esta variable existe, se asigna ese valor, de lo contrario se queda
        $txtID = (isset($_GET['txtID']))?$_GET['txtID']:$_GET['txtID'];
        //Se prepara sentencia para editar dato seleccionado (id)
        //se ejecuta subconsulta y se asigna a alias 'grmatical' para recuperar categoria de tabla categorias
        $sentencia = $conexion->prepare("SELECT *,
        (SELECT categoria FROM categorias WHERE categorias.id = palabras.id_categoria limit 1) as gramatical
         FROM palabras WHERE id=:id");
        //Asignar los valores que vienen del método GET (id seleccionado por params)
        $sentencia->bindParam(":id",$txtID);
        //Se ejecuta la sentencia con el valor asignado para borrar
        $sentencia->execute();
        //Popular el formulario con los valores de 1 registro
        $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        //Asignar los valores que vienen del formulario (POST)
        $ayapaneco = $registro["ayapaneco"];
        $afi = $registro["afi"];
        //$id_categoria = $registro["id_categoria"];
        $significado = $registro["significado"];
        $ejemplo_aya = $registro["ejemplo_aya"];
        $ejemplo_esp = $registro["ejemplo_esp"];
        $raiz = $registro["raiz"];
        $id_pronunciacion = $registro["id_pronunciacion"];
        //print_r($registro);

        //Para obtener nombre de categorias
        //$sentencia = $conexion->prepare("SELECT * FROM categorias WHERE id=:id");
        //$sentencia->bindParam(":id",$id_categoria);
        //$sentencia->execute();
        //$lista_categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        //print_r($lista_categorias);
}
//******Termina código para recibir registro******
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
    <title><?php echo $ayapaneco;?></title>
</head>

<body>
    <audio id="sound"></audio>
    <div class="container">
        <div class="search-box">
            <input type="text" placeholder="Busca palabra" id="inp-word" />
            <button id="search-btn">Buscar</button>
        </div>
        <div class="result" id="result">
            <div class='word'>
                <h3><?php echo $ayapaneco;?></h3>
                <button onclick='playSound()'><i class='fas fa-volume-up'></i></button>
            </div>
            <div class='details'>
                <p><?php echo $registro['gramatical']?></p>
                <p>/<?php echo $afi;?>/</p>
                <p>R-> <?php echo $raiz;?></p>
            </div>
        <p class='word-meaning'><?php echo $significado;?></p>
        <p class='word-example'><?php echo $ejemplo_aya;?></p>
        <p class='word-example'><?php echo $ejemplo_esp;?></p>
        </div>
        <a name="" id="" href="index.php" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
    </div>

</body>

</html>