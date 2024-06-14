<!-- Importar conexión a BD-->
<?php include("../../bd.php"); 
//se inicializa variable de sesión
session_start();

if($_POST){
        //Array para guardar los errores
        $errores= array();

        //Validación: que exista la información enviada, lo vamos a igualar a ese valor,
        //de lo contratrio lo deja en blanco
        $ayapaneco = (isset($_POST["ayapaneco"])? $_POST["ayapaneco"]:"");
        $variante = (isset($_POST["variante"])? $_POST["variante"]:"");
        $afi = (isset($_POST["afi"])? $_POST["afi"]:"");
        $id_categoria = (isset($_POST["id_categoria"])? $_POST["id_categoria"]:"");
        $significado = (isset($_POST["significado"])? $_POST["significado"]:"");
        $ejemplo_aya = (isset($_POST["ejemplo_aya"])? $_POST["ejemplo_aya"]:"");
        $ejemplo_esp = (isset($_POST["ejemplo_esp"])? $_POST["ejemplo_esp"]:"");
        $raiz = (isset($_POST["raiz"])? $_POST["raiz"]:"");

        //Validar que la palabra en ayapaneco no esté vacia
        if (empty($ayapaneco)){
                $errores['ayapaneco']= "La palabra en ayapaneco es obligatoria";
        }
        //Validar si la palabra no tiene menos de 2 caracteres
        if (strlen($ayapaneco) < 2) {
                $errores['ayapaneco'] = "La palabra debe tener al menos 2 caracteres";
        }
        //Validar si la palabra no tiene más de 15 caracteres
        if (strlen($ayapaneco) > 15) {
                $errores['ayapaneco'] = "La palabra no puede tener más de 15 caracteres";
        }

        //******Inicia validación de de existencia de palabra en bd*****
        try {
                $conn = new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contrasena);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $ayapaneco = $_POST['ayapaneco'];
                // Consulta para ver si nombre de cupón ya existe en la base de datos
                $sql = "SELECT * FROM palabras WHERE ayapaneco = :ayapaneco";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':ayapaneco', $ayapaneco);
                $stmt->execute();
                
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                // Si el resultado es verdadero, el nombre ya existe y se muestra un mensaje de error
                if ($resultado) {
                        $errores['ayapaneco'] = "Ya existe esa palabra en ayapaneco";
                }
                
                } catch(PDOException $e) {
                echo "Error de conexión: ". $e->getMessage();
                }
        
                //******Termina validación de existencia de palabra en bd*****

        //Validar que la palabra en ayapaneco no esté vacia
        if (empty($significado)){
                $errores['significado']= "El significado es obligatorio";
        }
        //Validar si la palabra no tiene menos de 2 caracteres
        if (strlen($ayapaneco) < 2) {
                $errores['significado'] = "El significado debe tener al menos 2 caracteres";
        }
        //Validar si la palabra no tiene más de 15 caracteres
        if (strlen($ayapaneco) > 20) {
                $errores['significado'] = "El significado no puede tener más de 20 caracteres";
        }

        //Imprimir los errores
        foreach($errores as $error){
                $error;
           }

        //Si no hay errores (array de errores vacio)
        if(empty($errores)){
                
                try{

                //Preparar la inseción de los datos enviados por POST
                $sentencia = $conexion->prepare("INSERT INTO palabras(id,ayapaneco,variante,afi,id_categoria,significado,ejemplo_aya,ejemplo_esp,raiz) 
                VALUES (null, :ayapaneco, :variante, :afi, :id_categoria, :significado, :ejemplo_aya, :ejemplo_esp, :raiz)");

                //Se convierte la palabra a minusculas antes de enviarlo a la BD con strtolower()
                //se asigna el valor a variantes para evitar error 
                $ayapaneco_min = strtolower($ayapaneco);
                $variante_min = strtolower($variante);
                $significado_min = strtolower($significado);
                
                //Asignar los valores que vienen del formulario (POST)
                //Se convierte la palabra a minusculas antes de enviarlo a la BD con strtolower()
                $sentencia->bindParam(":ayapaneco",$ayapaneco_min);
                $sentencia->bindParam(":variante",$variante_min);
                $sentencia->bindParam(":afi",$afi);
                $sentencia->bindParam(":id_categoria",$id_categoria);
                $sentencia->bindParam(":significado",$significado_min);
                $sentencia->bindParam(":ejemplo_aya",$ejemplo_aya);
                $sentencia->bindParam(":ejemplo_esp",$ejemplo_esp);
                $sentencia->bindParam(":raiz",$raiz);

                print_r($id_categoria);
                //Se ejecuta la sentencia con los valores de param asignados
                $sentencia->execute();
                //Mensaje de confirmación de creado que activa Sweet Alert 2
                $mensaje="Se añadio la palabra al diccionario";
                //Redirecionar después de crear a la lista de cupones con link de Sweet Alert 2
                header("Location:index.php?mensaje=".$mensaje);
                }catch(Exception $ex){
                echo "Error de conexión:".$ex->getMessage();
                }
        }else {
        //La variable para mensaje de exito se actualiza a false si no se pudo insertar
        $succes=false;
        }

    }
        //query para obtener los nombres de las categorias gramaticales de la tabla categorias
        $sentencia = $conexion->prepare("SELECT * FROM categorias");
        $sentencia->execute();
        //se guarda la setencia ejecutada en otra variable para llamarla con loop en selector
        $categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Se llama el header desde los templates-->
<!-- ../../ sube 2 niveles para poder acceder al folder de templates desde la posición actual-->
<?php include("../../templates/header.php"); ?>

<!--Nuevo look empieza-->
<header class="text-center">
            <h1 class="text-light">Añadir palabra</h1>
</header>
<br>
<div class="card mx-auto" style="width:50%;">
        <div class="card-header">Nueva palabra</div>
                <div class="card-body">
                        <form action="crear.php" id="crearPalabras" method="post">
                        <div class="input-group">
                                <div class="mb-3 mx-auto" style="width:48%;">
                                        <label for="ayapaneco" class="form-label">Palabra en ayapaneco</label>
                                        <input type="text" class="form-control" name="ayapaneco" id="ayapaneco" aria-describedby="helpId" placeholder="Ingresa palabra" value="<?php echo isset($ayapaneco) ? $ayapaneco : ''; ?>" required/>
                                        <!--Inicio envio de mensaje de error-->
                                        <?php if (isset($errores['ayapaneco'])): ?>
                                                <div class="alert alert-danger mt-1"><?php echo $errores['ayapaneco']; ?></div>
                                        <?php endif; ?>
                                        <!--Fin envio de mensaje de error-->
                                </div>
                                <div class="mb-3 mx-auto" style="width:48%;">
                                        <label for="variante" class="form-label">Variante</label>
                                        <input type="text" class="form-control" name="variante" id="variante" aria-describedby="helpId" placeholder="Otra forma de decirlo" value="<?php echo isset($variante) ? $variante : ''; ?>"/>
                                        <!--Inicio envio de mensaje de error-->
                                        <?php if (isset($errores['variante'])): ?>
                                                <div class="alert alert-danger mt-1"><?php echo $errores['variante']; ?></div>
                                        <?php endif; ?>
                                        <!--Fin envio de mensaje de error-->
                                </div>
                        </div>
                        <div class="input-group">
                                <div class="mb-3 mx-auto" style="width:48%;">
                                        <label for="afi" class="form-label">Pronunciación</label>
                                        <input type="text" class="form-control" name="afi" id="afi" aria-describedby="helpId" placeholder="Transcripción fonética" value="<?php echo isset($afi) ? $afi : ''; ?>"/>
                                        <!--Inicio envio de mensaje de error-->
                                        <?php if (isset($errores['afi'])): ?>
                                                <div class="alert alert-danger mt-1"><?php echo $errores['afi']; ?></div>
                                        <?php endif; ?>
                                        <!--Fin envio de mensaje de error-->
                                </div>
                                <div class="mb-3 mx-auto" style="width:48%;">
                                        <label for="significado" class="form-label">Significado</label>
                                        <input type="text" class="form-control" name="significado" id="significado" aria-describedby="helpId" placeholder="Significado en español" value="<?php echo isset($significado) ? $significado : ''; ?>" required/>
                                        <!--Inicio envio de mensaje de error-->
                                        <?php if (isset($errores['significado'])): ?>
                                                <div class="alert alert-danger mt-1"><?php echo $errores['significado']; ?></div>
                                        <?php endif; ?>
                                        <!--Fin envio de mensaje de error-->
                                </div>
                        </div>
                        <div class="mb-3">
                                <label for="ejemplo_aya" class="form-label">Ejemplo</label>
                                <input type="text" class="form-control" name="ejemplo_aya" id="ejemplo_aya" aria-describedby="helpId" placeholder="En ayapaneco" value="<?php echo isset($ejemplo_aya) ? $ejemplo_aya : ''; ?>"/>
                                <!--Inicio envio de mensaje de error-->
                                <?php if (isset($errores['ejemplo_aya'])): ?>
                                        <div class="alert alert-danger mt-1"><?php echo $errores['ejemplo_aya']; ?></div>
                                <?php endif; ?>
                                <!--Fin envio de mensaje de error-->
                        </div>
                        <div class="mb-3">
                                <label for="ejemplo_esp" class="form-label">Ejemplo</label>
                                <input type="text" class="form-control" name="ejemplo_esp" id="ejemplo_esp" aria-describedby="helpId" placeholder="En español" value="<?php echo isset($ejemplo_esp) ? $ejemplo_esp : ''; ?>"/>
                                <!--Inicio envio de mensaje de error-->
                                <?php if (isset($errores['ejemplo_esp'])): ?>
                                        <div class="alert alert-danger mt-1"><?php echo $errores['ejemplo_esp']; ?></div>
                                <?php endif; ?>
                                <!--Fin envio de mensaje de error-->
                        </div>
                        <div class="mb-3">
                                <label for="raiz" class="form-label">Raíz</label>
                                <input type="text" class="form-control" name="raiz" id="raiz" aria-describedby="helpId" placeholder="Raiz de palabra" value="<?php echo isset($raiz) ? $raiz : ''; ?>"/>
                                <!--Inicio envio de mensaje de error-->
                                <?php if (isset($errores['raiz'])): ?>
                                        <div class="alert alert-danger mt-1"><?php echo $errores['raiz']; ?></div>
                                <?php endif; ?>
                                <!--Fin envio de mensaje de error-->
                        </div>
                        <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoria gramatical</label>
                                <select class="form-select form-select" name="id_categoria" id="id_categoria">
                                <option value="" selected>Seleccione una</option>
                                <?php foreach($categorias as $categoria){ ?>
                                        <option value="<?php echo $categoria['id']?>"><?php echo $categoria["categoria"]?></option>
                                <?php }?>
                                </select>
                                <!--Inicio envio de mensaje de error-->
                                <?php if (isset($errores['id_categoria'])): ?>
                                        <div class="alert alert-danger mt-1"><?php echo $errores['id_categoria']; ?></div>
                                <?php endif; ?>
                                <!--Fin envio de mensaje de error-->
                        </div>
                                <button type="submit" class="btn btn-success">Crear</button>
                                <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
                        </form>
                </div>
        <div class="card-footer text-muted"></div>
</div>
    <!--Nuevo look termina-->

<!-- Se llama el footer desde los templates-->
<!-- ../../ sube 2 niveles para poder acceder al folder de templates desde la posición actual-->
<?php include("../../templates/footer.php"); ?>