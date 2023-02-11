<h1 class="nombre-pagina">Olvide Mi Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu correo electronico para restablecer la contraseña</p>
<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/olvide">
    <div class="campo">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu Email">
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
    <a href="/">Inicia Sesión</a>
    <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
</div>