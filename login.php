<?php
require "includes/config/database.php";
$db = conectarDB();

$errores = [];
// Autenticar el usuario
// verifico que el codigo solo se active al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es valido";
    }

    if (!$password) {
        $errores[] = "El password es obligatorio";
    }

    if (empty($errores)) {
        // Revisar si el usuario existe
        $query = "SELECT * FROM Usuario WHERE email = '$email';";
        $resultado = mysqli_query($db, $query);

        // Revisar que hayan resultados
        if ($resultado->num_rows) {
            // Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);

            // Funcion para evaluar un password hasheado
            $auth = password_verify($password, $usuario['password_hash']);

            if ($auth) {
                // El usuario esta autenticado
                session_start();

                // Llenar el arreglo de la sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                header('Location: /admin');

            } else {
                $errores[] = "El password es incorrecto";
            }

        } else {
            $errores[] = "El usuario no existe";
        }
    }
}

// Incluye el header
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?= $error ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" id="" action="">

        <fieldset>
            <legend>Email y Password</legend>

            <label for="email"> Email </label>
            <input type="email" id="email" name="email" value="" placeholder="Tu Email" required />

            <label for="password"> Password </label>
            <input type="password" id="password" name="password" value="" placeholder="Tu Password" required />

        </fieldset>

        <input type="submit" name="" value="Iniciar Sesión" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
