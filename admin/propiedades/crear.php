<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

$db = conectarDB();

// Consultar a los vendedores
$consulta = 'SELECT * FROM Vendedores;';
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

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

        <fieldset>
            <legend> Información General </legend>

            <label for="titulo"> Titulo: </label>
            <input type="text" name="titulo" value="<?php echo $titulo ?>" id="titulo" placeholder="Titulo Propiedad" />

            <label for="precio"> Precio: </label>
            <input type="number" name="precio" value="<?php echo $precio ?>" id="precio" placeholder="Precio Propiedad" />

            <label for="imagen"> Imagen: </label>
            <input type="file" name="imagen" value="" id="imagen" accept="image/jpeg, image/png" />

            <label for="descripcion"> Descripción </label>
            <textarea id="descripcion" name="descripcion" id="" rows="" cols="" tabindex=""><?php echo $descripcion ?></textarea>

        </fieldset>

        <fieldset>
            <legend> Información Propiedad </legend>

            <label for="habitaciones"> Habitaciones: </label>
            <input type="number" name="habitaciones" value="<?php echo $habitaciones ?>" id="habitaciones" placeholder="Ej: 3" min="1" max="9" />

            <label for="wc"> Baños: </label>
            <input type="number" name="wc" value="<?php echo $wc ?>" id="wc" placeholder="Ej: 3" min="1" max="9" />

            <label for="estacionamiento"> Estacionamiento: </label>
            <input type="number" name="estacionamiento" value="<?php echo $estacionamiento ?>" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" />

        </fieldset>

        <fieldset>
            <legend> Vendedor </legend>

            <select id="" name="vendedorId">
                <option value="" disabled <?php echo $vendedorId === '' ? 'selected' : ''; ?>> -- Seleccione -- </option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id'] ?>">
                        <?php echo "{$vendedor['nombre']} {$vendedor['apellido']}"; ?>
                    </option>
                <?php endwhile ?>
            </select>
        </fieldset>

        <input type="submit" name="" value="Crear Propiedad" class="boton boton-verde" />

    </form>

</main>

<?php incluirTemplate('footer'); ?>
