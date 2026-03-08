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
  <!-- Bootstrap 5 (solo CSS) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/app.css">
  <title>Buscar · Ayapanario</title>
</head>
<body>

  <!-- Barra de navegación superior -->
  <div class="topbar">
    <span class="brand">Ayapanario</span>
    <div class="d-flex align-items-center gap-2">
      <span class="topbar-user"><?php echo h($u['email'] ?? ''); ?></span>
      <a class="btn btn-secundario" href="logout.php">Salir</a>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="wrap">

    <!-- Controles de búsqueda -->
    <div class="controles">

      <!-- Campo principal de búsqueda -->
      <input
        id="q"
        type="search"
        placeholder="Buscar palabra, definición, ejemplo…"
        autocomplete="off"
        autocorrect="off"
        spellcheck="false"
      >

      <!-- Filtros secundarios -->
      <div class="fila-filtros">
        <select id="categoria">
          <option value="">Todas las categorías</option>
        </select>
        <select id="limit">
          <option value="10">10 por página</option>
          <option value="20" selected>20 por página</option>
          <option value="50">50 por página</option>
        </select>
      </div>

      <!-- Botón de búsqueda -->
      <button id="btnBuscar" class="btn btn-primario">Buscar</button>

    </div>

    <!-- Contador de resultados -->
    <p id="meta" class="meta"></p>

    <!-- Resultados -->
    <div id="results"></div>

    <!-- Paginación -->
    <div class="pager">
      <button id="prev" class="btn btn-secundario" disabled>&#8592; Anterior</button>
      <button id="next" class="btn btn-secundario" disabled>Siguiente &#8594;</button>
    </div>

  </div>

  <script src="assets/app.js"></script>
</body>
</html>
