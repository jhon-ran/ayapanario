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
  $error = 'Correo o contraseña incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap 5 (solo CSS, sin JS — no se necesita para este formulario) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/app.css">
  <title>Acceso · Ayapanario</title>
</head>
<body>

  <div class="login-wrap">

    <!-- Encabezado -->
    <div class="mb-4 text-center">
      <p class="login-titulo">Ayapanario</p>
      <p class="login-subtitulo">Diccionario bilingüe · Solo usuarios registrados</p>
    </div>

    <!-- Error de credenciales -->
    <?php if ($error): ?>
      <div class="alerta-error"><?php echo h($error); ?></div>
    <?php endif; ?>

    <!-- Formulario de acceso -->
    <div class="card">
      <form method="post" novalidate>

        <div class="mb-3">
          <label for="email" class="form-label" style="font-family:var(--fuente-ui);font-size:var(--tam-pequeno);font-weight:600;">
            Correo electrónico
          </label>
          <input
            id="email"
            name="email"
            type="email"
            placeholder="tu@correo.com"
            required
            autocomplete="email"
            class="form-control"
            style="border-radius:var(--radio);font-family:var(--fuente-ui);"
          >
        </div>

        <div class="mb-4">
          <label for="password" class="form-label" style="font-family:var(--fuente-ui);font-size:var(--tam-pequeno);font-weight:600;">
            Contraseña
          </label>
          <input
            id="password"
            name="password"
            type="password"
            placeholder="••••••••"
            required
            autocomplete="current-password"
            class="form-control"
            style="border-radius:var(--radio);font-family:var(--fuente-ui);"
          >
        </div>

        <button type="submit" class="btn btn-primario w-100">
          Entrar
        </button>

      </form>
    </div>

  </div>

</body>
</html>
