<?php
declare(strict_types=1);

require_once __DIR__ . '/_includes/auth.php';
require_once __DIR__ . '/_includes/util.php';
require_once __DIR__ . '/_includes/diccionario.php';

require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$e  = $id > 0 ? dicc_get($id) : null;
$ej = $e ? parse_ejemplos($e['ejemplos'] ?? '') : [];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap 5 (solo CSS) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/app.css">
  <title><?php echo h($e['lema'] ?? 'Entrada'); ?> · Ayapanario</title>
</head>
<body>

  <!-- Barra de navegación superior -->
  <div class="topbar">
    <a class="btn btn-secundario" href="buscar.php">&#8592; Volver</a>
    <span class="brand">Ayapanario</span>
    <!-- espacio vacío para centrar el brand visualmente -->
    <span style="min-width:72px;"></span>
  </div>

  <!-- Contenido principal -->
  <div class="wrap">

    <?php if (!$e): ?>

      <!-- Entrada no encontrada -->
      <div class="card sin-resultados">
        Entrada no encontrada.
      </div>

    <?php else: ?>

      <!-- ── Tarjeta principal: lema + definición ── -->
      <div class="card">

        <!-- Lema y ortografía alternativa -->
        <h1 class="entrada-lema">
          <?php echo h($e['lema']); ?>
          <?php if (!empty($e['ortografia']) && $e['ortografia'] !== $e['lema']): ?>
            <span class="card-ortografia">&nbsp;· <?php echo h($e['ortografia']); ?></span>
          <?php endif; ?>
        </h1>

        <!-- Metadatos: categoría y pronunciación -->
        <?php if (!empty($e['categoria_gramatical']) || !empty($e['pronunciacion'])): ?>
          <div class="card-meta">
            <?php if (!empty($e['categoria_gramatical'])): ?>
              <span class="badge-cat"><?php echo h($e['categoria_gramatical']); ?></span>
            <?php endif; ?>
            <?php if (!empty($e['pronunciacion'])): ?>
              <span><?php echo h($e['pronunciacion']); ?></span>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Definición -->
        <?php if (!empty($e['definicion'])): ?>
          <p class="card-definicion"><?php echo h($e['definicion']); ?></p>
        <?php endif; ?>

      </div>

      <!-- ── Tarjeta de ejemplos ── -->
      <?php if ($ej): ?>
        <div class="card">
          <p class="seccion-titulo">Ejemplos de uso</p>
          <?php foreach ($ej as $x): ?>
            <div class="ejemplo">
              <?php if ($x['frase']): ?>
                <div class="ejemplo-frase"><?php echo h($x['frase']); ?></div>
              <?php endif; ?>
              <?php if ($x['traduccion']): ?>
                <div class="ejemplo-traduccion"><?php echo h($x['traduccion']); ?></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <?php endif; ?>

  </div>

</body>
</html>
