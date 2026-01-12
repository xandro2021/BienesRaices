<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require '../../includes/app.php';

estaAutenticado();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

// validando la entrada
if (!$id) {
    header('Location: /admin');
}

// Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

// Consulta para obtener los vendedores
$vendedores = Vendedor::all();

// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

// Ejecutar el codigo despues del que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // asignar los atributos
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    // Validacion
    $errores = $propiedad->validar();


    // Subida de archivos
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        // Generar un nombre unico
        $nombreImagen = uniqid('', true);
        $extension = "." . pathinfo($_FILES['propiedad']['name']['imagen'], PATHINFO_EXTENSION);
        $nombreImagen .= $extension;

        $manager = new Image(Driver::class);
        // leer imagen
        $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
        // guardo nombre de imagen
        $propiedad->setImagen($nombreImagen);
    }

    // Revisar que el arreglo de errores este vacío
    if (empty($errores)) {

        // si hay una imagen en la global de files
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }

        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" id="" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>
        <input type="submit" name="" value="Actualizar Propiedad" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
