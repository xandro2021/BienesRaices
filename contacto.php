<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>


    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.avif" type="image/avif" />
            <source srcset="build/img/destacada3.webp" type="image/webp" />
            <source srcset="build/img/destacada3.jpg" type="image/jpeg" />
            <img width="300" height="200" loading="lazy" src="build/img/destacada3.jpg" alt="" />
        </picture>

        <h2>Llene el formulario de Contacto</h2>

        <form class="formulario" method="" id="" action="">

            <fieldset>
                <legend> Información Personal </legend>

                <label for="nombre"> Nombre </label>
                <input type="text" id="nombre" name="" value="" placeholder="Tu Nombre" />

                <label for="email"> Email </label>
                <input type="email" id="email" name="" value=""  placeholder="Tu Email"/>

                <label for="telefono"> Telefono </label>
                <input type="tel" id="telefono" name="" value=""  placeholder="Tu Telefono"/>

                <label for="mensaje"> Mensaje </label>
                <textarea name="" id="mensaje" rows="" cols="" tabindex=""></textarea>

            </fieldset>

            <fieldset>
                <legend> Información sobre la propiedad </legend>

                <label for="opciones"> Vende o Compra: </label>

                <select id="opciones" name="">
                    <option value="" disabled selected >-- Seleccione --</option>
                    <option value="compra"> Compra </option>
                    <option value="venta"> Venta </option>
                </select>

                <label for="presupuesto"> Precio o Presupuesto </label>
                <input type="number" id="presupuesto" name="" value="" placeholder="Tu Precio o Presupuesto" />

            </fieldset>

            <fieldset>
                <legend> Contacto </legend>

                <p>Como desea ser contactado</p>

                <div class="forma-contacto">
                    <label for="contactar-telefono"> Teléfono </label>
                    <input type="radio" name="contacto" value="telefono" id="contactar-telefono" />
                    <label for="contactar-email"> Email </label>
                    <input type="radio" name="contacto" value="email" id="contactar-email" />
                </div>

                <p>Si eligió teléfono, elija la fecha y la hora</p>

                <label for="fecha"> Fecha: </label>
                <input type="date" id="fecha" />

                <label for="hora"> Hora: </label>
                <input type="time" id="hora" min="09:00" max="18:00" />

            </fieldset>

            <input type="submit" name="" value="Enviar" class="boton-verde" />

        </form>

    </main>

<?php incluirTemplate('footer'); ?>
