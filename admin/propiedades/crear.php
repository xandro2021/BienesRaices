<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

$db = conectarDB();

$propiedad = new Propiedad();
// Consultar a los vendedores
$consulta = 'SELECT * FROM Vendedores;';
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

// Ejecutar el codigo despues del que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST);

    if ($_FILES['imagen']['tmp_name']) {
        // Generar un nombre unico
        $nombreImagen = uniqid('', true);
        $extension = "." . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreImagen .= $extension;

        $manager = new Image(Driver::class);
        // leer imagen
        $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
        // guardo nombre de imagen
        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();

    // Revisar que el arreglo de errores este vacío
    if (empty($errores)) {

        /* SUBIDA DE ARCHIVOS */

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        // Guarda la imagen en el servidor
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);

        $resultadoInsert = $propiedad->guardar();

        if ($resultadoInsert) {
            // redireccionar al usuario
            // header solo funciona cuando no hay nada de html antes
            header('Location: /admin?resultado=1');
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" id="" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" name="" value="Crear Propiedad" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
