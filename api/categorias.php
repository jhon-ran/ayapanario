<?php
declare(strict_types=1);

require_once __DIR__ . '/../_includes/util.php';
require_once __DIR__ . '/../_includes/diccionario.php';

try {
  json_out(['ok'=>true, 'rows'=> dicc_categories()]);
} catch (Throwable $e) {
  json_out(['ok'=>false,'error'=>'Error al cargar categorías.'], 500);
}
