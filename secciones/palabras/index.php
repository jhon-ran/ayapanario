<?php
//Importar conexión a BD
include("../../bd.php"); 
//se inicializa variable de sesión
session_start();

/*query para insertar palabra con valores de tablas relacionales
INSERT INTO `palabras` (`id`, `ayapaneco`, `afi`, `id_categoria`, `significado`, `ejemplo_aya`, `ejemplo_esp`, `raiz`, `id_pronunciacion`, `fecha_creacion`) VALUES (NULL, 'ku\'udyi', 'kuʔudʲi', '4', 'aguacate', 'ku\'udyi gwüü', 'aguacate bueno', 'ku\'uti', '1', current_timestamp());

query con inserción con campo pronunciacion vacio
INSERT INTO `palabras` (`id`, `ayapaneco`, `afi`, `id_categoria`, `significado`, `ejemplo_aya`, `ejemplo_esp`, `raiz`, `id_pronunciacion`, `fecha_creacion`) VALUES (NULL, 'tam', 'tam', '3', 'amargo', 'tam alaxa', 'naranja amarga', 'tam', NULL, current_timestamp());
*/

/*query para actualizar pronunciacion
UPDATE `palabras` SET `id_pronunciacion` = '2' WHERE `palabras`.`id` = 1;

para seleccionar pronuncacion de tabla pronunciaciones
SELECT * FROM `diccionario`.`pronunciaciones` WHERE `id` = 2

para insertar relación de palabra con campo
INSERT INTO `palabra_campos` (`id`, `id_palabra`, `id_campo`) VALUES (NULL, '1', '5');
*/

//******Inicia código para mostrar todos los registros******
//Se prepara sentencia para seleccionar todos los datos 
$sentencia = $conexion->prepare("SELECT * FROM palabras");
$sentencia->execute();
$palabras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//Para probar que se esté leyendo todos los datos de la tabla, descomentar
//print_r($palabras);
//******Termina código para mostrar todos los registros******
?>
<!-- Se llama el header desde los templates-->
<!-- ../../ sube 2 niveles para poder acceder al folder de templates desde la posición actual-->
<?php include("../../templates/header.php"); ?>

<h2>Palabras</h2>

<!--Nuevo look inicia-->
<div class="card">
  <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button" >Nueva palabra</a>
  </div>
  <div class="card-body">
    <div class="table-responsive-sm">
      <table class="table table-hover" id="tabla_id">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Palabra</th>
            <th scope="col">Categoria</th>
            <th scope="col">Significado</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($palabras as $registro){ ?>
          <tr class="responsive-sm">
            <td scope="row"><?php echo $registro['id']?></td>
            <td><?php echo $registro['ayapaneco']?></td>
            <td><?php echo $registro['id_categoria']?></td>
            <td><?php echo $registro['significado']?></td>
            <td>
              <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']?>" role="button">Editar</a></div>
              <!--Se sustituye el link del registro por la función SweatAlert para confirmar borrado-->
              <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']?>);">Eliminar</a>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
  <!--Nuevo look termina-->


<!-- Se llama el footer desde los templates-->
<!-- ../../ sube 2 niveles para poder acceder al folder de templates desde la posición actual-->
<?php include("../../templates/footer.php"); ?>