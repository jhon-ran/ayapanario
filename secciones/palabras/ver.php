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
        $variante = $registro["variante"];
        $afi = $registro["afi"];
        $gramatical = $registro["gramatical"];
        $significado = $registro["significado"];
        $ejemplo_aya = $registro["ejemplo_aya"];
        $ejemplo_esp = $registro["ejemplo_esp"];
        $raiz = $registro["raiz"];
        $id_pronunciacion = $registro["id_pronunciacion"];
        //print_r($registro);

        //se hace una subconsulta y se asigna a un alias 'campo semnántico' para obtener el nombre del campo asociado a la palabra en la tabla de unión palabra_campos
        $sentencia = $conexion->prepare("SELECT *,
        (SELECT nombre FROM campos WHERE campos.id = palabra_campos.id_campo AND palabra_campos.id_palabra = :id) as campo_semantico
        FROM palabra_campos");
        //Se asigna el valor del id de palabra para indicar que es el que se necesita comparar
        $sentencia->bindParam(":id",$txtID);
       
        $sentencia->execute();
        $campo_semantico = $sentencia->fetchAll(PDO::FETCH_ASSOC);

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
            <!-- Bootstrap CSS v5.2.1 -->
            <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="../../style3.css">
    <title><?php echo $ayapaneco;?></title>
</head>

<body>
    <audio id="sound"></audio>
    <div class="container">

        <div class="result" id="result">
            <div class='word'>
                <h3><?php echo $ayapaneco;?></h3>
                <!--Valitacion si columna variante está vacia o contiene *-->
                <?php if ($variante != '*') { ?>
                    <h3><?php echo $variante;?></h3>
                <?php }?>

                <button onclick='playSound()'><i class='fas fa-volume-up'></i></button>
            </div>
            <div class='details'>
                <p><?php echo $registro['gramatical']?></p>           
                <p> /<?php echo $afi;?>/</p>
                <p>-> <?php echo $raiz;?></p>
            </div>
        <p class='word-meaning'><?php echo $significado;?></p>
        <p class='word-example'><?php echo $ejemplo_aya;?></p>
        <p class='word-example'><?php echo $ejemplo_esp;?></p>
        </div>
        <p><small>Campo semantico:</small></p>
            <!--Loop para obtener los valores de la subconsulta de la tabla palabra_campos-->
            <?php foreach($campo_semantico as $registro){ ?>
                <p><small><?php echo $registro['campo_semantico']?></small></p>
            <?php }?>
            <a name="" id="" href="index.php" role="button"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a> Regresar
    </div>

<!--
<br>
        <div class="card" mx-auto" style="width: 60%;">
            <div class="card-header">
                <div class="search-box">
                    <input type="text" placeholder="Busca palabra" id="inp-word" />
                    <button id="search-btn">Buscar</button>
                    </div>
            </div>
                <div class="card-body">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $ayapaneco;?></h5>
                            <p class="card-text"><?php echo $significado?> </p>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?php echo $gramatical;?></li>
                            <li class="list-group-item"><?php echo $ejemplo_aya;?></li>
                            <li class="list-group-item"><?php echo $ejemplo_esp;?></li>

                           
                                <li class="list-group-item">
                                    <?php foreach($campo_semantico as $registro){ ?>
                                        <?php echo $registro['campo_semantico']?>
                                    <?php }?>
                                </li>
                        </ul>
                        <div class="card-body">
                            <a href="index.php" class="card-link"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                        </div>
                </div>
        </div>
    -->


</body>

<!-- Bootstrap JavaScript Libraries -->
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"
></script>

</html>