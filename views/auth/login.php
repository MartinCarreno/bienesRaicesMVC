<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>

        <?php endforeach;?>

        <form method="POST" class="formulario" action="/login">

        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label> 
                <input type="email" name="email" placeholder="Tu Nombre" id="email" > <!-- con la etiqueta require en HTML5 Nos advierte que tenemos que colocar algo en el form-->
                
                <label for="telefono">Password</label> 
                <input type="password" name="password" placeholder="Tu Password" id="password" > 

            </fieldset>


            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>


    </main>