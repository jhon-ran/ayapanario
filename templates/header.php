<?php
//url para conexión en hosting
$url_base = "/ayapanario/";
//url de base en localhost para concatenar en la navbar y evitar errores de redirección (dinámica)
//$url_base = "http://localhost/ayapanario/";

//si no existe la variable de sesión usuario_id, se redirige al login

if(!isset($_SESSION['loggedin'])){
    header('Location:'.$url_base.'index.php');
    exit();
}


//print_r($_SESSION['usuario_tipo'])
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <!-- estilo para personalizar -->
        <!--<link rel="stylesheet" href="../style.css">-->
        <link rel="stylesheet" href="../../style2.css">
        <!-- cdn JQuery v.3.7.1-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- cdn DataTables v.1.12.1 -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
        <!-- cdn para Sweet Alert 2, alertas de acciones -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark shadow-5-strong">
                <ul class="nav navbar-nav">
                    <?php if($_SESSION["tipo"]=="admin"):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base;?>secciones/palabras/">Palabras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base;?>secciones/usuarios/">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $url_base;?>cerrar.php">Cerrar sesión</a>
                    </li>
                    <?php elseif($_SESSION["tipo"]=="colaborador"):?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $url_base;?>secciones/palabras/">Palabras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $url_base;?>cerrar.php">Cerrar sesión</a>
                        </li>
                        <?php endif; ?>
                </ul>
            </nav>
        </header>         


        <main class="container">
            <!--Inicia código de mensaje de alerta cuando se borra registro-->
        <!--Si hay algo en el métod get-->
        <?php if(isset($_GET['mensaje'])){ ?>
            <!--se corre el mensaje de eliminado en línea 19-->
            <script>
                Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje'];?>"});
            </script>
        <?php } ?>
        <!--Termina código de mensaje de alerta cuando se borra registro-->
