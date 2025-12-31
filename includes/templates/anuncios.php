<?php
// Importar conexion -- require es relativo al documento o se usa la ruta relativa del documento que llama index.php
$db = conectarDB();

// Consultar
$query = "SELECT * FROM Propiedades LIMIT {$limite};";

// Obtener el resultado
$resultado = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">

    <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>

        <div class="anuncio">

            <img class="adjustarImagenesAnuncios" loading="lazy" src="/imagenes/<?= $propiedad['imagen'] ?>" alt="anuncio casa 3" />

            <div class="contenido-anuncio">
                <h3><?= $propiedad['titulo'] ?></h3>
                <p><?= $propiedad['descripcion'] ?></p>
                <p class="precio"><?= $propiedad['precio'] ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img src="build/img/icono_wc.svg" alt="icono wc" loading="lazy" />
                        <p><?= $propiedad['wc']  ?></p>
                    </li>

                    <li>
                        <img src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy" />
                        <p><?= $propiedad['estacionamiento']  ?></p>
                    </li>

                    <li>
                        <img src="build/img/icono_dormitorio.svg" alt="icono domitorio" loading="lazy" />
                        <p><?= $propiedad['habitaciones']  ?></p>
                    </li>
                </ul>

                <a class="boton-amarillo-block" href="anuncio.php?id=<?= $propiedad['id'] ?>">Ver Propiedad</a>
            </div> <!-- contenido anuncio -->

        </div> <!-- anuncio -->

    <?php endwhile; ?>
</div> <!-- contenedor de anuncios -->

<?php
// Cerrar la conexion
mysqli_close($db);
?>
