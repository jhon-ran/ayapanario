<?php
declare(strict_types=1);

// Config simple. En Hostinger puedes mover esto a variables de entorno si quieres.
return [
  'db' => [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'name' => getenv('DB_NAME') ?: '2_0_diccionario',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
    'port' => getenv('DB_PORT') ?: '3306',
  ],
  'app' => [
    'name' => 'Ayapanario',
    'session_name' => 'AYA_SESS',
  ],
];
