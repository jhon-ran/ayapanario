<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Example</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <!-- estilo para personalizar -->
    <link rel="stylesheet" href="style.css">
    <!-- cdn DataTables v.1.12.1 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <!-- cdn para Sweet Alert 2, alertas de acciones -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <form class="my-form">
        <div class="login-welcome-row">
            <h1>Bienvenid@ a ayapanario&#x1F44F;</h1>
            <p>Ingresa tus datos</p>
        </div>
        <div class="input__wrapper">
            <input type="email" id="email" name="email" class="input__field" placeholder="Your Email" required>
            <label for="email" class="input__label">Correo:</label>
            <svg class="input__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                <path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path>
            </svg>
        </div>
        <div class="input__wrapper">
            <input id="password" type="password" class="input__field" placeholder="Your Password" required>
            <label for="password" class="input__label">
                Contraseña
            </label>
            <svg class="input__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"></path>
                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                
            </svg>
        </div>
        <div class="mb-3">
            <input type="checkbox" onclick="mostrarPassword()"> <small>Mostrar</small>
        </div>
        <button type="submit" class="my-form__button">
            Ingresar
        </button>
        <!-- Para logearse con Google-->
        <!--
        <div class="socials-row">
            <a href="#" title="Use Google">
                <img src="assets/google.png" alt="Google">
                Log in with Google
            </a>
        </div>
        -->
        <div class="my-form__actions">
            <div class="my-form__row">
                <span>¿No tienes cuenta?</span>
                <a href="#" title="Create Account">
                    Inscríbete
                </a>
            </div>
        </div>
    </form>

    <script src="js/script.js"></script>
    <script src="js/mostrarPassword.js"></script>
</body>

</html>