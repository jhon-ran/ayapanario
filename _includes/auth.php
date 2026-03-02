<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function start_session(): void {
  $cfg = (require __DIR__ . '/config.php')['app'];
  if (session_status() === PHP_SESSION_NONE) {
    session_name($cfg['session_name']);
    session_start();
  }
}

function auth_user(): ?array {
  start_session();
  return $_SESSION['user'] ?? null;
}

function require_login(): void {
  if (!auth_user()) {
    header('Location: login.php');
    exit;
  }
}

function login(string $email, string $password): bool {
  start_session();
  $pdo = db();

  $stmt = $pdo->prepare("SELECT id, email, password, tipo, nombres FROM usuarios WHERE email = :email LIMIT 1");
  $stmt->execute([':email' => $email]);
  $u = $stmt->fetch();

  if (!$u) return false;

  // Soporta hash o texto plano (temporal)
  $hash = (string)$u['password'];
  $ok = false;
  $info = password_get_info($hash);
  if (!empty($info['algo'])) $ok = password_verify($password, $hash);
  else $ok = hash_equals($hash, $password);

  if (!$ok) return false;

  $_SESSION['user'] = [
    'id' => (int)$u['id'],
    'email' => (string)$u['email'],
    'tipo' => (string)($u['tipo'] ?? ''),
    'nombres' => (string)($u['nombres'] ?? ''),
  ];
  return true;
}

function logout(): void {
  start_session();
  $_SESSION = [];
  session_destroy();
}
