
<div class="contenedor-anuncios">
        <?php foreach($propiedades as $propiedad) { ?>
        <div class="anuncio">
            
            <img class="imagen-anuncio" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio" loading="lazy">
            
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo;?></h3>
                <p><?php echo substr($propiedad->descripcion, 0, 100) . '...'; ?></p>
                <p class="precio"><?php echo $propiedad->precio; ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                        
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio" loading="lazy">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                        
                    </li>
                </ul>
                <a href="/propiedad?id=<?php echo $propiedad->id; ?>" class="boton boton-amarillo-block">Ver Propiedad</a>
            </div> <!--.contenido-anuncio-->
        </div> <!--.anuncio-->
        <?php } ?>
</div> <!-- contenedor-anuncios -->

