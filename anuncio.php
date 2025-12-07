<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en venta frente al bosque</h1>

        <picture>
            <source srcset="build/img/destacada.avif" type="image/avif" />
            <source srcset="build/img/destacada.webp" type="image/webp" />
            <source srcset="build/img/destacada.jpg" type="image/jpeg" />
            <img width="300" height="200" loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad" />
        </picture>

        <div class="resumen-propiedad">
            <p class="precio"> $3,000,000 </p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img src="build/img/icono_wc.svg" alt="icono wc" loading="lazy" />
                    <p>3</p>
                </li>

                <li>
                    <img src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy" />
                    <p>3</p>
                </li>

                <li>
                    <img src="build/img/icono_dormitorio.svg" alt="icono domitorio" loading="lazy" />
                    <p>4</p>
                </li>
            </ul>

            <p>
                Cras pulvinar mattis nunc, sed blandit libero volutpat. Turpis massa sed elementum tempus egestas sed sed risus pretium
                quam vulputate dignissim suspendisse in est ante in nibh mauris, cursus mattis. Dui sapien eget mi proin sed libero enim, sed faucibus turpis in eu! Amet commodo nulla facilisi nullam vehicula ipsum a
                arcu cursus vitae congue mauris rhoncus aenean vel elit! Id leo in vitae turpis massa sed elementum tempus egestas sed sed risus pretium quam vulputate dignissim suspendisse in
                est ante in nibh mauris, cursus? Nibh tortor, id aliquet lectus.
            </p>

            <p>
                Egestas quis ipsum suspendisse ultrices. Aliquam sem fringilla ut morbi tincidunt augue interdum velit euismod in
                pellentesque massa placerat duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat in. A arcu cursus vitae congue mauris rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant
                morbi tristique senectus et netus et! Pharetra, magna ac placerat vestibulum, lectus mauris ultrices!
            </p>

        </div>
    </main>


<?php incluirTemplate('footer'); ?>
