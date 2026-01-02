<?php
require '../includes/app.php';

estaAutenticado();

$db = conectarDB();

// Escribir el Query
$query = "SELECT * FROM Propiedades;";

// Consultar la BD
$resultadoConsulta = mysqli_query($db, $query);

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

// Evito el error que aparece al cargar la pagina sin hacer un POST.
// El codigo solo debe ejecutarse cuando se hace una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    // se hace limpieza del input para evitar codigo malicioso
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Eliminar el archivo
        $query = "SELECT imagen FROM Propiedades WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultado);

        // Eliminar la imagen
        unlink("../imagenes/" . $propiedad['imagen']);

        // Eliminar la propiedad
        $query = "DELETE FROM Propiedades WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /admin?resultado=3');
        }
    }
}

// Incluye un template
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de bienes raíces</h1>

    <?php if (intval($resultado) === 1): ?>
        <p class="alerta exito"> Anuncio Creado Correctamente </p>
    <?php elseif (intval($resultado) === 2): ?>
        <p class="alerta exito"> Anuncio Actualizado Correctamente </p>
    <?php elseif (intval($resultado) === 3): ?>
        <p class="alerta exito"> Anuncio Eliminado Correctamente </p>
    <?php endif ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar los resultados -->
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?= $propiedad['id'] ?></td>
                    <td><?= $propiedad['titulo'] ?></td>
                    <td>
                        <img src="/imagenes/<?= $propiedad['imagen'] ?>" class="imagen-tabla" />
                    </td>
                    <td>$ <?= $propiedad['precio'] ?></td>
                    <td>
                        <form method="POST" class="w-100" action="">
                            <input type="hidden" name="id" value="<?= $propiedad['id'] ?>" />
                            <input class="boton-rojo-block" type="submit" name="" value="Eliminar" />
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?= $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>

                </tr>
            <?php endwhile ?>
        </tbody>
    </table>

</main>

<?php
// Cerrar la conexion
mysqli_close($db);
incluirTemplate('footer');
?>
