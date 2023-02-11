<h1 class="nombre-pagina" >Restablecer Password</h1>
<p class="descripcion-pagina">Digita tu nuevo password</p>

<?php  include_once __DIR__ . '/../templates/alertas.php';?>

<!-- si hay un error (token no valido) no 
    muestro el formulario, solamente el mensaje -->
<?php if($error) return; ?>

<form class="formulario" method="POST">
   
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password">
    </div>
    <input type="submit" class="boton" value="Restablecer">

    <div class="acciones">
        <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/">Iniciar Sesión</a>
    </div>

</form>