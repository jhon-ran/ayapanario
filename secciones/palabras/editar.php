<!-- Importar conexión a BD-->
<?php include("../../bd.php"); 
//se inicializa variable de sesión
session_start();
?>

<!-- Se llama el header desde los templates-->
<!-- ../../ sube 2 niveles para poder acceder al folder de templates desde la posición actual-->
<?php include("../../templates/header.php"); ?>

<!--Nuevo look empieza-->
<header class="text-center">
            <h1 class="text-light">Editar palabra</h1>
</header>
<br>
<div class="card mx-auto" style="width:50%;">
        <div class="card-header">Palabra</div>
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