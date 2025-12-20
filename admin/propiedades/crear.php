<?php
require '../../includes/funciones.php';
require '../../includes/config/database.php';

$auth = estaAutenticado();

if (!$auth) {
    header('Location: /');
}

$db = conectarDB();

// Consultar a los vendedores
$consulta = 'SELECT * FROM Vendedores;';
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

// Ejecutar el codigo despues del que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
*     echo "<pre>";
*     var_dump($_POST);
*     echo "</pre>";
*
*     echo "<pre>";
*     var_dump($_FILES);
*     echo "</pre>";
*     exit;
*  */
    // Entre comillas van los name de las etiquetas html
    // sanatizar lo que ingresa el usuario para evitar codigo malicioso
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    // Asignar imagen hacia una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un título";
    }

    if (!$precio) {
        $errores[] = "El precio es obligatorio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores[] = "El numero de estacionamientos es obligatorio";
    }

    if (!$vendedorId) {
        $errores[] = "Elige un vendedor";
    }

    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "La imagen es obligatoria";
    }

    // validar por tamanio (1000kb maximo)
    $medida = 1000 * 2000;

    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // Revisar que el arreglo de errores este vacío
    if (empty($errores)) {

        /* SUBIDA DE ARCHIVOS */
        // crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar un nombre unico
        $nombreImagen = uniqid('', true);
        $extension = "." . pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $nombreImagen = $nombreImagen . $extension;

        // Subir archivo
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        // Inserts en la base de datos
        $query = "INSERT INTO Propiedades(titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES('$titulo',  '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId');";

        $resultadoInsert = mysqli_query($db, $query);

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

            <select id="" name="vendedor">
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
