<?php
session_start();
if(isset($_SESSION['auth'])){
    $_SESSION['mensaje'] = "Ya estás logueado";
    header("Location: index.php");
    exit(0);
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Crear una cuenta</title>
    <?php
    include 'comp/head.php';
    include 'comp/estilos.php';
    ?>
    <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="db_registro.php" method="post">
            <img class="mb-4" src="svg/slack.svg" alt="" width="200">
            <h1 class="h3 mb-3 fw-normal">Crear una cuenta</h1>
            <?php
            include 'comp/alerts.php';
            ?>
            <div class="form-floating">
                <input name="user_registro" type="text" class="form-control" id="floatingInput" placeholder="Introduzca su nombre de usuario" required>
                <label for="floatingInput">Usuario</label>
            </div>
            <div class="form-floating">
                <input name="email_registro" type="email" class="form-control" id="floatingInput" placeholder="Introduzca su correo electrónico" required>
                <label for="floatingInput">Correo electrónico</label>
            </div>
            <div class="form-floating">
                <input name="pass_registro" type="password" class="form-control" id="floatingPassword" placeholder="Introduzca su contraseña" required>
                <label for="floatingPassword">Contraseña</label>
            </div>
            <div class="form-floating">
                <input name="cpass_registro" type="password" class="form-control" id="floatingPassword" placeholder="Introduzca su contraseña" required>
                <label for="floatingPassword">Confirmar contraseña</label>
            </div>
            <button name="submit_registro" class="w-100 btn btn-lg btn-primary" type="submit">Registrarse</button>
            <p style="margin-top:20px"><a href="login.php">Iniciar sesión</a></p>

        </form>
    </main>


    <?php
    include 'comp/scripts.php';
    ?>
</body>

</html>