<fieldset>
    <legend> Información General </legend>

    <label for="titulo"> Titulo: </label>
    <input type="text" name="propiedad[titulo]" value="<?= s($propiedad->titulo) ?>" id="titulo" placeholder="Titulo Propiedad" />

    <label for="precio"> Precio: </label>
    <input type="number" name="propiedad[precio]" value="<?= s($propiedad->precio) ?>" id="precio" placeholder="Precio Propiedad" />

    <label for="imagen"> Imagen: </label>
    <input type="file" name="propiedad[imagen]" value="" id="imagen" accept="image/jpeg, image/png" />

    <?php if ($propiedad->imagen): ?>
        <img src="/imagenes/<?= $propiedad->imagen ?>" class="imagen-small" alt="imagen de la propiedad" />
    <?php endif; ?>

    <label for="descripcion"> Descripción </label>
    <textarea id="descripcion" name="propiedad[descripcion]" id="" rows="" cols="" tabindex=""><?= s($propiedad->descripcion) ?></textarea>

</fieldset>

<fieldset>
    <legend> Información Propiedad </legend>

    <label for="habitaciones"> Habitaciones: </label>
    <input type="number" name="propiedad[habitaciones]" value="<?= s($propiedad->habitaciones) ?>" id="habitaciones" placeholder="Ej: 3" min="1" max="9" />

    <label for="wc"> Baños: </label>
    <input type="number" name="propiedad[wc]" value="<?= s($propiedad->wc) ?>" id="wc" placeholder="Ej: 3" min="1" max="9" />

    <label for="estacionamiento"> Estacionamiento: </label>
    <input type="number" name="propiedad[estacionamiento]" value="<?= s($propiedad->estacionamiento) ?>" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" />

</fieldset>

<fieldset>
    <legend> Vendedor </legend>

    <select id="" name="vendedorId">
        <option value="" disabled <?php echo $vendedorId === '' ? 'selected' : ''; ?>> -- Seleccione -- </option>
        <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
            <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo s($vendedor['id']) ?>">
                <?php echo "{$vendedor['nombre']} {$vendedor['apellido']}"; ?>
            </option>
        <?php endwhile ?>
    </select>
</fieldset>
