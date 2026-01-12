<?php
require 'includes/app.php';
use App\Propiedad;

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /');
}

/** @var Propiedad $propiedad */
$propiedad = Propiedad::find($id);

incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1><?= $propiedad->titulo  ?></h1>

    <img width="300" height="200" loading="lazy" src="/imagenes/<?= $propiedad->imagen ?>" alt="imagen de la propiedad" />

    <div class="resumen-propiedad">
        <p class="precio"><?= $propiedad->precio  ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img src="build/img/icono_wc.svg" alt="icono wc" loading="lazy" />
                <p><?= $propiedad->wc  ?></p>
            </li>

            <li>
                <img src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy" />
                <p><?= $propiedad->estacionamiento  ?></p>
            </li>

            <li>
                <img src="build/img/icono_dormitorio.svg" alt="icono domitorio" loading="lazy" />
                <p><?= $propiedad->habitaciones  ?></p>
            </li>
        </ul>

        <p>
            <?= $propiedad->descripcion  ?>
        </p>

    </div>
</main>


<?php
incluirTemplate('footer');
?>
