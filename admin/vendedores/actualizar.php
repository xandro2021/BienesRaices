<?php
require '../../includes/app.php';
use App\Vendedor;

estaAutenticado();

// Validar que sea un id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

// Si no hay id, se redirecciona
if (!$id) {
    header('Location: /admin');
}

// Obtener el arreglo de vendedor desde la BD
$vendedor = Vendedor::find($id);

// Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

// Ejecutar el codigo despues del que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar los valores
    $args = $_POST['vendedor'];
    // Sincronizar objeto en memoria con lo que el usuario ha ingresado
    $vendedor->sincronizar($args);

    // Validacion
    $errores = $vendedor->validar();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <!-- enctype es solo para cuando se vaya a subir un archivo -->
    <form class="formulario" method="POST" id="" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" name="" value="Guardar Cambios" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
