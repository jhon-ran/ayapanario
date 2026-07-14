<?php
declare(strict_types=1);

require_once __DIR__ . '/_includes/auth.php';
start_session();

if (auth_user()) {
  header('Location: buscar.php');
} else {
  header('Location: login.php');
}
exit;

