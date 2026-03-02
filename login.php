<?php
declare(strict_types=1);

require_once __DIR__ . '/_includes/auth.php';
require_once __DIR__ . '/_includes/util.php';

start_session();
if (auth_user()) { header('Location: buscar.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim((string)($_POST['email'] ?? ''));
  $pass  = (string)($_POST['password'] ?? '');
  if (login($email, $pass)) {
    header('Location: buscar.php');
    exit;
  }
  $error = 'Credenciales inválidas.';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/app.css">
  <title>Login · Ayapanario</title>
</head>
<body>
  <div class="topbar"><div class="brand">Ayapanario</div></div>
  <div class="wrap">
    <h2>Iniciar sesión</h2>
    <?php if($error): ?><div class="card"><?php echo h($error); ?></div><?php endif; ?>
    <form method="post" class="controls">
      <input name="email" type="email" placeholder="Correo" required>
      <input name="password" type="password" placeholder="Contraseña" required>
      <button class="btn" type="submit">Entrar</button>
    </form>
    <p class="small" style="margin-top:10px;color:#666;">
      Solo usuarios registrados pueden consultar el diccionario.
    </p>
  </div>
</body>
</html>
