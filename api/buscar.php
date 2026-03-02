<?php
declare(strict_types=1);

require_once __DIR__ . '/../_includes/util.php';
require_once __DIR__ . '/../_includes/diccionario.php';

$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$cat = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? (string)$_GET['categoria'] : null;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, min(50, (int)$_GET['limit'])) : 20;
$offset = ($page - 1) * $limit;

try {
  $r = dicc_search($q, $cat, $limit, $offset);
  $total = (int)$r['total'];
  $pages = (int)max(1, ceil($total / $limit));
  json_out([
    'ok'=>true,
    'q'=>$q,
    'categoria'=>$cat,
    'page'=>$page,
    'pages'=>$pages,
    'limit'=>$limit,
    'total'=>$total,
    'rows'=>$r['rows'],
  ]);
} catch (Throwable $e) {
  json_out(['ok'=>false,'error'=>'Error al buscar.'], 500);
}
