<?php
require '../includes/app.php';

// Importar las clases
use App\Propiedad;
use App\Vendedor;

estaAutenticado();

// Implementar un metodo para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

// Evito el error que aparece al cargar la pagina sin hacer un POST.
// El codigo solo debe ejecutarse cuando se hace una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar id
    $id = $_POST['id'];
    // se hace limpieza del input para evitar codigo malicioso
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        $tipo = $_POST['tipo'];

        if (validarTipoContenido($tipo)) {
            // Compara lo que debemos eliminar
            if ($tipo === 'vendedor') {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            } else if ($tipo === 'propiedad') {
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }
        }
    }
}

// Incluye un template
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de bienes raíces</h1>

    <?php $mensaje = mostrarNotificacion(intval($resultado)); ?>
    <?php if ($mensaje): ?>
        <p class="alerta exito">
            <?= s($mensaje); ?>
        </p>
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

    <h2>Propiedades</h2>

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
            <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?= $propiedad->id ?></td>
                    <td><?= $propiedad->titulo ?></td>
                    <td>
                        <img src="/imagenes/<?= $propiedad->imagen ?>" class="imagen-tabla" />
                    </td>
                    <td>$ <?= $propiedad->precio ?></td>
                    <td>
                        <form method="POST" class="w-100" action="">
                            <input type="hidden" name="id" value="<?= $propiedad->id ?>" />
                            <input type="hidden" name="tipo" value="propiedad" />
                            <input class="boton-rojo-block" type="submit" name="" value="Eliminar" />
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?= $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar los resultados -->
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?= $vendedor->id ?></td>
                    <td><?= $vendedor->nombre . " " . $vendedor->apellido ?></td>
                    <td><?= $vendedor->telefono ?></td>
                    <td>
                        <form method="POST" class="w-100" action="">
                            <input type="hidden" name="id" value="<?= $vendedor->id ?>" />
                            <input type="hidden" name="tipo" value="vendedor" />
                            <input class="boton-rojo-block" type="submit" name="" value="Eliminar" />
                        </form>
                        <a href="admin/vendedores/actualizar.php?id=<?= $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>


</main>

<?php
incluirTemplate('footer');
?>
