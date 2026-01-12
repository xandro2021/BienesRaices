<?php
require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor();

// Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Ejecutar el codigo despues del que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Crear una instancia de vendedor
    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar que no haya campos vacios
    $errores = $vendedor->validar();

    // Si no hay errores
    if (empty($errores)) {
        $vendedor->guardar();
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- enctype es solo para cuando se vaya a subir un archivo -->
    <form class="formulario" method="POST" id="" action="/admin/vendedores/crear.php" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" name="" value="Registrar Vendedor" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
