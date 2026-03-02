<?php
declare(strict_types=1);

require_once __DIR__ . '/_includes/auth.php';
require_once __DIR__ . '/_includes/util.php';
require_once __DIR__ . '/_includes/diccionario.php';

require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$e = $id > 0 ? dicc_get($id) : null;
$ej = $e ? parse_ejemplos($e['ejemplos'] ?? '') : [];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/app.css">
  <title><?php echo h($e['lema'] ?? 'Entrada'); ?> · Ayapanario</title>
</head>
<body>
  <div class="topbar">
    <a class="btn" href="buscar.php">&laquo; Volver</a>
    <div class="brand">Entrada</div>
    <div></div>
  </div>

  <div class="wrap">
    <?php if(!$e): ?>
      <div class="card">No encontrada.</div>
    <?php else: ?>
      <div class="card">
        <h3><?php echo h($e['lema']); ?>
          <?php if(!empty($e['ortografia']) && $e['ortografia'] !== $e['lema']): ?>
            <span class="small"> · <?php echo h($e['ortografia']); ?></span>
          <?php endif; ?>
        </h3>
        <div class="small">
          <?php if(!empty($e['categoria_gramatical'])): ?>Cat: <?php echo h($e['categoria_gramatical']); ?><?php endif; ?>
          <?php if(!empty($e['pronunciacion'])): ?> · <?php echo h($e['pronunciacion']); ?><?php endif; ?>
        </div>
        <?php if(!empty($e['definicion'])): ?>
          <div class="def"><?php echo h($e['definicion']); ?></div>
        <?php endif; ?>
      </div>

      <?php if($ej): ?>
        <div class="card">
          <h3>Ejemplos</h3>
          <?php foreach($ej as $x): ?>
            <div class="ej">
              <?php if($x['frase']): ?><div class="fr"><?php echo h($x['frase']); ?></div><?php endif; ?>
              <?php if($x['traduccion']): ?><div><?php echo h($x['traduccion']); ?></div><?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
