<?php
declare(strict_types=1);

require_once __DIR__ . '/_includes/auth.php';
require_once __DIR__ . '/_includes/util.php';

require_login();
$u = auth_user();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/app.css">
  <title>Buscar · Ayapanario</title>
</head>
<body>
  <div class="topbar">
    <div class="brand">Ayapanario</div>
    <div style="display:flex;gap:8px;align-items:center">
      <span class="small"><?php echo h($u['email'] ?? ''); ?></span>
      <a class="btn" href="logout.php">Salir</a>
    </div>
  </div>

  <div class="wrap">
    <div class="controls">
      <input id="q" type="search" placeholder="Buscar lema / ortografía / definición / ejemplos">
      <div class="row">
        <select id="categoria"><option value="">Todas</option></select>
        <select id="limit">
          <option value="10">10</option>
          <option value="20" selected>20</option>
          <option value="50">50</option>
        </select>
      </div>
      <button id="btnBuscar" class="btn">Buscar</button>
    </div>

    <div id="meta" class="meta"></div>
    <div id="results"></div>

    <div class="pager">
      <button id="prev" class="btn">&laquo; Anterior</button>
      <button id="next" class="btn">Siguiente &raquo;</button>
    </div>
  </div>

  <script src="assets/app.js"></script>
</body>
</html>
