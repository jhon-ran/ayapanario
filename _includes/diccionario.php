<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

// FULLTEXT opcional; por defecto usamos LIKE seguro.
const AYA_ENABLE_FULLTEXT = false;

function query_variants(string $q): array {
  $q = trim($q);
  if ($q === '') return [];

  $orig = mb_strtolower($q, 'UTF-8');
  $swap = str_replace(['ʔ','ʼ','’'], "'", $orig);
  $nogl = str_replace(["ʔ","'","ʼ","’"], "", $orig);

  $trans = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $swap);
  $ascii = $trans !== false ? strtolower(preg_replace('/[^a-z0-9\s\.-]/i', '', $trans)) : $swap;

  return array_values(array_unique(array_filter([$orig, $swap, $nogl, $ascii])));
}

function dicc_get(int $id): ?array {
  $pdo = db();
  $stmt = $pdo->prepare("SELECT id, lema, ortografia, categoria_gramatical, pronunciacion, definicion, ejemplos
                         FROM diccionario WHERE id = :id LIMIT 1");
  $stmt->execute([':id' => $id]);
  $r = $stmt->fetch();
  return $r ?: null;
}

function dicc_search(string $q, ?string $cat, int $limit, int $offset): array {
  $pdo = db();
  $limit = max(1, min(50, $limit));
  $offset = max(0, $offset);

  if (trim($q) === '') {
    $sql = "SELECT id, lema, ortografia, categoria_gramatical, pronunciacion, definicion, ejemplos
            FROM diccionario
            " . ($cat ? "WHERE categoria_gramatical = :cat " : "") . "
            ORDER BY id DESC
            LIMIT {$offset}, {$limit}";
    $stmt = $pdo->prepare($sql);
    if ($cat) $stmt->bindValue(':cat', $cat, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $sqlC = "SELECT COUNT(*) FROM diccionario " . ($cat ? "WHERE categoria_gramatical = :cat" : "");
    $stmtC = $pdo->prepare($sqlC);
    if ($cat) $stmtC->bindValue(':cat', $cat, PDO::PARAM_STR);
    $stmtC->execute();
    $total = (int)$stmtC->fetchColumn();

    return ['rows'=>$rows, 'total'=>$total];
  }

  $vars = query_variants($q);
  if (!$vars) return ['rows'=>[], 'total'=>0];

  $whereParts = [];
  $params = [];
  $i = 0;
  foreach ($vars as $v) {
    $k1=":v{$i}a"; $k2=":v{$i}b"; $k3=":v{$i}c"; $k4=":v{$i}d";
    $whereParts[] = "(lema LIKE $k1 OR ortografia LIKE $k2 OR definicion LIKE $k3 OR ejemplos LIKE $k4)";
    $params[$k1]="%{$v}%"; $params[$k2]="%{$v}%"; $params[$k3]="%{$v}%"; $params[$k4]="%{$v}%";
    $i++;
  }
  $where = implode(' OR ', $whereParts);

  $sql = "SELECT id, lema, ortografia, categoria_gramatical, pronunciacion, definicion, ejemplos
          FROM diccionario
          WHERE ($where) " . ($cat ? "AND categoria_gramatical = :cat " : "") . "
          ORDER BY id DESC
          LIMIT {$offset}, {$limit}";
  $stmt = $pdo->prepare($sql);
  for ($j=0; $j<count($params); $j++) {}
  foreach ($params as $k=>$v) $stmt->bindValue($k, $v, PDO::PARAM_STR);
  if ($cat) $stmt->bindValue(':cat', $cat, PDO::PARAM_STR);
  $stmt->execute();
  $rows = $stmt->fetchAll();

  $sqlC = "SELECT COUNT(*) FROM diccionario
           WHERE ($where) " . ($cat ? "AND categoria_gramatical = :cat " : "");
  $stmtC = $pdo->prepare($sqlC);
  foreach ($params as $k=>$v) $stmtC->bindValue($k, $v, PDO::PARAM_STR);
  if ($cat) $stmtC->bindValue(':cat', $cat, PDO::PARAM_STR);
  $stmtC->execute();
  $total = (int)$stmtC->fetchColumn();

  return ['rows'=>$rows, 'total'=>$total];
}

function dicc_categories(): array {
  $pdo = db();
  $rows = $pdo->query("SELECT categoria_gramatical AS categoria, COUNT(*) AS n
                       FROM diccionario
                       WHERE categoria_gramatical IS NOT NULL AND categoria_gramatical <> ''
                       GROUP BY categoria_gramatical
                       ORDER BY categoria_gramatical ASC")->fetchAll();
  return array_map(fn($r)=>['categoria'=>(string)$r['categoria'],'n'=>(int)$r['n']], $rows);
}

function parse_ejemplos(?string $s): array {
  if (!$s) return [];
  $chunks = preg_split('/\s*\|\|\s*/u', $s);
  $out = [];
  foreach ($chunks as $ch) {
    $ch = trim($ch);
    if ($ch === '') continue;
    if (preg_match('/^\[(.*?)\]\s*::\s*(.+)$/u', $ch, $m)) {
      $out[] = ['frase'=>trim($m[1]), 'traduccion'=>trim($m[2])];
    } else {
      $out[] = ['frase'=>'', 'traduccion'=>$ch];
    }
  }
  return $out;
}
