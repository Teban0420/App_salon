<h1 class="nombre-pagina" >Login</h1>
<p class="descripcion-pagina">Digita tus datos para iniciar sesión</p>

<?php  include_once __DIR__ . '/../templates/alertas.php';?>

<form class="formulario" method="POST" action="/">
   
    <div class="campo">
        <label for="email">Email</label>
        <!-- el atributo name="" nos permite leerlo con post -->
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password">
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión">

    <div class="acciones">
        <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/olvide">Olvide mi Contraseña</a>
    </div>

</form>